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
    }

    /**
     * @param $rate
     * @param $option_id
     */
    public function setVote($rate, $option_id = null)
    {
        return $this->votes()->create([
            'rating'    => $rate,
            'option_id' => $option_id
        ]);
    }

    /**
     * @return float
     */
    public function rating(): float
    {
        return self::result(self::averageRating());
    }

    /**
     * @param int $star
     * @return string
     */
    public function ratingPercent($star = 5): float
    {
        return self::result((self::averageRating() * 100) / $star);
    }

    /**
     * @return float
     */
    public function averageRating(): float
    {
        return $this->votes()->avg('rating');
    }

    /**
     * @return float
     */
    public function sumRating(): float
    {
        return $this->votes()->sum('rating');
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
     * @access private
     * @return string
     */
    private function result($score): float
    {
        return substr(number_format($score, 4, '.', ''), 0, -1);
    }

    /**
     * @return Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }
}