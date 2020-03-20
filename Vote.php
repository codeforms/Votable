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
	protected $fillable = ['votable_id', 'votable_type', 'vote', 'user_id', 'option_id'];

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