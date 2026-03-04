<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    // Tell Laravel to ignore the missing updated_at column
    const UPDATED_AT = null;

    protected $fillable = [
        'name', 'type', 'min_health', 'max_health',
        'min_strength', 'max_strength', 'min_defence', 'max_defence',
        'min_speed', 'max_speed', 'min_luck', 'max_luck'
    ];

    public function participants()
    {
        return $this->hasMany(BattleParticipant::class);
    }
}
