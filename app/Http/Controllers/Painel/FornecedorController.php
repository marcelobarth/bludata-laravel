<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FornecedorController extends Controller
{
    private $fornecedor;
    private $totalPage = 10;

    /**
     * Injeção do objeto no contrutor para uso em toda a classe.
     *
     * @param  object  $fornecedor
     */
    public function __construct(Categoria $fornecedor) {
        $this->fnr = $fornecedor;
    }
}
