<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KonfirmasiLaporanRequest extends FormRequest
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
            'laporan_praktikum' => 'nullable|string',
            'laporan_kuliah_umum' => 'nullable|string',
            'laporan_kuliah_lapangan' => 'nullable|string',
            'catatan_revisi_praktikum' => 'sometimes|required|string',
            'catatan_revisi_kuliah_umum' => 'sometimes|required|string',
            'catatan_revisi_kuliah_lapangan' => 'sometimes|required|string',
        ];
    }
}
