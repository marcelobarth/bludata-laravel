<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmpresaRequest;
use App\Models\Empresa;
use App\Models\Fornecedor;

class EmpresaController extends Controller
{
	private $empresa;
    private $validate;
	private $totalPage = 8;

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
        /*Pegar todas as categorias do BD e exibir quantidades de itens conforme $totalPage.*/
        $data = $this->empresa->orderBy('id','DESC')->paginate($this->totalPage);
        return view('painel.indexEmpresa', compact('data'));
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
    public function store(EmpresaRequest $request)
    {
    	/*Pega todos os dados vindos do form*/
    	$empresa = $request->all();

        /*Converte a primeira letra da palavra para maiúscula.*/
        $empresa['nome_fantasia'] = ucwords($empresa['nome_fantasia']);

    	/*Salvando os dados validados no BD.*/
    	$store = $this->empresa->create($empresa);

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

}
