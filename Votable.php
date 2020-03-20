<?php
namespace CodeForms\Repositories\Vote;

use Illuminate\Database\Eloquent\Builder;
use CodeForms\Repositories\Meta\Meta;
/**
 * @package CodeForms\Repositories\Vote\Votable
 */
trait Votable
{
    /**
     * @return Illuminate\Database\Eloquent\Model
     */
    public static function bootVotable()
    {
        static::deleted(function (self $model) {
            $model->deleteVotes();
        });

        static::creating(function (self $model) {
            $model->user_id = auth()->user()->id;
        });
    }

    /**
     * @param $rate
     * @param $option_id
     */
    public function setVote($rate, $option_id)
    {
        return $this->votes()->create([
            'rating'    => $rate,
            'option_id' => $option_id
        ]);
    }

    /**
     * 
     */
    public function deleteVotes()
    {
        return $this->votes()->delete();
    }

    /**
	 * @return Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function votes()
	{
		return $this->morphMany(Vote::class, 'votable');
	}
}