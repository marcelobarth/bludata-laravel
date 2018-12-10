@extends('adminlte::page')

@section('content')

<!-- Eixibição de erros Requests -->
@if ($errors->any())
<div class="alert alert-danger">
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif

@if(session()->has('message'))
<div class="alert alert-danger">
	{{ session()->get('message') }}
</div>
@endif

<!-- Verificação para exibir o form de editar ou cadastrar. -->
@if(isset($fornecedor))
{!! Form::model($fornecedor, ['route' => ['fornecedor.update', $fornecedor->id], 'class' => 'form', 'method' => 'put', 'id' => 'form-table']) !!}
@else
{!! Form::open(['route' => 'fornecedor.store', 'id' => 'form-table']) !!}
@endif
<h2 class="text-uppercase" style="margin-left: 1em; margin-bottom: 1em">{!! $title !!}</h2>

@csrf
<!-- Text input Empresa -->
<div class="form-group">
	{!! Form::label('empresa_id', 'EMPRESA'); !!}
	@if(!null  == ('$empresa->fornecedor->nome_fantasia'))
	{!! Form::select('empresa_id', $empresa, null, ['placeholder' => 'Escolha uma Empresa', 'class' => 'form-control']); !!}
	@else
	{!! Form::select('empresa_id', $empresa, null, ['placeholder' => 'Escolha uma Empresa', 'class' => 'form-control']); !!}
	@endif
</div>
<!-- Text input Nome -->
<div class="form-group">
	{!! Form::label('nome', 'NOME'); !!}
	{!! Form::text('nome', null, ['placeholder' => 'Digite o nome do fornecedor', 'class' => 'form-control']); !!}
</div>
<!-- Text input Cpf_ou_Cnpj -->
<div class="form-group">
	{!! Form::label('cpf_ou_cnpj', 'CPF ou CNPJ'); !!}
	{!! Form::text('cpf_ou_cnpj', null, ['placeholder' => 'Digite o cnpj, se Pessoa Júridica, ou cpf do se Pessoa Física', 'class' => 'form-control']); !!}
</div>
<!-- Text input Rg -->
<div class="form-group">
	{!! Form::label('rg', 'RG'); !!}
	{!! Form::text('rg', null, ['placeholder' => 'Digite o rg, obrigatório para Pessoa Física', 'class' => 'form-control']); !!}
</div>
<div class="form-row">
	<!-- Text input Telefone -->
	<div class="form-group col-md-4">
		{!! Form::label('telefone_comercial', 'FONE COMERCIAL.'); !!}
		{!! Form::text('telefone_comercial', null, ['placeholder' => 'Digite o número o telefone comercial', 'class' => 'input bfh-phone']); !!}
	</div>
	<!-- Text input Telefone -->
	<div class="form-group col-md-4">
		{!! Form::label('telefone_residencial', 'FONE RESIDENCIAL.'); !!}
		{!! Form::text('telefone_residencial', null, ['placeholder' => 'Digite o número o telefone residencial', 'class' => 'input bfh-phone']); !!}
	</div>
	<!-- Text input Telefone -->
	<div class="form-group col-md-4">
		{!! Form::label('telefone_celular', 'FONE CELULAR.'); !!}
		{!! Form::text('telefone_celular', null, ['placeholder' => 'Digite o número  o telefone celular', 'class' => 'input bfh-phone']); !!}
	</div>
</div>
<!-- Text input Data de Nascimento -->
<div class="form-group">
	{!! Form::label('data_nascimento', 'DATA NASCIMENTO'); !!}
	{!! Form::date('data_nascimento', null, ['placeholder' => 'Digite a data de nascimento, obrigatório para Pessoa Física', 'class' => 'form-control']); !!}
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
				@if (isset($fornecedor))
				Deseja salvar as modificações?
				@else
				Deseja salvar nova fornecedor?
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
