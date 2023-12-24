<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class PlayerUser extends Model
{
    use HasFactory, HasApiTokens, Notifiable;
    protected $table = 'player_users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
    ];
    public function roomsData(): BelongsToMany
    {
        return $this->belongsToMany(Rooms_Table::class , 'room__user' , 'id_room' ,'id_player');
    }
}
