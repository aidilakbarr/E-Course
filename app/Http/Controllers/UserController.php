<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use App\Services\FileUploadService;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $page = $request->query('page', 1);

        $cacheKey = "users_{$search}_page_{$page}";

        $users = Cache::remember(
            $cacheKey,
            now()->addMinutes(10),
            fn() =>
            User::search($search)
                ->latest()
                ->paginate(5)
                ->withQueryString()
        );

        return Inertia::render('admin/users/index', [
            'users' => $users,
            'filters'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/users/create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();
        DB::beginTransaction();
        try {
            if ($request->hasFile('profile_url')) {
                $data['profile_url'] = FileUploadService::uploadProfile(
                    $request->file('profile_url')
                );
            }

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => $data['role'],
                'profile' => $data['profile_url'] ?? null,
                'password' => Hash::make($data['password']),
            ]);

            if ($data['role'] === RoleEnum::MAHASISWA->value) {
                $user->mahasiswa()->create([
                    'nim' => $data['nim'],
                    'angkatan' => $data['angkatan'],
                    'prodi' => $data['prodi_mahasiswa'],
                ]);
            } elseif ($data['role'] === RoleEnum::DOSEN->value) {
                $user->dosen()->create([
                    'nidn' => $data['nidn'],
                    'prodi' => $data['prodi'],
                ]);
            }

            DB::commit();

            return redirect()->route('users.index')->with('success', 'Berhasil menambahkan user');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan, silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user = User::with(['mahasiswa', 'dosen'])->findOrFail($user->id);
        return Inertia::render(
            'admin/users/edit',
            $user
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserStoreRequest $request, User $user)
    {
        $data = $request->validated();
        DB::beginTransaction();
        try {
            if ($request->hasFile('profile_url')) {
                $data['profile_url'] = FileUploadService::uploadProfile(
                    $request->file('profile_url')
                );
            }

            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => $data['role'],
                'profile' => $data['profile_url'] ?? $user->profile,
                'password' => isset($data['password']) && $data['password']
                    ? Hash::make($data['password'])
                    : $user->password,
            ]);


            if ($data['role'] === RoleEnum::MAHASISWA->value) {
                $user->mahasiswa()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nim' => $data['nim'],
                        'angkatan' => $data['angkatan'],
                        'prodi' => $data['prodi_mahasiswa'],
                    ]
                );
            } elseif ($data['role'] === RoleEnum::DOSEN->value) {
                $user->dosen()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nidn' => $data['nidn'],
                        'prodi' => $data['prodi'],
                    ]
                );
            }


            DB::commit();

            return redirect()->route('users.index')->with('success', 'Berhasil mengedit user');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage(), $th->getFile(), $th->getLine());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan, silakan coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(User $user)
    {
        try {
            $userNow = auth()->user();

            if ($user->role === RoleEnum::ADMIN || $user->id === $userNow->id) {
                return back()->with('error', 'Tidak punya akses untuk menghapus user ini');
            }

            if ($user->profile) {
                FileUploadService::deleteFile($user->profile);
            }

            $user->delete();

            return redirect()->back()->with('success', 'User berhasil dihapus');
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }
}
