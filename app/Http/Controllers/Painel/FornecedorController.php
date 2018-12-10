<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FornecedorRequest;
use App\Models\Fornecedor;
use App\Models\Empresa;

class FornecedorController extends Controller
{
    private $fornecedor;
    private $empresa;
    private $totalPage = 8;

    /**
     * Injeção do objeto no contrutor para uso em toda a classe.
     *
     * @param  object  $fornecedor
     * @param  object  $empresa
     */
    public function __construct(Fornecedor $fornecedor, Empresa $empresa) {
        $this->fornecedor = $fornecedor;
        $this->empresa = $empresa;
    }

    /**
     * Esta método, mostrará todas as empresas cadastradas no BD.
     *
     * @param  object  $empresa
     * @return \Illuminate\Http\Response
     */
    public function index(Empresa $empresa) {
        /* Pega todos os fornecedores do BD por ordem descendente de ID e exibi quantidades 
         * de itens por p/página conforme $totalPage.
         */
        $fornecedores = $this->fornecedor->orderBy('id','DESC')->paginate($this->totalPage);
        return view('painel.indexFornecedor', compact('fornecedores', 'empresa'));
    }

     /**
     * Esta método, mostra o formulário para criar um novo fornecedor. Este formulário será processado
     * pelo método store().
     *
     * @return \Illuminate\Http\Response
     */
     public function create(Request $request) {
        /*Titulo do form*/
        $title = "Cadastrar Fornecedor";
        $empresa =  $this->empresa->pluck('nome_fantasia', 'id');

        return view('painel.formFornecedor',compact('empresa', 'title'));
    } 

    /**
     * Este método processa o formulário de criação vindo do create e salva o novo fornecedor no BD.
     *
     * @param  App\Http\Requests\FornecedorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FornecedorRequest $request) {
        /* Pega todos os dados vindos do form. */
        $fornecedor = $request->all();

        /*Converte a primeira letra das palavras da string para maiúscula.*/
        $fornecedor['nome'] = ucwords($fornecedor['nome']);

        /*Verifica se é pessoa Física ou Jurídica a partir do número de caracteres digitados para cpf_ou_cnpj.*/
        $tipo_cadastro = (strlen(preg_replace('/\W+/', '', $fornecedor['cpf_ou_cnpj'])) < 14);

        /*-------------------------Validações das Regras Específicas----------------------*/

        /*Verifica se é pessoa física e se o campo rg foi preenchido.*/
        if (($tipo_cadastro == true) && (is_null($fornecedor['rg']))) {
            return redirect()
            ->back()
            ->with('message', 'Atenção! Para Pessoas Físicas, o preenchimento do campo RG é obrigatório!')
            ->withInput();
        }

        /*Verifica se é pessoa física, e se o campo data_nasciento foi preenchido.*/
        if(($tipo_cadastro == true) && (is_null($fornecedor['data_nascimento']))) {
            return redirect()
            ->back()
            ->with('message', 'Atenção! O campo DATA NASCIMENTO é obrigatória para cadastro de Pessoas Físicas!')
            ->withInput();
        } else {
            /*Formata data para padrão sulamericano para operação de subtração.*/
            $fornecedor['data_nascimento'] = date('d/m/Y', strtotime($fornecedor['data_nascimento']));
            /*Verifica se é menor de idade.*/
            $menoridade = (((str_replace("/", "",date('d/m/Y'))) - preg_replace('/\W+/', '', $fornecedor['data_nascimento'])) < 18);
        }

        /*Captura coluna uf da tabela empresa pelo id*/
        $e = $this->empresa->where('id', "=", $fornecedor['empresa_id'])->first()->uf;

        /*Verifica se é pessoa física, menor de idade e empresa do Paraná, caso true, será negado o cadastramento.*/
        if ($tipo_cadastro && $menoridade && ($e == 'PR')){
            return redirect()
            ->back()
            ->with('message', 'Atenção! Cadastro de Pessoas Físicas menores de idade não permitido para empresas do Estado do Paraná!')
            ->withInput();
        }

        /*---------------------------------------------------------------------------------*/

        /*Formata data para padrão americano para o padrão do BD.*/
        $fornecedor['data_nascimento'] = date('Y/m/d', strtotime($fornecedor['data_nascimento']));

        /* Salvando os dados validados no BD. */
        $store = $this->fornecedor->create($fornecedor);

        /*Verifica se ocorreu cadastrou com sucesso.*/
        if ($store) {
            return redirect()->route('fornecedor.index');
        } else {
            return redirect()->back();
        }
    }

    /**
     * Este método mostra todos os atributos de um fornecedor pelo parâmetro escolhido.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        /* Buscar fornecedor do BD pelo ID. */
        $fornecedor = $this->fornecedor->find($id);
        return view('painel.indexFornecedor', compact('fornecedor'));
    }

    public function showAll() {
        /* Todos os fornecedores do BD pelo ID. */
        $fornecedores = $this->fornecedor->orderBy('id','DESC')->paginate($this->totalPage);
        return view('painel.indexFornecedor', compact('fornecedores'));
    }

    /**
     * Este método pega um fornecedor pelo parâmetro escolhido do BD para edição.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        /* Buscar fornecedor do BD pelo ID. */
        $fornecedor = $this->fornecedor->find($id);
        $empresa =  $this->empresa->pluck('nome_fantasia', 'id');
        /* Titulo do form. */
        $title = "Editar Fornecedor";
        return view('painel.formFornecedor', compact('fornecedor', 'empresa', 'title'));
    }

    /**
     * Este método processa o formulário de criação de envio e salva o fornecedor no BD.
     *
     * @param App\Http\Requests\FornecedorRequest;  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FornecedorRequest $request, $id) {
        /* Pega todos os dados vindos do form. */
        $data = $request->all();

        /*Buscar dados do BD pelo ID*/
        $fornecedor = $this->fornecedor->find($id);

        /*Converte a primeira letra das palavras da string para maiúscula.*/
        $data['nome'] = ucwords($data['nome']);

        /*Verifica se é pessoa Física ou Jurídica a partir do número de caracteres digitados para cpf_ou_cnpj.*/
        $tipo_cadastro = (strlen(preg_replace('/\W+/', '', $data['cpf_ou_cnpj'])) < 14);

        /*-------------------------Validações das Regras Específicas----------------------*/

        /*Verifica se é pessoa física e se o campo rg foi preenchido.*/
        if (($tipo_cadastro == true) && (is_null($data['rg']))) {
            return redirect()
            ->back()
            ->with('message', 'Atenção! Para Pessoas Físicas, o preenchimento do campo RG é obrigatório!')
            ->withInput();
        }

        /*Verifica se é pessoa física, e se o campo data_nasciento foi preenchido.*/
        if(($tipo_cadastro == true) && (is_null($data['data_nascimento']))) {
            return redirect()
            ->back()
            ->with('message', 'Atenção! O campo DATA NASCIMENTO é obrigatória para cadastro de Pessoas Físicas!')
            ->withInput();
        } else {
            /*Formata data para padrão sulamericano para operação de subtração.*/
            $data['data_nascimento'] = date('d/m/Y', strtotime($data['data_nascimento']));
            /*Verifica se é menor de idade.*/
            $menoridade = (((str_replace("/", "",date('d/m/Y'))) - preg_replace('/\W+/', '', $data['data_nascimento'])) < 18);
        }

        /*Captura coluna uf da tabela empresa pelo id*/
        $e = $this->empresa->where('id', "=", $data['empresa_id'])->first()->uf;

        /*Verifica se é pessoa física, menor de idade e empresa do Paraná, caso true, será negado o cadastramento.*/
        if ($tipo_cadastro && $menoridade && ($e == 'PR')){
            return redirect()
            ->back()
            ->with('message', 'Atenção! Cadastro de Pessoas Físicas menores de idade não permitido para empresas do Estado do Paraná!')
            ->withInput();
        }

        /*---------------------------------------------------------------------------------*/

        /*Formata data para padrão americano para o padrão do BD.*/
        $data['data_nascimento'] = date('Y/m/d', strtotime($data['data_nascimento']));

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
    public function destroy($id) {
        /* Busca os dados do BD pelo ID. */
        $fornecedor = $this->fornecedor->find($id);

        $destroy = $fornecedor->delete();

        if ($destroy) 
            return redirect()->route('fornecedor.index');
        else
            return 'Falha ao apagar fornecedor!';
    }

    /**
     * Método para pesquisa por parâmetro escolhido pelo usuário.
     *
     * @param  App\Http\Requests\FornecedorRequest  $request
     * @return \Illuminate\Http\Response
     */

public function pesquisar(Request $request) {

    $fornecedor = $request->get('pesquisa');

    /* Pesquisa as fornecedores com o nome solicitado */
    $fornecedores = $this->fornecedor->where('nome', 'like', '%'.$fornecedor.'%')
    ->orWhere('cpf_ou_cnpj','like','%'.$fornecedor.'%')
    ->orWhere('created_at','like','%'.$fornecedor.'%')
    ->orderBy('id','DESC')
    ->paginate($this->totalPage);

    if($fornecedores)
        return view('painel.indexFornecedor', compact('fornecedores'));
    else
        return redirect()
    ->back()
    ->with('message', 'Atenção! Pesquisa concluída. Nenhum registro na base de dados!');
}
}