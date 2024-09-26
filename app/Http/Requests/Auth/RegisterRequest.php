<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'identity_number' => 'nullable',
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
            'gender.required' => 'Jenis kelamin tidak boleh kosong',
        ];
    }

    public function prepareForValidation()
    {
        if(!$this->confirm_password) $this->merge(["confirm_password" => $this->password_confirmation]);
        if(!$this->gender) $this->merge(['gender' => 'male']);
        if(!$this->identity_number) $this->merge(["identity_number" => "0"]);
    }

    public function failedValidation(Validator $validator)
    {
        if($this->type == "school"){
            return redirect()->back()->withError($validator)->withInput();
        }else {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Invalid request, please check again',
                'data'    => $validator->errors()
            ], 422));
        }
    }
}
