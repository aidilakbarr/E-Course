<?php

namespace App\Http\Controllers\api;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Jobs\ImportUsersJob;
use App\Models\Dosen;
use App\Models\User;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $start = microtime(true);
        $user = auth()->user();
        $search = $request->query('search');
        $page = $request->query('page', 1);

        $cacheKey = "users_{$search}_page_{$page}";

        $users = Cache::remember(
            $cacheKey,
            now()->addMinutes(10),
            fn () => User::search($search)
                ->latest()
                ->paginate(5)
                ->withQueryString()
        );

        $time = microtime(true) - $start;

        return response()->json([
            'response-time' => $time,
            'success' => true,
            'message' => 'Daftar User ditemukan',
            'pagination' => [
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
                'prev_page_url' => $users->previousPageUrl(),
                'next_page_url' => $users->nextPageUrl(),
            ],
            'data' => UserResource::collection($users),
            'user' => new UserResource($user),
        ], 200);
    }

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

            return response()->json([
                'success' => true,
                'message' => 'User created successfully.',
                'data' => new UserResource($user),
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'User created failed.',
                'error' => $th->getMessage(),
            ], 500);
        }

    }

    public function show(User $user)
    {
        return response()->json([
            'success' => true,
            'data' => new UserResource($user),
        ]);
    }

    public function update(UserStoreRequest $request, User $user)
    {
        $data = $request->validated();

        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        if ($request->hasFile('profile_url')) {
            $user->profile = FileUploadService::uploadProfile($request->file('profile_url'), $user->profile);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'user berhasil diperbarui',
            'user' => new UserResource($user),
        ]);
    }

    public function destroy(user $user)
    {
        try {
            $userNow = auth()->user();
            if (
                $user->role == ! RoleEnum::ADMIN &&
                $user->id !== $userNow->id
            ) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak punya akses untuk menghapus user ini',
                ], 403);
            }

            if ($user->profile) {
                FileUploadService::deleteFile($user->profile);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Course berhasil dihapus',
            ]);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus course',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $data = $request->validated();

            $user->name = $data['name'];
            $user->email = $data['email'];

            if (! empty($data['password'])) {
                $user->password = Hash::make($data['password']);
            }

            if ($request->hasFile('profile')) {
                $user->profile = FileUploadService::uploadProfile($request->file('profile'), $user->profile);
            }

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diperbarui',
                'user' => new UserResource($user),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui profil',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getDosens()
    {
        $dosens = Dosen::with('user')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar dosen berhasil diambil',
            'data' => $dosens,
        ]);
    }

    public function importMahasiswa(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $path = $request->file('file')->store('imports');

        try {
            ImportUsersJob::dispatch($path);

            return response()->json([
                'success' => true,
                'message' => 'Proses import sedang berjalan. Anda akan mendapat notifikasi setelah selesai.',
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
