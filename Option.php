<?php 
namespace CodeForms\Repositories\Vote;

use CodeForms\Repositories\Meta\Metable;
use Illuminate\Database\Eloquent\{Model};
/**
 * @package CodeForms\Repositories\Vote\Option
 */
class Option extends Model
{
	/**
     * @link https://github.com/codeforms/Metable
	 */
	use Metable;
	
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