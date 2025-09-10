<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditMatakuliahRequest;
use App\Http\Requests\StoreMatakuliahRequest;
use App\Models\MataKuliah;
use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search = $request->query('search');

        $matakuliah = MataKuliah::with('dosen.user')
            ->search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return response()->json([
            'status' => 'success',
            'data' => $matakuliah,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMatakuliahRequest $request)
    {
        try {
            $data = $request->validated();
            $matakuliah = Matakuliah::create($data);

            return response()->json([
                'success' => true,
                'data' => $matakuliah,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan course',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Matakuliah $matakuliah)
    {
        return response()->json([
            'success' => true,
            'data' => $matakuliah,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditMatakuliahRequest $request, Matakuliah $matakuliah)
    {
        $matakuliah->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Matakuliah berhasil di edit',
            'matakuliah' => $matakuliah,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matakuliah $matakuliah)
    {
        $matakuliah->delete();

        return response()->json([
            'success' => true,
            'message' => 'Matakuliah berhasil dihapus',
        ]);
    }
}
