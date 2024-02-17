<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LaporanRequest extends FormRequest
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
            'id_praktikum' => 'required|string',
            'tahun_ajaran' => 'required|numeric',
            'semester' => 'required|numeric',
            'laporan_praktikum' => 'sometimes|required|file|mimes:pdf,doc,docx',
            'laporan_kuliah_umum' => 'sometimes|required|file|mimes:pdf,doc,docx',
            'laporan_kuliah_lapangan' => 'sometimes|required|file|mimes:pdf,doc,docx',
        ];
    }

    public function messages()
    {
        return [
            'mimes' => ':attribute format file tidak sesuai'
        ];
    }
}
