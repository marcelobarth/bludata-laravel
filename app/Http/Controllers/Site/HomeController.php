<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /** Contrutor obriga autenticação para ter acesso aos métodos da classe. Isso pode ser feito direto na rota. 
     * Método except() para exceções de autenticação. 
     * Método only() para obrigar autenticação dos selecionados.*/   
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('site.index');
    }
}