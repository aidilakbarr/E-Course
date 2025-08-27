<?php

namespace App\Http\Requests;

use App\Enums\RoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UserStoreRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        $userParam = $this->route('user');
        $userId = is_object($userParam) ? $userParam->id : $userParam;

        $dosenId = $userId
            ? \App\Models\Dosen::where('user_id', $userId)->value('id')
            : null;

        $rules = [
            'profile_url' => ['sometimes', 'image', 'max:2048'],
            'name' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'email',
                $isUpdate
                ? Rule::unique('users', 'email')->ignore($userId)
                : Rule::unique('users', 'email'),
            ],
            'password' => $isUpdate ? ['nullable'] : ['required', 'min:6'],
            'role' => ['required', new Enum(RoleEnum::class)],
        ];

        if ($this->role === 'MAHASISWA') {
            $rules['nim'] = [
                'required',
                'string',
                'max:20',
                $isUpdate
                ? Rule::unique('mahasiswas', 'nim')->ignore($userId, 'user_id')
                : Rule::unique('mahasiswas', 'nim'),
            ];
            $rules['angkatan'] = ['required', 'integer'];
            $rules['prodi_mahasiswa'] = ['required', 'string'];
        }

        if ($this->role === 'DOSEN') {
            $rules['nidn'] = [
                'required',
                'string',
                'max:30',
                $isUpdate
                ? Rule::unique('dosens', 'nidn')->ignore($dosenId)
                : Rule::unique('dosens', 'nidn'),
            ];
            $rules['prodi'] = ['required', 'string'];
        }

        return $rules;
    }
}
