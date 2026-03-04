<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BattleParticipant extends Model
{
    // Your battle_participants table has NO timestamp columns at all
    public $timestamps = false;

    protected $fillable = [
        'battle_id', 'character_id', 'name', 'type',
        'initial_health', 'remaining_health', 'strength',
        'defence', 'speed', 'luck'
    ];

    public function battle()
    {
        return $this->belongsTo(Battle::class);
    }

    public function character()
    {
        return $this->belongsTo(Character::class);
    }
}
