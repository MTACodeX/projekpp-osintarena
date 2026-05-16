<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Carbon\Carbon;

class ScoreboardController extends Controller
{
    public function index()
    {
        return view('scoreboard.index');
    }

    public function data()
    {
        $teams = Team::withCount('solves')
            ->withMax('solves', 'solved_at')
            ->orderByDesc('score')
            ->orderByRaw('solves_max_solved_at IS NULL')
            ->orderBy('solves_max_solved_at')
            ->get()
            ->map(function ($team, $index) {
                return [
                    'rank' => $index + 1,
                    'team_name' => $team->team_name,
                    'score' => $team->score,
                    'solves' => $team->solves_count,
                    'last_solve' => $team->solves_max_solved_at
                        ? Carbon::parse($team->solves_max_solved_at)->timezone('Asia/Jakarta')->format('d M Y H:i:s') . ' WIB'
                        : '-',
                ];
            });

        return response()->json([
            'updated_at' => now()->timezone('Asia/Jakarta')->format('H:i:s') . ' WIB',
            'teams' => $teams,
        ]);
    }
}