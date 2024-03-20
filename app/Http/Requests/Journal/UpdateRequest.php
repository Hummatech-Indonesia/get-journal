<?php

namespace App\Http\Requests\Journal;

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
            'lesson_id' => 'required|exists:lessons,id',
            'date' => 'required|date',
            'title' => 'required|string',
            'description' => 'required|string',
            'sick' => 'array',
            'sick.*.profile_id' => 'required|exists:profiles,id',
            'sick.*.status' => 'required|string',
            'permit' => 'array',
            'permit.*.profile_id' => 'required|exists:profiles,id',
            'permit.*.status' => 'required|string',
            'alpha' => 'array',
            'alpha.*.profile_id' => 'required|exists:profiles,id',
            'alpha.*.status' => 'required|string',
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
            'lesson_id.required' => 'ID Pelajaran wajib diisi',
            'lesson_id.exists' => 'ID Pelajaran tidak valid',
            'date.required' => 'Tanggal wajib diisi',
            'date.date' => 'Tanggal harus berupa tanggal',
            'title.required' => 'Judul wajib diisi',
            'title.string' => 'Judul harus berupa string',
            'description.required' => 'Deskripsi wajib diisi',
            'description.string' => 'Deskripsi harus berupa string',
            'sick.*.profile_id.required' => 'ID Profil wajib diisi',
            'sick.*.profile_id.exists' => 'ID Profil tidak valid',
            'sick.*.status.required' => 'Status wajib diisi',
            'sick.*.status.string' => 'Status harus berupa string',
            'permit.*.profile_id.required' => 'ID Profil wajib diisi',
            'permit.*.profile_id.exists' => 'ID Profil tidak valid',
            'permit.*.status.required' => 'Status wajib diisi',
            'permit.*.status.string' => 'Status harus berupa string',
            'alpha.*.profile_id.required' => 'ID Profil wajib diisi',
            'alpha.*.profile_id.exists' => 'ID Profil tidak valid',
            'alpha.*.status.required' => 'Status wajib diisi',
            'alpha.*.status.string' => 'Status harus berupa string',
        ];
    }
}
