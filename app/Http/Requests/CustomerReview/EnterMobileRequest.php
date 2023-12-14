<?php

namespace App\Http\Requests\CustomerReview;

use Illuminate\Foundation\Http\FormRequest;

class EnterMobileRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'mobile' => 'required|regex:/^[01]{2}[0-9]{9}+$/'
        ];
    }
}
