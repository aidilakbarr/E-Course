<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UserStoreRequest;
use App\Jobs\ImportUsersJob;
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
        try {
            $search = $request->query('search');
            $users = $this->userRepository->searchAndPaginate($search);

            return Inertia::render('admin/users/index', [
                'users' => $users,
                'filters' => ['search' => $search],
            ]);
        } catch (\Throwable $th) {
            return handleError($th);
        }
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
            return handleError($th);
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
        } catch (\Throwable $th) {
            report($th);
            return handleError($th);
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
                $user->password = $data['password'];
            }

            if ($request->hasFile('profile')) {
                $user->profile = FileUploadService::uploadProfile(
                    $request->file('profile'),
                    $user->profile
                );
            }

            $user->save();
            return redirect()->back()->with('success', 'Profil berhasil diedit');
        } catch (\Throwable $th) {
            report($th);
            return handleError($th);
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);
        $path = $request->file('file')->store('imports');
        try {
            ImportUsersJob::dispatch($path);
            return redirect()->back()->with('success', 'Import Berhasil');
        } catch (\Throwable $th) {
            return handleError($th);
        }
    }

}
