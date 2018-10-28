@extends('layouts.app')

@section('view-heading')
	Nova playlist:
@endsection

@section('errors')
	@include('errors')
@endsection 

@section('content')
	<form action="/playlists" method="POST" role="form">
		@csrf
		<div class="form-group">
			<label for="lblName"> Nome: </label>
			<input type="text" name="name" value="{{ old('name') }}" class="form-control" id="" placeholder="Nome da nova playlist" required>
		</div>
		<button type="submit" class="btn btn-primary">Criar</button>
	</form>
@endsection