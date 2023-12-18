<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Games extends Model
{
    use HasFactory;
    protected $table = 'games';
    protected $fillable = [
        'title',
        'description',
        'id_user',
        'is_active',
    ];
}
