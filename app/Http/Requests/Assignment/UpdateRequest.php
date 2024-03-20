<?php

namespace App\Http\Requests\Assignment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'description' => 'required|string',
            'due_date' => 'required|date',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Judul wajib diisi',
            'name.string' => 'Judul harus berupa teks',
            'description.required' => 'Deskripsi wajib diisi',
            'description.string' => 'Deskripsi harus berupa teks',
            'due_date.required' => 'Tanggal jatuh tempo wajib diisi',
            'due_date.date' => 'Tanggal jatuh tempo harus berupa tanggal',
        ];
    }
}
