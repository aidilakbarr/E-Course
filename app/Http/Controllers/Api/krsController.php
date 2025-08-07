<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\GenerateKrsPdf;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KrsController extends Controller
{
    public function tersedia()
    {
        $data = Matakuliah::select('id', 'kode', 'nama', 'sks', 'semester', 'hari', 'jam_mulai', 'jam_selesai')->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

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

        return response()->json([
            'success' => true,
            'message' => 'KRS disimpan sebagai draft.',
            'data' => $krs->load('matakuliahs'),
        ]);
    }


    public function terpilih()
    {
        $mahasiswaId = Auth::user()->mahasiswa->id;

        $data = Krs::with('matakuliahs')
            ->where('mahasiswa_id', $mahasiswaId)
            ->get()
            ->flatMap(function ($krs) {
                return [
                    'krs_id' => $krs->id,
                    'matakuliahs' => $krs->matakuliahs->map(function ($matkul) {
                        return [
                            'id' => $matkul->id,
                            'kode' => $matkul->kode,
                            'nama' => $matkul->nama,
                            'sks' => $matkul->sks,
                            'semester' => $matkul->semester,
                            'hari' => $matkul->hari,
                            'jam_mulai' => $matkul->jam_mulai,
                            'jam_selesai' => $matkul->jam_selesai,
                        ];
                    })
                ];
            });


        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function submit(Request $request)
    {
        $mahasiswa = Mahasiswa::where('user_id', auth()->id())->firstOrFail();

        $krs = Krs::where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'DRAFT')
            ->first();

        if (!$krs || $krs->matakuliahs()->count() === 0) {
            return response()->json([
                'success' => false,
                'message' => 'KRS belum memiliki mata kuliah yang dipilih.',
            ], 400);
        }

        $krs->status = 'SUBMITTED';
        $krs->save();

        return response()->json([
            'success' => true,
            'message' => 'KRS berhasil disubmit.',
            'data' => $krs->load('matakuliahs'),
        ]);
    }


    public function destroy(Krs $krs, Matakuliah $matakuliah)
    {
        $krs->matakuliahs()->detach($matakuliah->id);

        return response()->json([
            'success' => true,
            'message' => 'Matakuliah berhasil dihapus dari KRS.'
        ]);
    }

    public function krs_pdf($krsId)
    {
        GenerateKrsPdf::dispatch((int) $krsId);
        return response()->json(['message' => 'Sedang diproses.']);
    }

    public function download_pdf($krsId)
    {
        $krs = Krs::findOrFail($krsId);
        $filePath = 'pdf/krs_' . $krs->id . '.pdf';

        if (!Storage::disk('public')->exists($filePath)) {
            return response()->json(['error' => 'PDF belum tersedia.'], 404);
        }

        return response()->file(storage_path('app/public/' . $filePath));
    }


}
