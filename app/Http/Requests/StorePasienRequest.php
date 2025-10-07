<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePasienRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_pasien'     => 'required|string|max:255',
            'alamat'          => 'required|string',
            'no_telepon'      => 'required|numeric|digits_between:12,15',
            'rumah_sakit_id'  => 'required|exists:rumah_sakits,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_pasien.required' => 'Nama pasien wajib diisi.',
            'alamat.required'      => 'Alamat wajib diisi.',
            'no_telepon.required'  => 'Nomor telepon wajib diisi.',
            'rumah_sakit_id.exists'=> 'Rumah sakit tidak valid.',
        ];
    }
}
