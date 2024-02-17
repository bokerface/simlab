<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KurikulumSoftskillRequest extends FormRequest
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
            'angkatan' => 'numeric|required',
            'KURIKULUM_ID' => [
                'required',
                Rule::exists('V_Kurikulum_Softskill', 'KURIKULUM_ID')
            ]
        ];
    }
}
