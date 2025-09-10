<?php

namespace App\Http\Requests;

use App\Models\MataKuliah;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class EditMatakuliahRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $kode = $this->input('kode');
        $id = $this->route('matakuliah')?->id;

        $exists = \App\Models\Matakuliah::where('kode', $kode)
            ->where('id', '!=', $id)
            ->exists();

        // dd($kode, $id, $exists, request()->all());
        return [
            'nama' => ['required', 'string', 'max:100'],
            'semester' => ['required', 'integer'],
            'sks' => ['required', 'integer', 'in:2,3,4'],
            'dosen_id' => ['required', 'exists:dosens,id'],
            'kelas' => ['required', 'string', 'max:10'],
            'kapasitas' => ['required', 'integer', 'min:1'],
            'hari' => ['required', 'string'],
            'ruangan' => ['required', 'string', 'max:20'],
            'jam_mulai' => ['required', 'date_format:H:i:s'],
            'jam_selesai' => ['required', 'date_format:H:i:s', 'after:jam_mulai'],

        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $hari = $this->hari;
            $ruangan = $this->ruangan;
            $jamMulai = $this->jam_mulai;
            $jamSelesai = $this->jam_selesai;
            $bentrok = MataKuliah::where('hari', $hari)
                ->where('ruangan', $ruangan)
                ->where('id', '!=', $this->route('matakuliah')?->id ?? 0)
                ->where(function ($q) use ($jamMulai, $jamSelesai) {
                    $q->where('jam_mulai', '<', $jamSelesai)
                        ->where('jam_selesai', '>', $jamMulai);
                })
                ->exists();

            // dd($hari, $ruangan, $jamMulai, $jamSelesai, $bentrok, $this->route('matakuliah')?->id, request()->all());
            if ($bentrok) {
                $validator->errors()->add('hari', 'Jadwal bentrok dengan mata kuliah lain di ruangan ini.');
            }
        });
    }
}
