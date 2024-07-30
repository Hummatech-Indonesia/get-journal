<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class AssignTeacherRequest extends FormRequest
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
            'user_id' => 'required',
            'code' => 'required|exists:profiles,code'
        ];
    }

    public function message(): array
    {
        return [
            'user_id.required' => 'Not valid user',
            'code.required' => 'Code is invalid',
            'code.exists' => 'Code is not found'
        ];
    }

    public function prepareForValidation()
    {
        if(!$this->user_id) $this->merge(["user_id" => "-"]); 
    }
}
