<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'address' => 'required',
            'apartment' => 'required',
            'country' => 'required|max:255',
            'state' => 'required|max:255',
            'city' => 'required|max:255',
            'pincode' => 'required|numeric',
            'mobile' => 'required|numeric|digits:10',
            'dob' => 'required|date',
            'billing_first_name' => 'exclude_if:samebilling,1|max:255',
            'billing_last_name' => 'exclude_if:samebilling,1|max:255',
            'billing_address' => 'exclude_if:samebilling,1',
            'billing_apartment' => 'exclude_if:samebilling,1',
            'billing_country' => 'exclude_if:samebilling,1|max:255',
            'billing_state' => 'exclude_if:samebilling,1|max:255',
            'billing_city' => 'exclude_if:samebilling,1|max:255',
            'billing_pincode' => 'exclude_if:samebilling,1|numeric',
            'billing_mobile' => 'exclude_if:samebilling,1|numeric|digits:10',
        ];
    }
}
