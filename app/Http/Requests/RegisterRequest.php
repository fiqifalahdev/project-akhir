<?php

namespace App\Http\Requests;

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
            'name' => 'required|string|max:55',
            'email' => 'email|required|unique:users',
            'phone' => 'required|max:12',
            'address' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
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
            'name.required' => 'Nama harus diisi!',
            'email.required' => 'Email harus diisi!',
            'phone.required' => 'Nomor telepon harus diisi!',
            'phone.max' => 'Nomor telepon maksimal 12 angka!',
            'address.required' => 'Alamat harus diisi!',
            'password.required' => 'Password harus diisi!',
            'password_confirmation.required' => 'Konfirmasi password harus diisi!',
        ];
    }
}
