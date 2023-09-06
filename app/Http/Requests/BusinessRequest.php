<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessRequest extends FormRequest
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
            'name'                  => 'required|max:128',
            'email'                 => 'required|unique:businesses,email,'.(request()->route('business')->id??"").',id|max:128',
            'phone'                 => 'required|unique:businesses,phone,'.(request()->route('business')->id??"").',id|max:128',
            // 'user_id'               => 'required',
            'country_id'            => 'required',
            'province_id'           => 'required',
            'city_id'               => 'required',
            'description'           => 'required',
            'postcode'              => 'required',
            'address'               => 'required',
            'lat'                   => 'required',
            'lng'                   => 'required',
            'website'               => 'nullable',
            'image'                 => 'nullable|image',
            'video'                 => 'nullable',
            // 'is_feature'            => 'required',
            'area_of_practice'      => 'nullable',
            'product_and_service'   => 'nullable',
            'specialization'        => 'nullable',
            // 'priority'              => 'nullable|integer',
            'online_order'          => 'required',
            'online_order_link'     => 'nullable',
        ];
    }
}
