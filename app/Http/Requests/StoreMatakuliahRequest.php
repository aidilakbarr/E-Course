<?php

namespace App\Http\Requests;

use App\Models\MataKuliah;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreMatakuliahRequest extends FormRequest
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
        return [
            'kode' => ['required', 'string', 'max:20'],
            'nama' => ['required', 'string', 'max:100'],
            'semester' => ['required', 'integer'],
            'sks' => ['required', 'integer', 'in:2,3,4'],
            'dosen_id' => ['required', 'exists:dosens,id'],
            'kelas' => ['required', 'string', 'max:10'],
            'kapasitas' => ['required', 'integer', 'min:1'],
            'hari' => ['required', 'string'],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i'],
            'ruangan' => ['required', 'string', 'max:20'],
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
                ->where(function ($query) use ($jamMulai, $jamSelesai) {
                    $query
                        ->whereBetween('jam_mulai', [$jamMulai, $jamSelesai])
                        ->orWhereBetween('jam_selesai', [$jamMulai, $jamSelesai])
                        ->orWhere(function ($q) use ($jamMulai, $jamSelesai) {
                            $q->where('jam_mulai', '<=', $jamMulai)
                                ->where('jam_selesai', '>=', $jamSelesai);
                        });
                })
                ->exists();

            if ($bentrok) {
                $validator->errors()->add('day', 'Jadwal bentrok dengan mata kuliah lain di ruangan ini.');
            }
        });
    }
}
