<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
    public function playersData(): BelongsToMany
    {
        return $this->belongsToMany(PlayerUser::class , 'room__user' , 'id_player' , 'id_room');
    }
}
