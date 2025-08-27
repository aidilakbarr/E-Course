<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateKrsPdf;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class KrsController extends Controller
{
    // Menampilkan halaman KRS
    public function index()
    {
        $mahasiswaId = Auth::user()->mahasiswa->id;

        $matakuliah = MataKuliah::all()->map(fn($matkul) => [
            'id' => $matkul->id,
            'kode' => $matkul->kode,
            'nama' => $matkul->nama,
            'sks' => $matkul->sks,
            'semester' => $matkul->semester,
            'hari' => $matkul->hari,
            'jam_mulai' => $matkul->jam_mulai,
            'jam_selesai' => $matkul->jam_selesai,
        ]);

        $krs = Krs::with('matakuliahs')
            ->where('mahasiswa_id', $mahasiswaId)
            ->where('status', 'DRAFT')
            ->first();

        return Inertia::render('public/krs/index', [
            'matakuliah' => $matakuliah,
            'krs' => $krs ? [
                'id' => $krs->id,
                'matakuliahs' => $krs->matakuliahs->map(fn($matkul) => [
                    'id' => $matkul->id,
                    'kode' => $matkul->kode,
                    'nama' => $matkul->nama,
                    'sks' => $matkul->sks,
                    'semester' => $matkul->semester,
                    'hari' => $matkul->hari,
                    'jam_mulai' => $matkul->jam_mulai,
                    'jam_selesai' => $matkul->jam_selesai,
                ]),
            ] : null,
        ]);
    }

    // Simpan KRS sebagai draft
    public function store(Request $request)
    {
        $request->validate([
            'matakuliah_ids' => 'required|array',
            'matakuliah_ids.*' => 'exists:mata_kuliahs,id',
        ]);

        $mahasiswa = Mahasiswa::where('user_id', auth()->id())->firstOrFail();

        $krs = Krs::firstOrCreate([
            'mahasiswa_id' => $mahasiswa->id,
            'status' => 'DRAFT',
        ]);

        $krs->matakuliahs()->syncWithoutDetaching($request->matakuliah_ids);

        return redirect()->back()
            ->with('success', 'KRS berhasil disimpan sebagai draft.');
    }

    // Submit KRS
    public function submit(Request $request)
    {
        $mahasiswa = Mahasiswa::where('user_id', auth()->id())->firstOrFail();

        $krs = Krs::with('matakuliahs')
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'DRAFT')
            ->firstOrFail();

        if ($krs->matakuliahs->isEmpty()) {
            return redirect()->back()
                ->with('error', 'KRS belum memiliki mata kuliah yang dipilih.');
        }

        $krs->status = 'SUBMITTED';
        $krs->save();

        return redirect()->back()
            ->with('success', 'KRS berhasil disubmit.');
    }

    // Hapus matakuliah dari KRS
    public function destroy(Krs $krs, MataKuliah $matakuliah)
    {
        $krs->matakuliahs()->detach($matakuliah->id);

        return redirect()->back()
            ->with('success', 'Matakuliah berhasil dihapus dari KRS.');
    }

    public function krs_pdf($krsId)
    {
        GenerateKrsPdf::dispatch((int) $krsId);
        return back()->with('success', 'PDF sedang diproses...');
    }

    public function download_pdf($krsId)
    {
        $krs = Krs::findOrFail($krsId);

        if (!$krs->pdf_generated) {
            return response()->json(['ready' => false], 202);
        }

        $filePath = 'pdf/krs_' . $krs->id . '.pdf';

        if (!Storage::disk('public')->exists($filePath)) {
            return response()->json(['error' => 'PDF belum tersedia.'], 404);
        }

        return response()->file(storage_path('app/public/' . $filePath));
    }
}
