<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'fname'         => 'required',
            'lname'         => 'required',
            'email'         => 'required|unique:users,email,'.(request()->route('user')->id??"").',id|max:128',
            'phone'         => 'required|unique:users,phone,'.(request()->route('user')->id??"").',id|max:128',
            'password'      => 'required|confirmed',
            'address'       => 'required',
            'lat'           => 'required',
            'lng'           => 'required',
            'postcode'      => 'required',
            'country_id'    => 'required',
            'province_id'   => 'required',
            'city_id'       => 'required',
        ];
    }
}
