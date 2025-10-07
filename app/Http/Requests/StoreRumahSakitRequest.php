<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRumahSakitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_rumah_sakit' => 'required|string|max:255',
            'alamat' => 'required|string',
            'email' => 'required|email|unique:rumah_sakits,email',
            'telepon' => 'required|numeric|digits_between:12,15',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_rumah_sakit.required' => 'Nama rumah sakit wajib diisi.',
            'alamat.required'      => 'Alamat wajib diisi.',
            'email.required'  => 'Alamat wajib diisi.',
            'telepon.required'=> 'Telepon wajib diisi.',
        ];
    }
}
