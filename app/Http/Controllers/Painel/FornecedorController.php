<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Fornecedor;
use App\Models\Empresa;

class FornecedorController extends Controller
{
    private $fornecedor;
    private $empresa;
    private $totalPage = 10;

    /**
     * Injeção do objeto no contrutor para uso em toda a classe.
     *
     * @param  object  $fornecedor
     */
    public function __construct(Fornecedor $fornecedor, Empresa $empresa) {
        $this->fornecedor = $fornecedor;
        $this->empresa = $empresa;
    }

    /**
     * Esta método, mostrará todas as empresas cadastradas no BD.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* Pega todos os fornecedores do BD por ordem descendente de ID e exibi quantidades 
         * de itens por p/página conforme $totalPage.
         */
        $fornecedores = $this->fornecedor->orderBy('id','DESC')->paginate($this->totalPage);

        return view('painel.indexFornecedor', compact('data'));
    }

     /**
     * Esta método, mostra o formulário para criar um novo fornecedor. Este formulário será processado
     * pelo método store().
     *
     * @return \Illuminate\Http\Response
     */
     public function create(Request $request)
     {
        /*Titulo do form*/
        $title = "Cadastrar Fornecedor";
        $empresas =  $this->empresa->pluck('nome_fantasia', 'id');

        return view('painel.formFornecedor',compact('empresas', 'title'));
    } 

    /**
     * Este método processa o formulário de criação vindo do create e salva o novo fornecedor no BD.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* Pega todos os dados vindos do form. */
        $fornecedor = $request->all();
        /* Validando os campos vindos do form. */
        $fornecedor = $this->validate($request, $this->fornecedor->rules);
        /* Salvando os dados validados no BD. */
        $store = $this->fornecedor->create($fornecedor);

        if ($store) 
            return redirect()->route('fornecedor.index');
        else
            return redirect()->back();
    }

    /**
     * Este método mostra todos os atributos de um fornecedor pelo parâmetro escolhido.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /* Buscar fornecedor do BD pelo ID. */
        $fornecedor = $this->fornecedor->find($id);
        return view('painel.indexFornecedor', compact('fornecedor'));
    }

    public function showAll()
    {
        /* Todos os fornecedores do BD pelo ID. */
        $fornecedores = $this->fornecedor->orderBy('id','DESC')->paginate($this->totalPage);
        return view('painel.indexFornecedor', compact('data'));
    }

    /**
     * Este método pega um fornecedor pelo parâmetro escolhido do BD para edição.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /* Buscar fornecedor do BD pelo ID. */
        $fornecedor = $this->fornecedor->find($id);
        /* Titulo do form. */
        $title = "Editar Fornecedor";
        return view('painel.formFornecedor', compact('fornecedor', 'title'));
    }

    /**
     * Este método processa o formulário de criação de envio e salva o fornecedor no BD.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /* Pega todos os dados vindos do form. */
        $data = $request->all();

        /* Validando os campos vindos do form. */
        $data = $this->validate($request, $this->fornecedor->rules);
        /* Buscar dados do BD pelo ID*/
        $fornecedor = $this->fornecedor->find($id);
        /* Salvando os dados validados no BD. */
        $update = $fornecedor->update($data);

        if ($update) 
            return redirect()->route('fornecedor.index');
        else
            return redirect()->back();
    }

    /**
     * Este método remove o fornecedor do BD.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /* Busca os dados do BD pelo ID. */
        $fornecedor = $this->fornecedor->find($id);

        $destroy = $fornecedor->delete();

        if ($destroy) 
            return redirect()->route('fornecedor.index');
        else
            return 'Falha ao apagar fornecedor!';
    }


    public function ajax(Request $request){

        $pesquisa = $request->get('nome');

        /* Pesquisa as fornecedores com o nome solicitado */
        $fornecedores = Fornecedor::where('nome_fantasia', 'LIKE', "%".$pesquisa."%")->get();

        return $fornecedores;

    }
}
