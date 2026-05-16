<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScoreboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::get('/rules', function () {
    return view('rules');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/profile', [ProfileController::class, 'index']);
    Route::put('/profile/team-name', [ProfileController::class, 'updateTeamName']);

    Route::get('/challenges', [ChallengeController::class, 'index']);
    Route::get('/challenges/{slug}', [ChallengeController::class, 'show']);
    Route::post('/challenges/{challenge}/submit', [ChallengeController::class, 'submit']);

    Route::get('/scoreboard', [ScoreboardController::class, 'index']);
    Route::get('/scoreboard/data', [ScoreboardController::class, 'data']);

    Route::get('/admin', [AdminController::class, 'dashboard']);
    Route::get('/admin/challenges', [AdminController::class, 'challenges']);
    Route::get('/admin/challenges/create', [AdminController::class, 'createChallenge']);
    Route::post('/admin/challenges', [AdminController::class, 'storeChallenge']);
    Route::get('/admin/challenges/{challenge}/edit', [AdminController::class, 'editChallenge']);
    Route::put('/admin/challenges/{challenge}', [AdminController::class, 'updateChallenge']);
    Route::delete('/admin/challenges/{challenge}', [AdminController::class, 'deleteChallenge']);

    Route::get('/admin/users', [AdminController::class, 'users']);
    Route::get('/admin/submissions', [AdminController::class, 'submissions']);
});