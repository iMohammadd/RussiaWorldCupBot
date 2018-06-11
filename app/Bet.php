<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
