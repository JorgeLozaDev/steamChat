<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerUser extends Model
{
    use HasFactory;
    protected $table = 'player_users';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
