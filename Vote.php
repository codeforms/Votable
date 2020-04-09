<?php 
namespace CodeForms\Repositories\Vote;

use Illuminate\Database\Eloquent\{Model};
/**
 * @package CodeForms\Repositories\Vote\Vote
 */
class Vote extends Model
{
	/**
     * 
     */
	protected $table = 'votes';

	/**
	 * 
	 */
	protected $fillable = ['rating', 'user_id', 'option_id'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($vote) {
            $vote->user_id = auth()->user()->id;
        });
    }

    /**
     * 
     */
    public function option()
    {
        return $this->belongsTo(Option::class, 'option_id', 'id');
    }

    /**
     * @return Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function votable()
    {
        return $this->morphTo();
    }
}