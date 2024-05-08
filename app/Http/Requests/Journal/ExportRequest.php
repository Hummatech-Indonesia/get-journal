<?php

namespace App\Http\Requests\Journal;

use Illuminate\Foundation\Http\FormRequest;

class ExportRequest extends FormRequest
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
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'filename' => ['required', 'string'],
            'lesson_id' => ['required', 'string', 'exists:lessons,id'],
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
            'start_date.required' => 'Tanggal mulai tidak boleh kosong',
            'start_date.date' => 'Tanggal mulai harus berupa tanggal',
            'end_date.required' => 'Tanggal selesai tidak boleh kosong',
            'end_date.date' => 'Tanggal selesai harus berupa tanggal',
            'filename.required' => 'Nama file tidak boleh kosong',
            'filename.string' => 'Nama file harus berupa string',
            'lesson_id.required' => 'ID pelajaran tidak boleh kosong',
            'lesson_id.string' => 'ID pelajaran harus berupa string',
            'lesson_id.exists' => 'ID pelajaran tidak ditemukan',
        ];
    }
}
