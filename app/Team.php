<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name'];

    public function home()
    {
        return $this->hasMany(Match::class, 'team_one', 'id');
    }

    public function away()
    {
        return $this->hasMany(Match::class, 'team_two', 'id');
    }
}
