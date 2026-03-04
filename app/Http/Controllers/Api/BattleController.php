<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BattleService;
use Illuminate\Http\JsonResponse;

class BattleController extends Controller
{
    private BattleService $battleService;

    // Inject the BattleService using Laravel's dependency injection
    public function __construct(BattleService $battleService)
    {
        $this->battleService = $battleService;
    }

    /**
     * Trigger a new battle and return the results as JSON.
     */
    public function play(): JsonResponse
    {
        try {
            $battleData = $this->battleService->play();

            return response()->json([
                'status' => 'success',
                'data' => $battleData
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'The battle simulation failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
