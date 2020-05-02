<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoteTable extends Migration
{
    /**
     * 
     */
    public function up()
    {
        Schema::create('vote_options', function (Blueprint $table) 
        {
            $table->id();
            $table->string('name');
            $table->morphs('optionable');
            $table->timestamps();
        });

        Schema::create('votes', function (Blueprint $table) 
        {
            $table->id();
            $table->morphs('votable');
            $table->string('rating');
            $table->integer('user_id')->unsigned();
            $table->integer('option_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * 
     */
    public function down()
    {
        Schema::drop('vote_options');
        Schema::drop('votes');
    }
}
