<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Empresa;

class EmpresaController extends Controller
{
	private $empresa;
	private $totalPage = 10;

    /**
     * Injeção do objeto no contrutor para uso em toda a classe.
     *
     * @param  object  $empresa
     */
    public function __construct(Empresa $empresa) {
    	$this->empresa = $empresa;
    }

    /**
     * Esta método, mostrará todas as empresas cadastradas no banco de dados.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	/*Titulo do form*/
        $title = "Empresas";
        /*Pegar todas as categorias do BD e exibir quantidades de itens conforme $totalPage.*/
        $data = $this->empresa->paginate($this->totalPage);

        return view('painel.indexEmpresa', compact('data', 'title'));
    }


     /**
     * Esta método, mostra o formulário para criar uma nova empresa. Este formulário será processado pelo método store().
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
     {
     	/*Titulo do form*/
     	$title = "Cadastrar Empresa";
     	return view('painel.formEmpresa', compact('title'));
     }

    /**
     * Este método, processa o formulário de criação vindo do create e salva a nova empresa no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	/*Pega todos os dados vindos do form*/
    	$data = $request->all();
    	/*Validando os campos vindos do form*/
    	$data = $this->validate($request, $this->empresa->rules);
    	/*Salvando os dados validados no BD.*/
    	$store = $this->empresa->create($data);

    	if ($store) 
    		return redirect()->route('empresa.index');
    	else
    		return redirect()->back();
    }

    /**
     * Este método. mostra todos os atributos de uma empresa pelo parâmetro escolhido.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	/*Buscar dados do BD pelo ID*/
    	$data = $this->empresa->find($id);
    	return view('painel.indexEmpresa', compact('data'));
    }

    public function showAll()
    {
        /*Buscar dados do BD pelo ID*/
        $data = $this->empresa->orderBy('id','DESC')->paginate($this->totalPage);
        return view('painel.indexEmpresa', compact('data'));
    }

    /**
     * Este método, pega uma empresa pelo parâmetro escolhido do banco de dados para edição.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	/*Buscar dados do BD pelo ID*/
    	$data = $this->empresa->find($id);
    	/*Titulo do form*/
    	$title = "Editar Empresa";
    	return view('painel.formEmpresa', compact('data', 'title'));
    }

    /**
     * Este método, processa o formulário de criação de envio e salva a empresa no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    	/*Pega todos os dados vindos do form*/
    	$data = $request->all();

    	/*Validando os campos vindos do form*/
    	$data = $this->validate($request, $this->empresa->rules);
    	/*Buscar dados do BD pelo ID*/
    	$empresa = $this->empresa->find($id);
    	/*Salvando os dados validados no BD.*/
    	$update = $empresa->update($data);

    	if ($update) 
    		return redirect()->route('empresa.index');
    	else
    		return redirect()->back();
    }

    /**
     * Este método, remove a empresa do bando de dados.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	/*Buscar dados do BD pelo ID*/
    	$empresa = $this->empresa->find($id);

    	$destroy = $empresa->delete();

    	if ($destroy) 
    		return redirect()->route('empresa.index');
    	else
    		return 'Falha ao apagar empresa!';
    }



    public function ajax(Request $request){

        $pesquisa = $request->get('nome');

        //pesquisa as empresas com o nome solicitado
        $empresas = Empresa::where('nome_fantasia', 'LIKE', "%".$pesquisa."%")->get();

        return $empresas;

    }

}
