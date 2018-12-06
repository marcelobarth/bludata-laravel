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
{!! Form::model($data, ['route' => ['empresa.update', $data->id], 'class' => 'form', 'method' => 'put', 'id' => 'form-table']) !!}
@else
{!! Form::open(['route' => 'empresa.store', 'id' => 'form-table']) !!}
@endif

<h2 class="text-uppercase" style="margin-left: 1em; margin-bottom: 1em">{!! $title !!}</h2>

@csrf
<!-- Text input UF -->
<div class="form-group">
	{!! Form::label('uf', 'UF'); !!}
	{!! Form::select('uf', ['AC' => 'Acre', 'AL' => 'Alagoas', 'AP' => 'Amapá', 'AM' => 'Amazonas', 'BA' => 'Bahia', 'CE' => 'Ceará', 'DF' => 'Distrito Federal', 'ES' => 'Espirito Santo', 'GO' => 'Goiás', 'MA' => 'Maranhão', 'MT' => 'Mato Grosso', 'MS' => 'Mato Grosso Sul', 'MG' => 'Minas Gerais', 'PA' => 'Pará', 'PB' => 'Paraíba', 'PR' => 'Paraná', 'PE' => 'Pernambuco', 'PI' => 'Piauí', 'RJ' => 'Rio de Janeiro', 'RN' => 'Rio Grande do Norte', 'RS' => 'Rio Grande do Sul', 'RO' => 'Rondônia', 'RR' => 'Roraima', 'SC' => 'Santa Catarina', 'SP' => 'São Paulo', 'SE' => 'Sergipe', 'TO' => 'Tocantins'], null, ['placeholder' => 'Seleciona o Estado', 'class' => 'form-control', 'id' => 'uf', 'value' => '$data->empresa']); !!}
</div>
<!-- Text input Nome Fantasia -->
<div class="form-group">
	{!! Form::label('nome_fantasia', 'NOME FANTASIA'); !!}
	{!! Form::text('nome_fantasia', null, ['placeholder' => 'Digite o nome fantasia da empresa', 'class' => 'form-control', 'id' => 'nome_fantasia', 'name' => 'nome_fantasia', 'value' => '$data->nome_fantasia']); !!}
</div>
<!-- Text input Cpf_ou_Cnpj -->
<div class="form-group">
	{!! Form::label('cnpj', 'CNPJ'); !!}
	{!! Form::text('cnpj', null, ['placeholder' => 'Digite o cnpj da empresa', 'class' => 'form-control', 'id' => 'cnpj', 'name' => 'cnpj', 'value' => '$data->cnpj']); !!}
</div>
<!-- Buttons -->
<div class="row">
	<div class="form-inline" style="margin-left: 1em; margin-top: 1.5em">
		<!-- Button Salvar -->
		<div class="form-group">
			{!! Form::button('Salvar', ['class' => 'btn btn-primary', 'data-toggle' => 'modal', 'data-target' => '#exampleModal']); !!}
		</div>
		<!-- Button Voltar -->
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
