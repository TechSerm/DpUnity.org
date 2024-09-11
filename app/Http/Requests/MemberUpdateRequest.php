<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberUpdateRequest extends FormRequest
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

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'nationality' => 'required|string|max:255',
            'religion' => 'required|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'present_address' => 'required|string|max:255',
            'permanent_address' => 'required|string|max:255',
            'nid' => 'nullable|string|max:50',
            'mobile' => 'required|string|max:15',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:300',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:300',
            'is_approved' => 'required|boolean',
            'organization_id' => 'required|integer',
        ];
    }
    
    public function attributes()
    {
        return [
            'name' => 'পূর্ণ নাম',
            'father_name' => 'পিতার নাম',
            'mother_name' => 'মাতার নাম',
            'date_of_birth' => 'জন্ম তারিখ',
            'nationality' => 'জাতীয়তা',
            'religion' => 'ধর্ম',
            'occupation' => 'পেশা',
            'present_address' => 'বর্তমান ঠিকানা',
            'permanent_address' => 'স্থায়ী ঠিকানা',
            'nid' => 'জাতীয় পরিচয়পত্র (এনআইডি)',
            'mobile' => 'মোবাইল নম্বর',
            'blood_group' => 'রক্তের গ্রুপ',
            'password' => 'পাসওয়ার্ড',
            'image_id' => 'প্রোফাইল ইমেজ',
            'signature_id' => 'স্বাক্ষর ইমেজ',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute প্রয়োজন।',
            'string' => ':attribute অবশ্যই একটি স্ট্রিং হতে হবে।',
            'max' => ':attribute :max কিলোবাইটের বেশি হতে পারবে না।',
            'unique' => ':attribute ইতিমধ্যে ব্যবহৃত হয়েছে।',
            'confirmed' => ':attribute নিশ্চিতকরণ মেলে না।',
            'in' => 'নির্বাচিত :attribute বৈধ নয়।',
            'image' => ':attribute একটি বৈধ চিত্র ফাইল হতে হবে।',
            'mimes' => ':attribute কেবলমাত্র jpeg, png, jpg, gif, svg ফরম্যাটে থাকতে পারে।',
        ];
    }
}
