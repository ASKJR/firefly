@extends('layouts.app')

@section('view-heading')
	{{ $playlist->name }}
@endsection

@section('content')
	<div class="row">
		<div class="col-md-1">
			<a href="/playlists/{{ $playlist->id }}/edit" class="btn btn-sm btn-primary">Editar</a>	
		</div>
		<div class="col-md-1">
			<form action="/playlists/{{ $playlist->id }}" method="POST" role="form">
				@method('DELETE')
				@csrf
				<button type="submit" class="btn btn-sm btn-danger">Excluir</button>
			</form>
		</div>
	</div>
@endsection