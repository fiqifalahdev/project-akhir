<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

enum Role: string
{
    case PEMBUDIDAYA = 'pembudidaya';
    case PENGEPUL = 'pengepul';
}

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
            'gender' => ['required', Rule::in(['Laki-laki', 'Perempuan'])],
            'role' => ['required', Rule::enum(Role::class)],
            'birthdate' => 'required',
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
            'email.unique' => 'Email sudah terdaftar!',
            'phone.required' => 'Nomor telepon harus diisi!',
            'phone.max' => 'Nomor telepon maksimal 12 angka!',
            'gender.required' => 'Jenis Kelamin harus diisi!',
            'role.required' => 'Peran harus diisi!',
            'birthdate.required' => 'Tanggal lahir harus diisi!',
            'password.required' => 'Kata Sandi harus diisi!',
            'password.confirmed' => 'Konfirmasi Kata Sandi tidak sesuai!',
            'password_confirmation.required' => 'Konfirmasi Kata Sandi harus diisi!',
        ];
    }
}
