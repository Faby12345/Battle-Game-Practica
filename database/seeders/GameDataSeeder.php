<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // the firstOrCreate was used fir the case if the seeder is was run twice by accident
        Character::firstOrCreate(['name' => 'Kratos'], [
            'type' => 'hero',
            'min_health' => 65, 'max_health' => 100,
            'min_strength' => 75, 'max_strength' => 90,
            'min_defence' => 40, 'max_defence' => 50,
            'min_speed' => 40, 'max_speed' => 50,
            'min_luck' => 10, 'max_luck' => 20,
        ]);

        // 2. Create the Wild Monster [cite: 19, 21, 22, 23, 24, 25]
        Character::firstOrCreate(['name' => 'Wild Monster'], [
            'type' => 'monster',
            'min_health' => 50, 'max_health' => 80,
            'min_strength' => 55, 'max_strength' => 80,
            'min_defence' => 50, 'max_defence' => 70,
            'min_speed' => 40, 'max_speed' => 60,
            'min_luck' => 30, 'max_luck' => 45,
        ]);

        // 3. Create the Skills [cite: 13, 14, 16]
        Skill::firstOrCreate(['name' => 'Rapid fire'], [
            'trigger_chance' => 15,
            'description' => "Strike twice while it's his turn to attack."
        ]);

        Skill::firstOrCreate(['name' => 'Magic armour'], [
            'trigger_chance' => 15,
            'description' => "Takes only half of the usual damage when an enemy attacks."
        ]);

    }
}
