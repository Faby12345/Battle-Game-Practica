<?php

use App\Models\Battle;
use App\Models\BattleParticipant;
use App\Models\BattleRound;
use App\Models\Character;

/**
 * The main method to trigger a new game.
 */
class BattleService
{


    /**
     * The main method to trigger a new game.
     */
    public function play()
    {
        // Load the base characters from the DB
        $kratosModel = Character::where('name', 'Kratos')->first();
        $monsterModel = Character::where('name', 'Wild Monster')->first();

        // Initialize with random stats within their ranges
        $kratos = $this->initializeStats($kratosModel);
        $monster = $this->initializeStats($monsterModel);

        //  Create the Battle record
        $battle = Battle::create(['total_rounds' => 0, 'winner' => null]);

        // Save initial stats to battle_participants table
        $this->saveParticipant($battle->id, $kratosModel, $kratos);
        $this->saveParticipant($battle->id, $monsterModel, $monster);

        // Determine who attacks first
        $attacker = $this->determineFirstAttacker($kratos, $monster);
        $defender = ($attacker['name'] === 'Kratos') ? $monster : $kratos;

        // The Battle Loop (Max 15 rounds) [
        for ($round = 1; $round <= 15; $round++) {
            $this->executeTurn($battle->id, $round, $attacker, $defender);

            // Check for Game Over
            if ($defender['remaining_health'] <= 0) {
                break;
            }

            // Switch roles for the next turn [cite: 30, 31]
            $temp = $attacker;
            $attacker = $defender;
            $defender = $temp;
        }

        //  Declare Winner and update battle
        $winner = $kratos['remaining_health'] > 0 && $monster['remaining_health'] <= 0 ? 'Kratos'
            : ($monster['remaining_health'] > 0 && $kratos['remaining_health'] <= 0 ? 'Wild Monster' : 'Draw');

        $battle->update([
            'winner' => $winner,
            'total_rounds' => min($round, 15)
        ]);

        // Return the full battle history for frontend
        return Battle::with(['participants', 'rounds'])->find($battle->id);
    }

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

    /**
     * Helper to save participants.
     */
    private function saveParticipant($battleId, $model, $stats)
    {
        BattleParticipant::create([
            'battle_id' => $battleId,
            'character_id' => $model->id,
            'name' => $stats['name'],
            'type' => $stats['type'],
            'initial_health' => $stats['health'],
            'remaining_health' => $stats['remaining_health'],
            'strength' => $stats['strength'],
            'defence' => $stats['defence'],
            'speed' => $stats['speed'],
            'luck' => $stats['luck'],
        ]);
    }
    /**
     * Executes a single turn, calculating damage, luck, and skills.
     */
    private function executeTurn($battleId, $round, &$attacker, &$defender)
    {
        $logMessage = "{$attacker['name']} attacks {$defender['name']}! ";
        $skillUsed = null;

        //  Check if defender gets lucky and dodges
        if (rand(1, 100) <= $defender['luck']) {
            $logMessage .= "{$defender['name']} got lucky and dodged the attack! No damage taken.";
            $this->logRound($battleId, $round, $attacker, $defender, 0, null, $logMessage);
            return; // Turn ends
        }

        // Base Damage Calculation
        $damage = $attacker['strength'] - $defender['defence'];
        if ($damage < 0) $damage = 0; // Prevent healing from negative damage


        // Check Attacker Skills (Rapid Fire)
        $attacksCount = 1;
        if ($attacker['name'] === 'Kratos' && rand(1, 100) <= 15) {
            $skillUsed = 'Rapid fire';
            $attacksCount = 2;
            $logMessage .= "Kratos used Rapid fire! Striking twice! ";
        }

        // 4. Check Defender Skills (Magic Armour)
        if ($defender['name'] === 'Kratos' && rand(1, 100) <= 15) {
            $skillUsed = $skillUsed ? $skillUsed . ' & Magic armour' : 'Magic armour';
            $damage = (int)($damage / 2);
            $logMessage .= "Kratos used Magic armour! Damage halved. ";
        }

        // Apply Damage
        $totalDamage = $damage * $attacksCount;
        $defender['remaining_health'] -= $totalDamage;
        if ($defender['remaining_health'] < 0) $defender['remaining_health'] = 0;

        $logMessage .= "Dealt {$totalDamage} damage.";

        // Log the result
        $this->logRound($battleId, $round, $attacker, $defender, $totalDamage, $skillUsed, $logMessage);
    }

}
