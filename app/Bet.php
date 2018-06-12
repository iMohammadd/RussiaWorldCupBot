<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Bet
 *
 * @property int $id
 * @property int $profile_id
 * @property int $match_id
 * @property int $result_one
 * @property int $result_two
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Match $match
 * @property-read \App\Profile $profile
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bet whereMatchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bet whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bet whereResultOne($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bet whereResultTwo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bet whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Bet extends Model
{
    protected $fillable = ['result_one', 'result_two', 'profile_id', 'match_id'];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function match()
    {
        return $this->belongsTo(Match::class);
    }
}
