<?php

namespace Tests\Feature;

use App\Models\Battle;
use App\Services\BattleService;
use Database\Seeders\GameDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BattleServiceTest extends TestCase
{
    // make sure our database is clean before the tests
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Before every test, we need Kratos and the Monster in the database!
        $this->seed(GameDataSeeder::class);
    }

    /**
     * Test 1: Ensure the game runs start to finish and saves data.
     */
    public function test_a_battle_can_be_played_to_completion()
    {
        $service = new BattleService();
        $battle = $service->play();

        //  Assert the battle object was returned
        $this->assertInstanceOf(Battle::class, $battle);

        //  Assert a winner was declared (or a Draw)
        $this->assertNotNull($battle->winner);

        //  Assert the game didn't exceed 15 rounds
        $this->assertLessThanOrEqual(15, $battle->total_rounds);

        //. Assert exactly 2 participants were saved (Kratos and Monster)
        $this->assertCount(2, $battle->participants);

        //  Assert that round logs were created
        $this->assertGreaterThan(0, $battle->rounds->count());
    }
}
