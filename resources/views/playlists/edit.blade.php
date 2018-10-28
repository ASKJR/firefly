@extends('layouts.app')

@section('view-heading')
	Editar playlist:
@endsection

@section('errors')
	@include('errors')
@endsection 

@section('content')
	<div class="row">
		<div class="col-md-6">
			<form action="/playlists/{{ $playlist->id }}" method="POST" role="form">
				@method('PATCH')
				@csrf
				<div class="form-group">
					<label for="lblName"> Nome: </label>
					<input type="text" name="name"  value="{{ $playlist->name }}"class="form-control" id="" placeholder="Nome da nova playlist" required>
				</div>
				<button type="submit" class="btn btn-sm btn-primary">Salvar alterações</button>
			</form>
		</div>
		<div class="col-md-6">
			<!-- editing songs-->
		</div>
	</div>
@endsection