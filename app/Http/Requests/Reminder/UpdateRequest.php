<?php

namespace App\Http\Requests\Reminder;

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
            'title' => 'required|string',
            'content' => 'required|string',
            'reminder_at' => 'required|date',
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
            'title.required' => 'Judul tidak boleh kosong',
            'title.string' => 'Judul harus berupa string',
            'content.required' => 'Konten tidak boleh kosong',
            'content.string' => 'Konten harus berupa string',
            'reminder_at.required' => 'Waktu pengingat tidak boleh kosong',
            'reminder_at.date' => 'Waktu pengingat harus berupa tanggal',
        ];
    }
}
