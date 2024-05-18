<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
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
            'appointment_date' => 'required|date_format:Y-m-d',
            'appointment_time' => 'required|date_format:H:i'
        ];
    }

    /**
     * Get the validation message
     * 
     * 
     */
    public function messages(): array
    {
        return [
            'appointment_date.required' => 'Tanggal janji harus diisi',
            'appointment_date.date' => 'Tanggal janji harus berupa tanggal',
            'appointment_time.required' => 'Waktu janji harus diisi',
            'appointment_time.time' => 'Waktu janji harus berupa waktu'
        ];
    }
}
