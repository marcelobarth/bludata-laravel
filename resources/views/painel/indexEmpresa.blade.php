@extends('adminlte::page')

@section('content')

<div class="col-md-12">
	<table class="table table-dark">
		<thead>
			<tr class="bg-primary">
				<th>ID</th>
				<th>UF</th>
				<th>NOME FANTASIA</th>
				<th>CNPJ</th>
				<th>AÇÃO</th>
			</tr>
		</thead>

		@foreach($data as $emp)

		<tbody>
			<tr>
				<td>{!! $emp->id !!}</td>
				<td>{!! $emp->uf !!}</td>
				<td>{!! $emp->nome_fantasia !!}</td>
				<td>{!! $emp->cnpj !!}</td>
				<td>
					<div class="form-inline ">
						<!-- Button -->
						<div class="form-group">
							<!-- Botão Editar -->
							{!! Form::open(['url' => 'empresa/'. $emp->id .'/edit', 'method' => 'get']) !!}
							{!! Form::button('Editar', ['type' => 'submit','class' => 'btn btn-warning btn-sm']); !!}
							{!! Form::close() !!}
						</div>
						<div class="form-group">
							<!-- Botão Deletar -->
							{!! Form::open(['route' => ['empresa.destroy', $emp->id], 'method' => 'delete']) !!}
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
								Deseja mesmo apagar partitura?
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
	{!! $data->links() !!}

</div>

@endsection

