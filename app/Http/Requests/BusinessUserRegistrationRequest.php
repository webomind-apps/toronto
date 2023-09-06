<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessUserRegistrationRequest extends FormRequest
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
       $rule = [
            'fname'         => 'required',
            'lname'         => 'required',
            'email'         => 'required|unique:business_users,email,'.(request()->route('user')->id??"").',id|max:128',
            'phone'         => 'required|unique:business_users,phone,'.(request()->route('user')->id??"").',id|max:128',
        ];

        if(empty(request()->route('user'))){
            $rule['password'] = 'required|confirmed';
        }
        return $rule;
    }
}
