<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KurikulumRequest extends FormRequest
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
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama_kurikulum' => 'required|string'
        ];
    }
}
