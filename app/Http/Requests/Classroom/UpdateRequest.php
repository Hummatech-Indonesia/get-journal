<?php

namespace App\Http\Requests\Classroom;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'code' => ['string', Rule::unique('lessons')->ignore($this->id)],
            'limit' => 'required|integer',
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
            'name.string' => 'Nama harus berupa string',
            'code.required' => 'Kode tidak boleh kosong',
            'code.string' => 'Kode harus berupa string',
            'code.unique' => 'Kode sudah terdaftar',
            'limit.required' => 'Batas peserta tidak boleh kosong',
            'limit.integer' => 'Batas peserta harus berupa angka',
        ];
    }
}
