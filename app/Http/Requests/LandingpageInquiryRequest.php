<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LandingpageInquiryRequest extends FormRequest
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
            'domain' => [ 'required', 'max:255' ],
            'gender' => [ 'required', 'in:m,f' ],
            'prename' => [ 'nullable', 'min:2', 'regex:/^[\pL\s\-]+$/u', 'max:255' ],
            'surname' => [ 'required', 'min:2', 'regex:/^[\pL\s\-]+$/u', 'max:255' ],
            'email' => [ 'required', 'email:rfc,dns', 'max:255' ],
        ];
    }
}
