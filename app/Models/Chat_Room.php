<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat_Room extends Model
{
    use HasFactory;
    protected $table = 'chat_room';
    protected $fillable = [
        'id_player_sender',
        'id_room',
        'message',
        "is_active"
    ];
}
