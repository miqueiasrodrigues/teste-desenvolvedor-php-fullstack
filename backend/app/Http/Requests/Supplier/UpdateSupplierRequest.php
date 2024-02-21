<?php

namespace App\Http\Requests\Supplier;

use App\Http\Requests\BaseMessageRequest;
use App\Http\Requests\Rules\Identification;

class UpdateSupplierRequest extends BaseMessageRequest
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
        $identification = preg_replace('/[^0-9]/', '', $this->input('identification'));
        $phone = preg_replace('/[^0-9]/', '', $this->input('phone'));
        $postal_code = preg_replace('/[^0-9]/', '',  $this->input('postal_code'));

        // Todos os campos são obrigatórios
        if ($this->isMethod('put')) {
            return [
                'name' => 'required|string|max:255',
                'identification' => [
                    'required',
                    'unique:suppliers,identification,' . $this->route('supplier'),
                    new Identification
                ],
                'email' => 'required|string|email|max:255|unique:suppliers,email,' . $this->route('supplier'),
                'phone' => 'required|string|max:20|unique:suppliers,phone,' . $this->route('supplier'),
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

        // Os campos são opcionais
        if ($this->isMethod('patch')) {
            return [
                'name' => 'nullable|string|max:255',
                'identification' => [
                    'nullable',
                    'unique:suppliers,identification,' . $this->route('supplier'),
                    new Identification
                ],
                'email' => 'nullable|string|email|max:255|unique:suppliers,email,' . $this->route('supplier'),
                'phone' => 'nullable|string|max:20|unique:suppliers,phone,' . $this->route('supplier'),
                'street' => 'nullable|string|max:255',
                'number' => 'nullable|string|max:20',
                'neighborhood' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:255',
                'state' => 'nullable|string|max:255',
                'postal_code' => 'nullable|string|max:20',
                'complement' => 'nullable|string|max:255',
                'situation' => 'nullable|string|max:255',
                'situation_date' => 'nullable|date',
                'type' => 'nullable|string|in:matriz,filial|max:255',
                'legal_nature' => 'nullable|string|max:255',
                'situation_reason' => 'nullable|string|max:255',
                'opening_date' => 'nullable|date',
            ];
        }
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
