<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KuliahLapanganRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'acara' => 'required|string',
            // 'tempat' => 'required|string',
            'tanggal_mulai' => 'required|date_format:Y/m/d H:i',
            'tanggal_selesai' => 'required|date_format:Y/m/d H:i|after:tanggal_mulai',
            'id_praktikum' => 'required|string',
            'instansi' => 'required|string',
            'tahun_ajaran' => 'required|numeric',
            'semester' => 'required|numeric|max:6|min:1',
            'tema' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute wajib diisi.',
            'after' => ':attribute harus setelah tanggal mulai.',
        ];
    }
}
