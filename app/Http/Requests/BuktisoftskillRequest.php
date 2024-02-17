<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuktisoftskillRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (session('user_data')['role'] == 3) {
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
            'bukti_kegiatan' => 'required|image|mimes:jpg,bmp,png',
            'id_praktikum' => 'required',
            't_akademik' => 'required',
            'semester' => 'required',
        ];
    }
}
