<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Fornecedor;

/**
 * Class Empresa
 *
 * @property int id
 * @property int uf
 * @property string $nome_fantasia
 * @property string $cnpj
 *
 * @package App\Models
 */

class Empresa extends Model
{
	protected $primaryKey = 'id';
	//Suprimindo data e hora de criação e atualização na tabela do BD.
    public $timestamps = false;

    protected $fillable = [
    	'uf',
		'nome_fantasia',
		'cnpj'
	];
	
	/**
	 * Relacionamento entre classes, com Model Fornecedor.
	 * Relacionamento 1 para N.
	 */
	public function fornecedor(){
		return $this->hasMany(Fornecedor::class, 'empresa_id');
	}

}
