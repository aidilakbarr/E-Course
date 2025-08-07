<?php
namespace App\Jobs;

use App\Models\Krs;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GenerateKrsPdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $krsId;

    /**
     * Create a new job instance.
     */
    public function __construct(int $krsId)
    {
        $this->krsId = $krsId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $krs = Krs::with(['mahasiswa.user', 'matakuliahs'])->findOrFail($this->krsId);
        $mahasiswa = $krs->mahasiswa;


        $pdf = Pdf::loadView('pdf.krs', compact('krs', 'mahasiswa'));

        $fileName = 'krs_tes' . $krs->id . '.pdf';
        Storage::disk('public')->put("pdf/{$fileName}", $pdf->output());

        // Simpan path di database 
        // $krs->update([
        //     'pdf_path' => "pdf/{$fileName}"
        // ]);

        // bisa kirim email ke mahasiswa kalau perlu
    }
}
