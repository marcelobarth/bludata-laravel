<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpresaRequest extends FormRequest
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
            'uf' => 'required',
            'nome_fantasia' => 'required|max:191',
            'cnpj' => 'required|min:14|formato_cpf_cnpj|cpf_cnpj',
        ];
    }
}
