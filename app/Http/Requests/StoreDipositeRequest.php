<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDipositeRequest extends FormRequest
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
            'type' => 'required|string|in:member,unknown',
            'member_id' => 'required_if:type,member|nullable|exists:members,id',
            'name' => 'required_if:type,unknown|nullable|string|max:255',
            'mobile' => 'required_if:type,unknown|nullable|string',
            'amount' => 'required|numeric|min:1',
            'note' => 'nullable|string|max:1000',
        ];
    }
}
