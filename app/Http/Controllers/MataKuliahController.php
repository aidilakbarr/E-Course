<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditMatakuliahRequest;
use App\Http\Requests\StoreMatakuliahRequest;
use App\Models\Dosen;
use App\Models\MataKuliah;
use Inertia\Inertia;

class MatakuliahController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(MataKuliah::class, 'matakuliah');
    }
    public function index()
    {
        try {
            $search = request('search');
            $data = MataKuliah::with('dosen.user')
                ->search($search)
                ->paginate(5)
                ->withQueryString();

            return Inertia::render('admin/matakuliah/index', [
                'matakuliahs' => $data,
                'filters' => [
                    'search' => $search,
                ],
            ]);
        } catch (\Throwable $th) {
            return handleError($th);
        }
    }

    public function create()
    {
        try {
            $dosens = Dosen::with('user')
                ->latest()
                ->get();
            return Inertia::render('admin/matakuliah/create', ['dosens' => $dosens]);
        } catch (\Throwable $th) {
            return handleError($th);
        }
    }

    public function store(StoreMatakuliahRequest $request)
    {
        try {
            $data = $request->validated();
            Matakuliah::create($data);
            return redirect()->back()->with('success', 'Matakuliah berhasil ditambahkan');
        } catch (\Throwable $th) {
            report($th);
            return handleError($th);
        }
    }

    public function edit(Matakuliah $matakuliah)
    {
        try {
            $dosens = Dosen::with('user')->get();
            return Inertia::render('admin/matakuliah/edit', ['matakuliah' => $matakuliah, 'dosens' => $dosens]);
        } catch (\Throwable $th) {
            return handleError($th);
        }
    }

    public function update(EditMatakuliahRequest $request, Matakuliah $matakuliah)
    {
        try {
            $matakuliah->update($request->validated());

            return redirect()->route('matakuliah.index')
                ->with('success', 'Matakuliah berhasil di edit');
        } catch (\Throwable $th) {
            return handleError($th);
        }
    }

    public function destroy(Matakuliah $matakuliah)
    {
        try {
            $matakuliah->delete();
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } catch (\Throwable $th) {
            return handleError($th);
        }
    }
}
