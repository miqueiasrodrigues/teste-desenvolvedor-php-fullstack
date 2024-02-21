<?php

namespace App\Http\Requests;

use App\Http\ResponseHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseMessageRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            ResponseHelper::response(
                422,
                'Ocorreu algum erro de validação.',
                [
                    'errors' => $validator->errors()->toArray()
                ],
                422
            )
        );
    }

    /**
     * Get the common error messages for the address requests.
     *
     * @return array
     */

     protected function supplierMessages()
     {
         return [
             'name.required' => 'O campo nome é obrigatório.',
             'name.max' => 'O campo nome não pode ter mais de :max caracteres.',
             'identification.required' => 'O campo identificação é obrigatório.',
             'identification.unique' => 'O campo identificação já está em uso.',
             'identification.max' => 'O campo identificação não pode ter mais de :max caracteres.',
             'email.required' => 'O campo email é obrigatório.',
             'email.email' => 'O campo email deve ser um endereço de email válido.',
             'email.max' => 'O campo email não pode ter mais de :max caracteres.',
             'email.unique' => 'O email já está em uso.',
             'phone.required' => 'O campo telefone é obrigatório.',
             'phone.max' => 'O campo telefone não pode ter mais de :max caracteres.',
             'phone.unique' => 'O telefone já está em uso.',
             'street.required' => 'O campo rua é obrigatório.',
             'street.max' => 'O campo rua não pode ter mais de :max caracteres.',
             'number.max' => 'O campo número não pode ter mais de :max caracteres.',
             'neighborhood.required' => 'O campo bairro é obrigatório.',
             'neighborhood.max' => 'O campo bairro não pode ter mais de :max caracteres.',
             'city.required' => 'O campo cidade é obrigatório.',
             'city.max' => 'O campo cidade não pode ter mais de :max caracteres.',
             'state.required' => 'O campo estado é obrigatório.',
             'state.max' => 'O campo estado não pode ter mais de :max caracteres.',
             'postal_code.required' => 'O campo código postal é obrigatório.',
             'postal_code.max' => 'O campo código postal não pode ter mais de :max caracteres.',
             'complement.max' => 'O campo complemento não pode ter mais de :max caracteres.',
             'situation.required' => 'O campo situação é obrigatório.',
             'situation.max' => 'O campo situação não pode ter mais de :max caracteres.',
             'situation_date.required' => 'O campo data de situação é obrigatório.',
             'situation_date.date' => 'O campo data de situação deve ser uma data válida.',
             'type.required' => 'O campo tipo é obrigatório.',
             'type.max' => 'O campo tipo não pode ter mais de :max caracteres.',
             'type.in' => 'O campo tipo deve ser uma das opções: MATRIZ, FILIAL.',
             'legal_nature.required' => 'O campo natureza jurídica é obrigatório.',
             'legal_nature.max' => 'O campo natureza jurídica não pode ter mais de :max caracteres.',
             'situation_reason.max' => 'O campo motivo da situação não pode ter mais de :max caracteres.',
             'opening_date.required' => 'O campo data de abertura é obrigatório.',
             'opening_date.date' => 'O campo data de abertura deve ser uma data válida.',
         ];
     }
}
