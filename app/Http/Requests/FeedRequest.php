<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedRequest extends FormRequest
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
            'caption' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,|max:2048',
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
            'caption.required' => 'Caption harus diisi',
            'image.required' => 'Harap Pilih Gambar!',
            'image.image' => 'Harus berupa file gambar',
            'image.mimes' => 'Extensi Gambar harus berupa : jpeg, png, jpg',
            'image.max' => 'Gambar harus kurang dari 2MB',
        ];
    }
}
