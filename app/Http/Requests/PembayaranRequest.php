<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PembayaranRequest extends FormRequest
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
            'id_pegawai' => 'numeric|required',
            'id_praktikum' => 'string|required',
            'tahun_ajaran' => 'numeric|required',
            'semester' => 'numeric|required',
            'type' => 'string|required',
            'metode' => 'string|required',
            'nominal' => 'numeric|required',
            'tanggal' => 'required',
            'file_bukti' => 'image|required|mimes:jpg,png,jpeg',
        ];
    }
}
