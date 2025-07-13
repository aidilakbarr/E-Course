<?php

namespace App\Http\Requests;

use App\Enums\StatusCourseEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCourseRequest extends FormRequest
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
    //    dd($this->all());
    $isUpdate = $this->method() === 'PUT' || $this->method() === 'PATCH';

    return [
        'thumbnail'   => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:2048',
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'teacher'  => 'required',
        'start_on'  => 'required|date|after_or_equal:today',
        'ends_on'    => 'required|date|after:start_date',
        'kuota'       => 'required|integer|min:1',
        'status'      =>  [
                'required',
                Rule::in(array_column(StatusCourseEnum::cases(), 'value'))
            ],
    ];
}


}
