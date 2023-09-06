<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvertisementRequest extends FormRequest
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
        $required = request()->route('advertisement')?"nullable":"required";
        return [
            'business_id'           => 'required',
            'image'                 => $required.'|image',
            'category_ids'          => 'required',
            'city_ids'              => 'required',
            'expired_date'          => 'required',
            'price'                 => 'required',
            'link'                  => 'required',
            'file_status'           => 'required',
        ];
    }
}
