<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use App\Models\ChallengeFile;
use App\Models\Flag;
use App\Models\Submission;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    private function ensureAdmin(): void
    {
        abort_unless(auth()->check() && auth()->user()->isAdmin(), 403);
    }

    public function dashboard()
    {
        $this->ensureAdmin();

        return view('admin.dashboard', [
            'usersCount' => User::where('role', 'user')->count(),
            'teamsCount' => Team::count(),
            'challengesCount' => Challenge::count(),
            'submissionsCount' => Submission::count(),
        ]);
    }

    public function challenges()
    {
        $this->ensureAdmin();

        $challenges = Challenge::withCount('solves')
            ->latest()
            ->get();

        return view('admin.challenges.index', compact('challenges'));
    }

    public function createChallenge()
    {
        $this->ensureAdmin();

        return view('admin.challenges.create');
    }

    public function storeChallenge(Request $request)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'difficulty' => ['required', 'in:Easy,Medium,Hard'],

            'points' => ['required', 'integer', 'min:1'],
            'min_points' => ['required', 'integer', 'min:1', 'lte:points'],
            'decay_per_solve' => ['required', 'integer', 'min:0'],

            'flag' => ['required', 'string', 'max:255', 'regex:/^\{.+\}$/'],
            'external_link' => ['nullable', 'url'],
            'is_active' => ['nullable'],

            'files' => ['nullable', 'array'],
            'files.*' => ['nullable', 'file', 'max:10240'],
        ], [
            'flag.regex' => 'Format flag harus seperti {jawaban}.',
            'min_points.lte' => 'Min Points tidak boleh lebih besar dari Max Points.',
        ]);

        DB::transaction(function () use ($request, $data) {
            $slug = $this->uniqueSlug($data['title']);

            $challenge = Challenge::create([
                'title' => $data['title'],
                'slug' => $slug,
                'description' => $data['description'],
                'category' => 'OSINT',
                'difficulty' => $data['difficulty'],
                'points' => $data['points'],
                'min_points' => $data['min_points'],
                'decay_per_solve' => $data['decay_per_solve'],
                'external_link' => $data['external_link'] ?? null,
                'is_active' => $request->boolean('is_active'),
            ]);

            Flag::create([
                'challenge_id' => $challenge->id,
                'flag_text' => $data['flag'],
                'is_case_sensitive' => false,
            ]);

            $this->saveUploadedFiles($request, $challenge);
        });

        return redirect('/admin/challenges')->with('success', 'Challenge berhasil dibuat.');
    }

    public function editChallenge(Challenge $challenge)
    {
        $this->ensureAdmin();

        $challenge->load(['flags', 'files']);

        return view('admin.challenges.edit', compact('challenge'));
    }

    public function updateChallenge(Request $request, Challenge $challenge)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'difficulty' => ['required', 'in:Easy,Medium,Hard'],

            'points' => ['required', 'integer', 'min:1'],
            'min_points' => ['required', 'integer', 'min:1', 'lte:points'],
            'decay_per_solve' => ['required', 'integer', 'min:0'],

            'flag' => ['required', 'string', 'max:255', 'regex:/^\{.+\}$/'],
            'external_link' => ['nullable', 'url'],
            'is_active' => ['nullable'],

            'files' => ['nullable', 'array'],
            'files.*' => ['nullable', 'file', 'max:10240'],
        ], [
            'flag.regex' => 'Format flag harus seperti {jawaban}.',
            'min_points.lte' => 'Min Points tidak boleh lebih besar dari Max Points.',
        ]);

        DB::transaction(function () use ($request, $data, $challenge) {
            $challenge->update([
                'title' => $data['title'],
                'description' => $data['description'],
                'difficulty' => $data['difficulty'],
                'points' => $data['points'],
                'min_points' => $data['min_points'],
                'decay_per_solve' => $data['decay_per_solve'],
                'external_link' => $data['external_link'] ?? null,
                'is_active' => $request->boolean('is_active'),
            ]);

            $challenge->flags()->delete();

            Flag::create([
                'challenge_id' => $challenge->id,
                'flag_text' => $data['flag'],
                'is_case_sensitive' => false,
            ]);

            $this->saveUploadedFiles($request, $challenge);
        });

        return redirect('/admin/challenges')->with('success', 'Challenge berhasil diupdate.');
    }

    public function deleteChallenge(Challenge $challenge)
    {
        $this->ensureAdmin();

        foreach ($challenge->files as $file) {
            Storage::disk('public')->delete($file->file_path);
        }

        $challenge->delete();

        return back()->with('success', 'Challenge berhasil dihapus.');
    }

    public function users()
    {
        $this->ensureAdmin();

        $users = User::with('team')->latest()->get();

        return view('admin.users.index', compact('users'));
    }

    public function submissions()
    {
        $this->ensureAdmin();

        $submissions = Submission::with(['user', 'team', 'challenge'])
            ->latest()
            ->limit(100)
            ->get();

        return view('admin.submissions.index', compact('submissions'));
    }

    private function uniqueSlug(string $title): string
    {
        $slug = Str::slug($title);

        if ($slug === '') {
            $slug = 'challenge';
        }

        $originalSlug = $slug;
        $counter = 1;

        while (Challenge::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function saveUploadedFiles(Request $request, Challenge $challenge): void
    {
        if (! $request->hasFile('files')) {
            return;
        }

        foreach ($request->file('files') as $uploadedFile) {
            if (! $uploadedFile || ! $uploadedFile->isValid()) {
                continue;
            }

            $path = $uploadedFile->store('challenges', 'public');

            ChallengeFile::create([
                'challenge_id' => $challenge->id,
                'original_name' => $uploadedFile->getClientOriginalName(),
                'file_name' => basename($path),
                'file_path' => $path,
                'file_type' => $uploadedFile->getMimeType(),
                'file_size' => $uploadedFile->getSize(),
                'uploaded_at' => now(),
            ]);
        }
    }
}