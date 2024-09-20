<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
            'email' => ['required', 'email', Rule::unique('users')->ignore(auth()->id())],
            'identity_number' => ['required', 'numeric', Rule::unique('profiles')->ignore(auth()->user()->profile->id)],
            'birthdate' => 'date',
            'gender' => 'required',
            'address' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            'name.required' => 'Nama wajib diisi',
            'name.string' => 'Nama harus berupa string',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'identity_number.required' => 'Nomor identitas wajib diisi',
            'identity_number.numeric' => 'Nomor identitas harus berupa angka',
            'identity_number.unique' => 'Nomor identitas sudah terdaftar',
            'birthdate.date' => 'Tanggal lahir harus berupa tanggal',
            'gender.required' => 'Jenis kelamin wajib diisi',
            'address.required' => 'Alamat wajib diisi',
            'address.string' => 'Alamat harus berupa string',
            'photo.image' => 'Foto harus berupa gambar',
            'photo.mimes' => 'Foto harus berformat jpeg, png, jpg, gif, atau svg',
            'photo.max' => 'Foto maksimal 2MB',
        ];
    }

    public function prepareForValidation()
    {
        if(!$this->gender) $this->merge(["gender" => "male"]);
        if(!$this->identity_number) $this->merge(["identity_number" => (int)date('Ymdhms')]);
    }
}
