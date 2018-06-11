<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
