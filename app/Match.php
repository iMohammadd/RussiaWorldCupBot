<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Match
 *
 * @property int $id
 * @property int $team_one
 * @property int $team_two
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $start_at
 * @property string $time
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Match whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Match whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Match whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Match whereTeamOne($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Match whereTeamTwo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Match whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Match whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Match extends Model
{
    protected $fillable = ['start_at', 'time'];

    /*public function team_one()
    {
        return $this->belongsTo('App\Team', 'team_one', 'id');
    }

    public function team_two()
    {
        return $this->belongsTo('App\Team', 'team_two', 'id');
    }*/

    public function scopeActive($query)
    {
        $date = Carbon::now()->toDateString();
        $time = Carbon::now()->toTimeString();

        return $query->where('start_at', '>=', $date)->where('time', '>=', $time);
    }
}
