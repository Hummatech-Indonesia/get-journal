<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email',
            'identity_number' => 'nullable',
            'gender' => 'required|string',
            'classroom_id' => 'required|exists:classrooms,id',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'gender.required' => 'Jenis kelamin tidak boleh kosong',
            'gemder.string' => 'Jenis kelamin harus berupa string',
            'classroom_id.required' => 'Kelas tidak boleh kosong',
            'classroom_id.exists' => 'Kelas tidak ditemukan',
        ];
    }
}
