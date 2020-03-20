<?php
namespace CodeForms\Repositories\Vote;

use Illuminate\Database\Eloquent\Builder;
use CodeForms\Repositories\Meta\Meta;
/**
 * @package CodeForms\Repositories\Vote\Optionable
 */
trait Optionable
{
	/**
     * @return Illuminate\Database\Eloquent\Model
     */
    public static function bootOptionable()
    {
        static::deleted(function (self $model) {
            $model->deleteOption();
        });
    }

    /**
     * @param $name
     */
    public function newOption($name)
    {
        return $this->options()->create(['name' => $name]);
    }

    /**
     * @param $option_id
     * @param $name
     */
    public function updateOption($option_id, $name)
    {
        return $this->options()->where('id', $option_id)->update([
            'name' => $name
        ]);
    }

    /**
     * @param $id
     */
    public function deleteOption()
    {
        return $this->options()->delete();
    }

    /**
     * @return Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function options()
    {
        return $this->morphMany(Option::class, 'optionable');
    }
}