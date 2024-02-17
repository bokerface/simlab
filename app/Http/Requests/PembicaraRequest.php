<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PembicaraRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (session('user_data')['role'] == 2) {
            return true;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama_pembicara_1' => 'required|string',
            'jabatan_pembicara_1' => 'required|string',
            'instansi_pembicara_1' => 'required|string',
            'foto_pembicara_1' => 'image|mimes:jpg,bmp,png',
            'nama_pembicara_2' => 'nullable|string',
            'jabatan_pembicara_2' => 'nullable|string',
            'instansi_pembicara_2' => 'nullable|string',
            'foto_pembicara_2' => 'nullable|image|mimes:jpg,bmp,png',
            'nama_pembicara_3' => 'nullable|string',
            'jabatan_pembicara_3' => 'nullable|string',
            'instansi_pembicara_3' => 'nullable|string',
            'foto_pembicara_3' => 'nullable|image|mimes:jpg,bmp,png',
        ];
    }
}
