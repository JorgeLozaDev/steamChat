<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
}
