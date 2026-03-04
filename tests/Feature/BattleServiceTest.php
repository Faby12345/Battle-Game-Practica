<?php

namespace Tests\Feature;

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
}
