@extends('adminlte::page')

@section('content')
@if (isset($errors) && count($errors) > 0)
<div class="alert alert-danger">
	<!-- Personalização das mensagens de erros -->
	@if (isset($data))
	<h3>Falha ao editar!</h3>
	@else
	<h3>Falha ao cadastrar!</h3>
	@endif
	@foreach ($errors->all() as $error)
	<h5>{!! $error !!}</h5>
	@endforeach
</div>
@endif

<!-- Verificação para exibir o form de editar ou cadastrar. -->
@if(isset($data))
{!! Form::model($data, ['route' => ['empresa.update', $data->id], 'class' => 'form', 'method' => 'put', 'name' => 'form-table', 'id' => 'form-table']) !!}
@else
{!! Form::open(['route' => 'empresa.store', 'id' => 'form-table']) !!}
@endif

<h2 class="text-uppercase" style="margin-left: 1em; margin-bottom: 1em">{!! $title !!}</h2>

@csrf
<!-- Text input Nome-->
<div class="form-group">
	{!! Form::label('uf', 'UF'); !!}
	{!! Form::select('uf', ['AC' => 'Acre', 'AL' => 'Alagoas', 'AP' => 'Amapá', 'AM' => 'Amazonas', 'BA' => 'Bahia', 'CE' => 'Ceará', 'DF' => 'Distrito Federal', 'ES' => 'Espirito Santo', 'GO' => 'Goiás', 'MA' => 'Maranhão', 'MT' => 'Mato Grosso', 'MS' => 'Mato Grosso Sul', 'MG' => 'Minas Gerais', 'PA' => 'Pará', 'PB' => 'Paraíba', 'PR' => 'Paraná', 'PE' => 'Pernambuco', 'PI' => 'Piauí', 'RJ' => 'Rio de Janeiro', 'RN' => 'Rio Grande do Norte', 'RS' => 'Rio Grande do Sul', 'RO' => 'Rondônia'], null, ['placeholder' => 'Seleciona o Estado', 'class' => 'form-control', 'id' => 'uf', 'value' => '$data->uf']); !!}
</div>
<!-- Text input Nome-->
<div class="form-group">
	{!! Form::label('nome_fantasia', 'NOME FANTASIA'); !!}
	{!! Form::text('nome_fantasia', null, ['placeholder' => 'Digite o nome fantasia da empresa', 'class' => 'form-control', 'id' => 'nome_fantasia', 'name' => 'nome_fantasia', 'value' => '$data->nome_fantasia']); !!}
</div>
<!-- Text input-->
<div class="form-group">
	{!! Form::label('cnpj', 'CNPJ'); !!}
	{!! Form::text('cnpj', null, ['placeholder' => 'Digite o cnpj da empresa', 'class' => 'form-control', 'id' => 'cnpj', 'name' => 'cnpj', 'value' => '$data->cnpj', 'onKeyPress' => 'MascaraCNPJ(form-table.cnpj);',  
'onBlur' => 'ValidarCNPJ(form-table.cnpj);']); !!}
</div>
<div class="row">
	<div class="form-inline" style="margin-left: 1em; margin-top: 1.5em">
		<!-- Button -->
		<div class="form-group">
			{!! Form::button('Salvar', ['class' => 'btn btn-primary', 'data-toggle' => 'modal', 'data-target' => '#exampleModal']); !!}
		</div>
		<!-- Button -->
		<div class="form-group">
			<a class="btn btn-outline-secondary" type="button" href="{!! URL::previous() !!}">Voltar</a>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="documentabindext">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Alerta</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<!-- Personalização das mensagens de alerta -->
			<div class="modal-body">
				@if (isset($data))
				Deseja salvar as modificações?
				@else
				Deseja salvar nova empresa?
				@endif
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				<button type="submit" class="btn btn-primary">Salvar</button>
			</div>
		</div>
	</div>
</div><!-- End Modal -->

{!! Form::close() !!}

@endsection

<script language="JavaScript" type="text/javascript" src="MascaraValidacao.js"></script>

<script type="text/javascript">
	
// JavaScript Document
//adiciona mascara de cnpj
function MascaraCNPJ(cnpj){
	if(mascaraInteiro(cnpj)==false){
		event.returnValue = false;
	}       
	return formataCampo(cnpj, '00.000.000/0000-00', event);
}

//adiciona mascara de cep
function MascaraCep(cep){
	if(mascaraInteiro(cep)==false){
		event.returnValue = false;
	}       
	return formataCampo(cep, '00.000-000', event);
}

//adiciona mascara de data
function MascaraData(data){
	if(mascaraInteiro(data)==false){
		event.returnValue = false;
	}       
	return formataCampo(data, '00/00/0000', event);
}

//adiciona mascara ao telefone
function MascaraTelefone(tel){  
	if(mascaraInteiro(tel)==false){
		event.returnValue = false;
	}       
	return formataCampo(tel, '(00) 0000-0000', event);
}

//adiciona mascara ao CPF
function MascaraCPF(cpf){
	if(mascaraInteiro(cpf)==false){
		event.returnValue = false;
	}       
	return formataCampo(cpf, '000.000.000-00', event);
}

//valida telefone
function ValidaTelefone(tel){
	exp = /\(\d{2}\)\ \d{4}\-\d{4}/
	if(!exp.test(tel.value))
		alert('Numero de Telefone Invalido!');
}

//valida CEP
function ValidaCep(cep){
	exp = /\d{2}\.\d{3}\-\d{3}/
	if(!exp.test(cep.value))
		alert('Numero de Cep Invalido!');               
}

//valida data
function ValidaData(data){
	exp = /\d{2}\/\d{2}\/\d{4}/
	if(!exp.test(data.value))
		alert('Data Invalida!');                        
}

//valida o CPF digitado
function ValidarCPF(Objcpf){
	var cpf = Objcpf.value;
	exp = /\.|\-/g
	cpf = cpf.toString().replace( exp, "" ); 
	var digitoDigitado = eval(cpf.charAt(9)+cpf.charAt(10));
	var soma1=0, soma2=0;
	var vlr =11;

	for(i=0;i<9;i++){
		soma1+=eval(cpf.charAt(i)*(vlr-1));
		soma2+=eval(cpf.charAt(i)*vlr);
		vlr--;
	}       
	soma1 = (((soma1*10)%11)==10 ? 0:((soma1*10)%11));
	soma2=(((soma2+(2*soma1))*10)%11);

	var digitoGerado=(soma1*10)+soma2;
	if(digitoGerado!=digitoDigitado)        
		alert('CPF Invalido!');         
}

//valida numero inteiro com mascara
function mascaraInteiro(){
	if (event.keyCode < 48 || event.keyCode > 57){
		event.returnValue = false;
		return false;
	}
	return true;
}

//valida o CNPJ digitado
function ValidarCNPJ(ObjCnpj){
	var cnpj = ObjCnpj.value;
	var valida = new Array(6,5,4,3,2,9,8,7,6,5,4,3,2);
	var dig1= new Number;
	var dig2= new Number;

	exp = /\.|\-|\//g
	cnpj = cnpj.toString().replace( exp, "" ); 
	var digito = new Number(eval(cnpj.charAt(12)+cnpj.charAt(13)));

	for(i = 0; i<valida.length; i++){
		dig1 += (i>0? (cnpj.charAt(i-1)*valida[i]):0);  
		dig2 += cnpj.charAt(i)*valida[i];       
	}
	dig1 = (((dig1%11)<2)? 0:(11-(dig1%11)));
	dig2 = (((dig2%11)<2)? 0:(11-(dig2%11)));

	if(((dig1*10)+dig2) != digito)  
		alert('CNPJ Invalido!');

}

//adiciona mascara ao RG
function MascaraRG(rg){
	if((rg)==false){
		event.returnValue = false;
	}       
	return formataCampo(rg, '00.000.000-0', event);
}

//formata de forma generica os campos
function formataCampo(campo, Mascara, evento) { 
	var boleanoMascara; 

	var Digitato = evento.keyCode;
	exp = /\-|\.|\/|\(|\)| /g
	campoSoNumeros = campo.value.toString().replace( exp, "" ); 

	var posicaoCampo = 0;    
	var NovoValorCampo="";
	var TamanhoMascara = campoSoNumeros.length;; 

        if (Digitato != 8) { // backspace 
        	for(i=0; i<= TamanhoMascara; i++) { 
        		boleanoMascara  = ((Mascara.charAt(i) == "-") || (Mascara.charAt(i) == ".")
        			|| (Mascara.charAt(i) == "/")) 
        		boleanoMascara  = boleanoMascara || ((Mascara.charAt(i) == "(") 
        			|| (Mascara.charAt(i) == ")") || (Mascara.charAt(i) == " ")) 
        		if (boleanoMascara) { 
        			NovoValorCampo += Mascara.charAt(i); 
        			TamanhoMascara++;
        		}else { 
        			NovoValorCampo += campoSoNumeros.charAt(posicaoCampo); 
        			posicaoCampo++; 
        		}              
        	}      
        	campo.value = NovoValorCampo;
        	return true; 
        }else { 
        	return true; 
        }
    }
</script>