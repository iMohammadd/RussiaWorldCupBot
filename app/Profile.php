<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Profile
 *
 * @property int $id
 * @property string $name
 * @property string $user
 * @property string $chat_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Bet[] $bet
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereChatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereUser($value)
 * @mixin \Eloquent
 */
class Profile extends Model
{

    protected $fillable = ['user', 'chat_id', 'name'];

    public function bet()
    {
        return $this->hasMany(Bet::class);
    }
}
