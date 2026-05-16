<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:6'],
            'team_name' => ['nullable', 'string', 'max:50', 'unique:teams,team_name'],
        ]);

        $teamName = trim($data['team_name'] ?? '');

        if ($teamName === '') {
            $teamName = $this->generateUniqueTeamName();
            $teamNameType = 'random';
        } else {
            $teamNameType = 'custom';
        }

        $user = User::create([
            'username' => $data['username'],
            'name' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
        ]);

        Team::create([
            'user_id' => $user->id,
            'team_name' => $teamName,
            'team_name_type' => $teamNameType,
            'score' => 0,
        ]);

        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Akun berhasil dibuat.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials)) {
            return back()->withErrors([
                'username' => 'Username atau password salah.',
            ])->onlyInput('username');
        }

        $request->session()->regenerate();

        if (auth()->user()->isAdmin()) {
            return redirect('/admin');
        }

        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function generateUniqueTeamName(): string
    {
        $first = ['Silent', 'Shadow', 'Cyber', 'Hidden', 'Ghost', 'Digital', 'Crimson', 'Dark', 'Unknown', 'Broken'];
        $second = ['Hunter', 'Eagle', 'Fox', 'Raven', 'Wolf', 'Agent', 'Seeker', 'Phantom', 'Falcon', 'Tracker'];

        do {
            $name = $first[array_rand($first)] . ' ' . $second[array_rand($second)] . rand(10, 99);
        } while (Team::where('team_name', $name)->exists());

        return $name;
    }
}