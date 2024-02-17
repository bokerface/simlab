<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KuliahUmumRequest extends FormRequest
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
            'tempat' => 'required|string',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'id_praktikum' => 'required|string',
            'tahun_ajaran' => 'required|numeric',
            'semester' => 'required|numeric',
            'tema' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute wajib diisi',
            'jam_selesai.after' => 'jam selesai harus lebih besar dari jam mulai'
        ];
    }
}
