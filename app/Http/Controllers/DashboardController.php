<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Solve;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $team = $user->team;

        return view('dashboard.index', [
            'team' => $team,
            'totalChallenges' => Challenge::where('is_active', true)->count(),
            'totalSolves' => Solve::where('team_id', $team->id)->count(),
        ]);
    }
}