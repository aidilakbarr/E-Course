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

    return [
        'thumbnail'   => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:2048',
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'instructor'  => 'nullable|exists:users,id',
        'status'      =>  [
                'required',
                Rule::in(array_column(StatusCourseEnum::cases(), 'value'))
            ],
    ];
}


}
