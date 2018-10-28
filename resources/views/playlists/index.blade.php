@extends('layouts.app')

@section('view-heading')
	Minhas playlists:
@endsection

@section('content')
	<ul>
		@foreach($playlists as $playlist)
			<li> 
				<a href="/playlists/{{ $playlist->id }}"> {{ $playlist->name }} </a> 
			</li>
		@endforeach
	</ul>
	<a href="playlists/create" class="btn btn-sm btn-primary">Adicionar nova playlist</a>
@endsection