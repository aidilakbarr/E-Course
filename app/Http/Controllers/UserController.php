<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\FileUploadService;
use App\Services\UserService;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    protected UserService $userService;

    protected UserRepository $userRepository;

    public function __construct(UserService $userService, UserRepository $userRepository)
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $search = $request->query('search');
        $users = $this->userRepository->searchAndPaginate($search);

        return Inertia::render('admin/users/index', [
            'users' => $users,
            'filters' => ['search' => $search],
        ]);
    }

    public function create()
    {
        return Inertia::render('admin/users/create');

    }

    public function store(UserStoreRequest $request)
    {
        try {
            $data = $request->validated();
            if ($request->hasFile('profile')) {
                $data['profile'] = $request->file('profile');
            }

            $this->userService->createUser($data);

            return redirect()->route('users.index')->with('success', 'Berhasil menambahkan user');
        } catch (\Throwable $th) {
            DB::rollBack();
            return handleError($th);
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(User $user)
    {
        $userNow = $this->userRepository->findWithMahasiswaAndDosen($user->id);

        return Inertia::render(
            'admin/users/edit',
            $userNow
        );
    }

    public function update(UserStoreRequest $request, User $user)
    {
        try {
            $data = $request->validated();
            if ($request->hasFile('profile')) {
                $data['profile'] = $request->file('profile');
            }

            $this->userService->updateUser($user, $data);

            return redirect()->route('users.index')->with('success', 'Berhasil mengedit user');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage(), $th->getFile(), $th->getLine());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan, silakan coba lagi.');
        }
    }


    public function destroy(User $user)
    {
        try {
            if ($user->role === RoleEnum::ADMIN || $user->id === auth()->id()) {
                return back()->with('error', 'Tidak punya akses untuk menghapus user ini');
            }

            if ($user->profile) {
                FileUploadService::deleteFile($user->profile);
            }

            $this->userRepository->delete($user);

            return back()->with('success', 'User berhasil dihapus');
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            $user = $request->user();
            $data = $request->validated();

            $user->name = $data['name'];
            $user->email = $data['email'];

            if (!empty($data['password'])) {
                $user->password = Hash::make($data['password']);
            }

            if ($request->hasFile('profile')) {
                $user->profile = FileUploadService::uploadProfile(
                    $request->file('profile'),
                    $user->profile
                );
            }

            $user->save();

            auth()->setUser(($user));

            return redirect()->back()->with('success', 'Profil berhasil diedit');
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()->with('error', 'Gagal mengedit user: ' . $e->getMessage());
        }
    }

    public function importMahasiswa(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        $path = $request->file('file')->store('imports');

        try {
            ImportUsersJob::dispatch($path);

            return response()->json([
                'success' => true,
                'message' => "Proses import sedang berjalan. Anda akan mendapat notifikasi setelah selesai."
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}
