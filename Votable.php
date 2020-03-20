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
        static::creating(function (self $model) {
            $model->user_id = auth()->user()->id;
        });

        static::deleted(function (self $model) {
            $model->deleteVotes();
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
     * @return bool
     */
    public function hasVotes(): bool
    {
        return (bool) self::countVotes();
    }

    /**
     * @return int
     */
    public function countVotes(): int
    {
        return $this->votes()->count();
    }

    /**
     * 
     */
    public function deleteVotes()
    {
        return $this->votes()->delete();
    }

    /**
     * @param bool $percentage
     * @param int $star
     * 
     * @return float
     */
    public function rating($percentage = false, $star = 5): float
    {
        return $percentage ? self::percentage($star) : self::score();
    }

    /**
     * @param int $star
     * @access private
     */
    private function percentage($star)
    {
        return self::result((self::average() * 100) / $star);
    }

    /**
     * @access private
     */
    private function score()
    {
        return self::result(self::average());
    }

    /**
     * @access private
     */
    private function result($score)
    {
        return substr(number_format($score, 4, '.', ''), 0, -1)
    }

    /**
     * @access private
     */
    private function average()
    {
        return self::sumRating() / self::countVotes();
    }

    /**
     * @access private
     */
    private function sumRating()
    {
        return $this->votes()->sum('rating');
    }

    /**
	 * @return Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function votes()
	{
		return $this->morphMany(Vote::class, 'votable');
	}
}