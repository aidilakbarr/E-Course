<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // return response()->json([
        //     'success' => true,
        //     'message' => 'KRS disimpan sebagai draft.',
        //     'data' => $mahasiswa,
        // ]);
        $krs = Krs::firstOrCreate([
            'mahasiswa_id' => $mahasiswa->id,
            'status' => 'DRAFT',
        ]);

        $krs->matakuliahs()->sync($request->matakuliah_ids);

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
                return $krs->matakuliahs->map(function ($matkul) {
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
                });
            });


        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function submit(Request $request)
    {
        $request->validate([
            'matakuliah_ids' => 'required|array',
            'matakuliah_ids.*' => 'exists:matakuliahs,id',
        ]);

        $mahasiswaId = Auth::user()->mahasiswa->id;

        foreach ($request->matakuliah_ids as $matkulId) {
            Krs::updateOrCreate([
                'mahasiswa_id' => $mahasiswaId,
                'matakuliah_id' => $matkulId,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'KRS berhasil disimpan.'
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
}
