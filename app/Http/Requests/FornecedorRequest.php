<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Painel\FornecedorController;

class FornecedorRequest extends FormRequest
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
            'empresa_id' => 'required|max:191',
            'nome' => 'required|max:191',
            'cpf_ou_cnpj' => 'required|formato_cpf_cnpj|cpf_cnpj',
            'rg' => 'numeric',
            'telefone_comercial' => 'max:10',
            'telefone_residencial' => 'max:10',
            'telefone_celular' => 'max:11',
            'data_nascimento' => 'min:10|max:10',
        ];
    }

}
