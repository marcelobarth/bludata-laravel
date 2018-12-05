<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class \Empresa extends Model
{
	//Suprimindo data e hora de criação e atualização na tabela do BD.
    public $timestamps = false;
}
