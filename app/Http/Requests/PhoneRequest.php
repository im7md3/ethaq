<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhoneRequest extends FormRequest
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
            'mobile'=>'required|exists:users,phone'
        ];
    }
    public function messages()
    {
        // use trans instead on Lang
        return [
            'mobile.exists' => trans('validation.mobileExist'),
        ];
    }
}
