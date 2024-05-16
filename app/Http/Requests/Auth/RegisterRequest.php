<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|same:password',
            'name' => 'required|string',
            'identity_number' => 'string|unique:profiles,identity_number',
            'gender' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 6 karakter',
            'confirm_password.required' => 'Konfirmasi password tidak boleh kosong',
            'confirm_password.same' => 'Konfirmasi password tidak sama dengan password',
            'name.required' => 'Nama tidak boleh kosong',
            'identity_number.unique' => 'Nomor identitas sudah terdaftar',
            'identity_number.string' => 'Nomor identitas harus berupa string',
            'gender.required' => 'Jenis kelamin tidak boleh kosong',
        ];
    }
}
