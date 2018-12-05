<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Rotas para Site
Route::group(['namespace' => 'Site'], function(){
	Route::get('/', 'HomeController@index');
});

//Rotas para Painel
Route::group(['namespace' => 'Painel', 'middleware' => 'auth'], function(){
	Route::resource('painel', 'PainelController');
	Route::resource('empresa', 'EmpresaController');
	Route::get('listar/empresas', 'EmpresaController@showAll');
	Route::resource('fornecedor', 'FornecedorController');
});

Auth::routes();

