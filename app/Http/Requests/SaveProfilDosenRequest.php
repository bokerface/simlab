<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveProfilDosenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (session('user_data')['role'] == 1) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'id_rekening' => 'numeric',
            'id_pegawai' => 'numeric|required',
            'rekening' => 'numeric|nullable',
            'bank' => 'string|nullable',
            'cabang' => 'string|nullable',
            'pemegang_rekening' => 'string|nullable',
            'no_telp' => 'numeric|nullable',
            'no_wa' => 'numeric|nullable',
        ];
    }
}
