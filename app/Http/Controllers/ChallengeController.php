<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Submission;
use App\Models\Solve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChallengeController extends Controller
{
    public function index()
    {
        $team = auth()->user()->team;

        $solvedIds = Solve::where('team_id', $team->id)->pluck('challenge_id')->toArray();

        $challenges = Challenge::withCount('solves')
            ->where('is_active', true)
            ->orderBy('points')
            ->get();

        return view('challenges.index', compact('challenges', 'solvedIds'));
    }

        public function show($slug)
        {
            $challenge = Challenge::with(['files', 'flags'])
                ->withCount('solves')
                ->where('slug', $slug)
                ->where('is_active', true)
                ->firstOrFail();

            $team = auth()->user()->team;

            $solved = Solve::where('team_id', $team->id)
                ->where('challenge_id', $challenge->id)
                ->exists();

            if (method_exists($challenge, 'calculatePoints')) {
                $currentPoints = $challenge->calculatePoints($challenge->solves_count);
            } else {
                $currentPoints = $challenge->points;
            }

            return view('challenges.show', compact('challenge', 'solved', 'currentPoints'));
        }

    public function submit(Request $request, Challenge $challenge)
    {
        $request->validate([
            'flag' => ['required', 'string', 'max:255'],
        ]);

        $user = auth()->user();
        $team = $user->team;
        $submittedFlag = trim($request->flag);

        $alreadySolved = Solve::where('team_id', $team->id)
            ->where('challenge_id', $challenge->id)
            ->exists();

        if ($alreadySolved) {
            return back()
                ->with('popup_type', 'info')
                ->with('popup_title', 'Sudah Solved')
                ->with('popup_message', 'Challenge ini sudah pernah kamu selesaikan.');
        }

        $isCorrect = false;

        foreach ($challenge->flags as $flag) {
            if ($flag->is_case_sensitive) {
                $isCorrect = $submittedFlag === $flag->flag_text;
            } else {
                $isCorrect = strtolower($submittedFlag) === strtolower($flag->flag_text);
            }

            if ($isCorrect) {
                break;
            }
        }

        DB::transaction(function () use ($user, $team, $challenge, $submittedFlag, $isCorrect, $request) {
            Submission::create([
                'user_id' => $user->id,
                'team_id' => $team->id,
                'challenge_id' => $challenge->id,
                'submitted_flag' => $submittedFlag,
                'is_correct' => $isCorrect,
                'ip_address' => $request->ip(),
                'submitted_at' => now(),
            ]);

            if ($isCorrect) {
                $alreadySolvedInsideTransaction = Solve::where('team_id', $team->id)
                    ->where('challenge_id', $challenge->id)
                    ->exists();

                if ($alreadySolvedInsideTransaction) {
                    return;
                }

                $solveCountBeforeCurrentUser = Solve::where('challenge_id', $challenge->id)->count();

                $pointsAwarded = $challenge->calculatePoints($solveCountBeforeCurrentUser);

                Solve::create([
                    'user_id' => $user->id,
                    'team_id' => $team->id,
                    'challenge_id' => $challenge->id,
                    'points_awarded' => $pointsAwarded,
                    'solved_at' => now(),
                ]);

                $team->increment('score', $pointsAwarded);
            }
        });

        if ($isCorrect) {
            return back()
                ->with('popup_type', 'success')
                ->with('popup_title', 'Flag Benar!')
                ->with('popup_message', 'Mantap, challenge berhasil diselesaikan.');
        }

        return back()
            ->with('popup_type', 'danger')
            ->with('popup_title', 'Flag Salah!')
            ->with('popup_message', 'Coba cek lagi clue dan jawaban kamu.');    
    }
}