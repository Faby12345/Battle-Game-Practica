<?php

use App\Models\Battle;
use App\Models\BattleRound;
use App\Models\Character;

/**
 * The main method to trigger a new game.
 */
class BattleService
{

    /**
     * Generate random stats for a character based on their min/max limits.
     */
    private function initializeStats($character)
    {
        return [
            'name' => $character->name,
            'type' => $character->type,
            'health' => rand($character->min_health, $character->max_health),
            'remaining_health' => rand($character->min_health, $character->max_health), // Starts full
            'strength' => rand($character->min_strength, $character->max_strength),
            'defence' => rand($character->min_defence, $character->max_defence),
            'speed' => rand($character->min_speed, $character->max_speed),
            'luck' => rand($character->min_luck, $character->max_luck),
        ];
    }

    /**
     * Determines first attacker based on speed, falling back to luck.
     */
    private function determineFirstAttacker($kratos, $monster)
    {
        if ($kratos['speed'] > $monster['speed']) return $kratos;
        if ($monster['speed'] > $kratos['speed']) return $monster;
        // if the speed is the same for both we move on to luck
        return ($kratos['luck'] >= $monster['luck']) ? $kratos : $monster;
    }
    /**
     * Logs the details for the round
    */
    private function logRound($battleId, $round, $attacker, $defender, $damage, $skill, $message)
    {
        BattleRound::create([
            'battle_id' => $battleId,
            'round_number' => $round,
            'attacker' => $attacker['name'],
            'defender' => $defender['name'],
            'damage' => $damage,
            'defender_remaining_health' => $defender['remaining_health'],
            'skill_used' => $skill,
            'log_message' => $message
        ]);
    }


}
