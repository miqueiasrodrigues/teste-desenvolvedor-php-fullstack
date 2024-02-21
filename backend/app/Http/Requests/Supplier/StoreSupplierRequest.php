<?php

namespace App\Http\Requests\Supplier;

use App\Http\Requests\BaseMessageRequest;
use App\Http\Requests\Rules\Identification;

class StoreSupplierRequest extends BaseMessageRequest
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
            'name' => 'required|string|max:255',
            'identification' => [
                'required',
                'unique:suppliers,identification,',
                new Identification
            ],
            'email' => 'required|string|email|max:255|unique:suppliers,email',
            'phone' => 'required|string|max:20|unique:suppliers,phone',
            'street' => 'required|string|max:255',
            'number' => 'nullable|string|max:20',
            'neighborhood' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'complement' => 'nullable|string|max:255',
            'situation' => 'required|string|max:255',
            'situation_date' => 'required|date',
            'type' => 'required|string|in:matriz,filial|max:255',
            'legal_nature' => 'required|string|max:255',
            'situation_reason' => 'nullable|string|max:255',
            'opening_date' => 'required|date',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return $this->supplierMessages();
    }
}
