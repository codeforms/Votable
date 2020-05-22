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
            $model->deleteVoteOptions();
        });
    }

    /**
     * @param array $options
     * 
     * @return mixed
     */
    public function newVoteOption(array $options = [])
    {
        if((bool)count($options))
            foreach ($options as $option)
                return $this->voteOptions()->create(['name' => $option]);

        return null;
    }

    /**
     * @param $option_id
     * @param $name
     */
    public function updateVoteOption($option_id, $name)
    {
        return $this->voteOptions()->where('id', $option_id)->update([
            'name' => $name
        ]);
    }

    /**
     * @return bool
     */
    public function hasVoteOptions(): bool
    {
        return (bool) $this->voteOptions()->count();
    }

    /**
     * @param $option_id
     */
    public function deleteVoteOption($option_id)
    {
        return $this->voteOptions()->where('id', $option_id)->delete();
    }

    /**
     * 
     */
    public function deleteVoteOptions()
    {
        return $this->voteOptions()->delete();
    }

    /**
     * @return Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function voteOptions()
    {
        return $this->morphMany(Option::class, 'optionable');
    }
}