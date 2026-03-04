<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BattleRound extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'battle_id', 'round_number', 'attacker', 'defender',
        'damage', 'defender_remaining_health', 'skill_used', 'log_message'
    ];

    public function battle()
    {
        return $this->belongsTo(Battle::class);
    }
}
