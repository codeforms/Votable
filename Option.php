<?php 
namespace CodeForms\Repositories\Vote;

use Illuminate\Database\Eloquent\{Model};
/**
 * @package CodeForms\Repositories\Vote\Option
 */
class Option extends Model
{	
	/**
     * 
     */
	protected $table = 'vote_options';

	/**
	 * 
	 */
	protected $fillable = ['name'];

	/**
     * @return Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function optionable()
    {
        return $this->morphTo();
    }
}