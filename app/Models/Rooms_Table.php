<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rooms_Table extends Model
{
    use HasFactory;
    protected $table = 'rooms';
    protected $fillable = [
        'title',
        'description',
        'id_user',
        'is_active',
    ];
}
