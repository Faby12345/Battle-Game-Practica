<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Battle extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'winner', 'total_rounds'
    ];

    // A battle has many participants (Kratos and the Monster)
    public function participants()
    {
        return $this->hasMany(BattleParticipant::class);
    }

    // A battle has many rounds (logs)
    public function rounds()
    {
        return $this->hasMany(BattleRound::class);
    }
}
