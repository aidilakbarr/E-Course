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
    public function index()
    {
        try {
            $mahasiswaId = Auth::user()->mahasiswa->id;
            $matakuliah = MataKuliah::all();
            $krs = Krs::with('matakuliahs')
                ->where('mahasiswa_id', $mahasiswaId)
                ->whereIn('status', ['DRAFT', 'SUBMITTED'])
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
                'status' => $krs?->status
            ]);
        } catch (\Throwable $th) {
            return handleError($th);
        }
    }

    public function save(Request $request)
    {
        try {
            $request->validate([
                'matakuliah_ids' => 'required|array',
                'matakuliah_ids.*' => 'exists:mata_kuliahs,id',
            ]);


            $mahasiswa = Mahasiswa::where('user_id', auth()->id())->firstOrFail();

            $krs = Krs::Create([
                'mahasiswa_id' => $mahasiswa->id,
                'status' => 'DRAFT',
            ]);
            $krs->matakuliahs()->syncWithoutDetaching($request->matakuliah_ids);

            return redirect()->back()
                ->with('success', 'KRS berhasil disimpan sebagai draft.');
        } catch (\Throwable $th) {
            return handleError($th);
        }
    }

    public function submit(Request $request)
    {
        try {
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
        } catch (\Throwable $th) {
            return handleError($th);
        }
    }

    public function destroy(Krs $krs, MataKuliah $matakuliah)
    {
        try {
            $krs->matakuliahs()->detach($matakuliah->id);
            return redirect()->back()
                ->with('success', 'Matakuliah berhasil dihapus dari KRS.');
        } catch (\Throwable $th) {
            return handleError($th);
        }
    }

    public function pdf(Krs $krs)
    {
        try {
            $filePath = "pdf/krs_{$krs->id}.pdf";
            if (!$krs->pdf_generated || !Storage::disk('public')->exists($filePath)) {
                GenerateKrsPdf::dispatch($krs->id);
                return response('', 202);
            }

            return response()->file(storage_path("app/public/{$filePath}"));
        } catch (\Throwable $th) {
            return handleError($th);
        }
    }


    public function submitted(Request $request)
    {
        try {
            $query = Krs::with(['mahasiswa.user', 'matakuliahs'])
                ->whereIn('status', ['SUBMITTED', 'ACCEPTED']);
            if ($request->filled('search')) {
                $search = $request->search;
                $query->whereHas('mahasiswa.user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                    ->orWhereHas('mahasiswa', function ($q) use ($search) {
                        $q->where('nim', 'like', "%{$search}%");
                    });
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            $krs = $query->paginate(10)->withQueryString();
            return Inertia::render('admin/krs/index', [
                'krs' => $krs,
                'filters' => $request->only(['search', 'status']),
            ]);
        } catch (\Throwable $th) {
            return handleError($th);
        }
    }

    public function accept($krsId)
    {
        try {
            $krs = Krs::with('matakuliahs')
                ->where('id', $krsId)
                ->where('status', 'SUBMITTED')
                ->firstOrFail();
            $krs->status = 'ACCEPTED';
            $krs->save();
            return redirect()->back()
                ->with('success', 'KRS berhasil diterima.');
        } catch (\Throwable $th) {
            return handleError($th);
        }
    }

    public function reject($krsId)
    {
        try {
            $krs = Krs::with('matakuliahs')
                ->where('id', $krsId)
                ->where('status', 'REJECTED')
                ->firstOrFail();
            $krs->status = 'ACCEPTED';
            $krs->save();
            return redirect()->back()
                ->with('success', 'KRS berhasil ditolak.');
        } catch (\Throwable $th) {
            return handleError($th);
        }
    }
}
