<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'name', 'trigger_chance', 'description'
    ];
}
