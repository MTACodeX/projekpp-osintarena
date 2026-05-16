<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $team = $user->team;
        $solves = $user->solves()->with('challenge')->latest('solved_at')->get();

        return view('profile.index', compact('user', 'team', 'solves'));
    }

    public function updateTeamName(Request $request)
    {
        $request->validate([
            'team_name' => ['required', 'string', 'max:50', 'unique:teams,team_name,' . auth()->user()->team->id],
        ]);

        auth()->user()->team->update([
            'team_name' => $request->team_name,
            'team_name_type' => 'custom',
        ]);

        return back()->with('success', 'Nama tim berhasil diubah.');
    }
}