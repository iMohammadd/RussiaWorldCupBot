<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    protected $fillable = ['user', 'chat_id', 'name'];

    public function bet()
    {
        return $this->hasMany(Bet::class);
    }
}
