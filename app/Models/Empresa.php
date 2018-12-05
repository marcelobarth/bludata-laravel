<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Empresa
 *
 * @property int id
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

	public $rules = [
		'uf' => 'required',
		'nome_fantasia' => 'required',
		'cnpj' => 'required|max:18',
	];

}
