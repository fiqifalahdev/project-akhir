<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'email' => 'required|email',
            'phone' => 'required|string',
            'birthdate' => 'required|date',
            'gender' => 'required|string',
            'address' => 'required|string',
            // Location Data
            'kel_id' => 'required|string',
            'longitude' => 'string',
            'latitude' => 'string',
            'role' => 'required|enum:pembudidaya,pengepul'
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
            'birthdate.required' => 'Tanggal lahir harus diisi!',
            'gender.required' => 'Jenis Kelamin harus diisi!',
            'address.required' => 'Alamat harus diisi!',
            'kel_id.required' => 'Kelurahan harus diisi!',
            'role.required' => 'Role harus diisi!',
            'role.enum' => 'Role harus diisi dengan pembudidaya atau pengepul!'
        ];
    }
}
