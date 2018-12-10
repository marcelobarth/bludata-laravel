@extends('adminlte::page')

@section('content')

<!-- Mensagens de erro -->
@if(session()->has('message'))
<div class="alert alert-danger">
	{{ session()->get('message') }}
</div>
@endif

<div class="col-md-12">
	<div class="row d-flex bd-highlight" id="form-index">
		<div class="form-inline ">
			<div class="col-sm-4">
				<legend>FORNECEDORES CADASTRADOS</legend>
			</div>
			<!-- Input Pesquisa -->
			<div class="col-sm-8">
				{!! Form::open(['url' => ['pesquisar/fornecedores'], 'id' => 'form-table', 'name' => 'pesquisa']) !!}
				{!! Form::text('pesquisa', null, ['placeholder' => 'Digite uma palavra chave', 'class' => 'form-control']); !!}
				{!! Form::button('Buscar', ['type' => 'submit', 'class' => 'btn btn-info']); !!}
				{!! Form::close() !!}
			</div>
		</div>
	</div>
	<table class="table table-dark">
		<thead>
			<tr class="bg-primary">
				<th>ID</th>
				<th>EMPRESA</th>
				<th>NOME</th>
				<th>CNPJ/CPF</th>
				<th>RG</th>
				<th>TEL.COM</th>
				<th>TEL.RES</th>
				<th>TEL.CEL</th>
				<th>DATA NASC</th>
				<th>AÇÃO</th>
			</tr>
		</thead>

		@foreach($fornecedores as $forn)

		<tbody>
			<tr>
				<td>{!! $forn->id !!}</td>
				<td>{!! $forn->empresa->nome_fantasia !!}</td>
				<td>{!! $forn->nome !!}</td>
				<td>{!! $forn->cpf_ou_cnpj !!}</td>
				<td>{!! $forn->rg !!}</td>
				<td>{!! $forn->telefone_comercial !!}</td>
				<td>{!! $forn->telefone_residencial !!}</td>
				<td>{!! $forn->telefone_celular !!}</td>
				<td>{!! $forn->data_nascimento !!}</td>
				<td>
					<div class="form-inline ">
						<!-- Button -->
						<div class="form-group">
							<!-- Botão Editar -->
							{!! Form::open(['url' => 'fornecedor/'. $forn->id .'/edit', 'method' => 'get']) !!}
							{!! Form::button('Editar', ['type' => 'submit','class' => 'btn btn-warning btn-sm']); !!}
							{!! Form::close() !!}
						</div>
						<div class="form-group">
							<!-- Botão Deletar -->
							{!! Form::open(['route' => ['fornecedor.destroy', $forn->id], 'method' => 'delete']) !!}
							{!! Form::button('Apagar', ['class' => 'btn btn-danger btn-sm', 'data-toggle' => 'modal', 'data-target' => '#exampleModal']); !!}
						</div>
					</div>
				</td>
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
							<!-- Mensagem de alerta -->
							<div class="modal-body">
								Deseja mesmo apagar fornecedor?
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
								<button type="submit" class="btn btn-primary">Apagar</button>
							</div>
						</div>
					</div>
				</div><!-- End Modal -->
				<!-- Fechamento do Form Delete para podepegar o submit do button Apagar Modal -->
				{!! Form::close() !!}
			</tr>
		</tbody>

		@endforeach

	</table>

	<!-- Método para paginação -->
	{!! $fornecedores->links() !!}

</div>

@endsection

