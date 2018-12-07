<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Empresa;

/**
 * Class Fornecedor
 *
 * @property int $empresa_id
 * @property string $nome
 * @property string $cpf_ou_cnpj
 * @property string $rg
 * @property string $telefone_comercial
 * @property string $telefone_residencial
 * @property string $telefone_celular
 * @property string $data-nascimento
 *
 * @package App\Models
 */

class Fornecedor extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
    	'empresa_id',
		'nome',
		'cpf_ou_cnpj',
		'rg',
		'telefone_comercial',
		'telefone_residencial',
		'telefone_celular',
		'data_nascimento',
	];

	/**
	 * Relacionamento entre classes, com Model Empresa.
	 * Relacionamento 1 para N.
	 */
	public function empresa(){
			return $this->belongsTo(Empresa::class, 'empresa_id');
	}
}
