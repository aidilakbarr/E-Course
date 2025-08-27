<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditMatakuliahRequest;
use App\Http\Requests\StoreMatakuliahRequest;
use App\Models\Dosen;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MatakuliahController extends Controller
{
    public function index()
    {
        $search = request('search');

        $data = MataKuliah::with('dosen.user')
            ->search($search)
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('admin/matakuliah/index', [
            'matakuliahs' => $data,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }



    public function create()
    {
        $dosens = Dosen::with('user')
            ->latest()
            ->get();
        return Inertia::render('admin/matakuliah/create', ['dosens' => $dosens]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMatakuliahRequest $request)
    {
        try {
            $data = $request->validated();
            Matakuliah::create($data);
            return redirect()->back()->with('success', "Matakuliah berhasil ditambahkan");
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', "validasi gagal");
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()->with('error', "Gagal menyimpan course");
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
    public function edit(Matakuliah $matakuliah)
    {
        $dosens = Dosen::with('user')->get();
        return Inertia::render('admin/matakuliah/edit', ["matakuliah" => $matakuliah, 'dosens' => $dosens]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditMatakuliahRequest $request, Matakuliah $matakuliah)
    {
        $matakuliah->update($request->validated());
        return redirect()->route('matakuliah.index')
            ->with('success', 'Matakuliah berhasil di edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matakuliah $matakuliah)
    {
        $matakuliah->delete();
        return redirect()->back()->with("success", "Data berhasil dihapus");
    }
}
