<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BattleService;
use Illuminate\Http\JsonResponse;
use App\Models\Battle;

class BattleController extends Controller
{
    private BattleService $battleService;

    public function __construct(BattleService $battleService)
    {
        $this->battleService = $battleService;
    }

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

    public function index()
    {
        $battles = Battle::select('id', 'winner', 'total_rounds', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $battles
        ]);
    }
}
