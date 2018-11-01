@extends('layouts.app')

@section('own_css')
	<link href="{{ asset('css/song.css') }}" rel="stylesheet">
@endsection

@section('errors')
	@include('errors')
@endsection 

@section('content')
	<div class="row">
		<div class="col-md-3">
			<form action="/playlists/{{ $playlist->id }}" method="POST" role="form">
				<legend>Editar:</legend>
				@method('PATCH')
				@csrf
				<div class="form-group">
					<label for="lblName"> Nome: </label>
					<input type="text" name="name"  value="{{ $playlist->name }}"class="form-control" id="" placeholder="Nome da nova playlist" required>
				</div>
				<button type="submit" class="btn btn-primary">Alterar nome</button>
			</form>
			<hr>
			<form action="/playlistsong/ajax/search" method="POST" role="form" id="searchSongForm">
				@csrf
				<legend>Buscar música:</legend>
			
				<div class="form-group">
					<label for="lblArtist">Artista:</label>
					<input type="text" class="form-control" name="artistName" id="#artistName" placeholder="Nome do artista" >
				</div>

				<div class="form-group">
					<label for="lblSong">Música:</label>
					<input type="text" class="form-control" name="songName" id="#songName" placeholder="Nome da música" >
				</div>
			
				<button type="submit" class="btn btn-primary">Buscar</button>
			</form>
		</div>
		<div class="col-md-9" id="lyricContent">
			<h1 id="songTitle"></h1>
			<h2 id="singerName"></h2>
			<br>
			<div id="lyrics">
				<p id="lyricsText"></p>
			</div>
		</div>
	</div>
@endsection
@section('own_js')
	<script type="text/javascript">
		$(document).ready(function(){
			$("#searchSongForm").submit(function(e) {
	    		
	    		var form = $(this);
	    		var url = form.attr('action');
			    
			    $.ajax({
		            type: "POST",
		            url: url,
		            dataType:"json",
		            data: form.serialize(),
		            success: function(data)
		            {
		            	data = JSON.parse(data);

		            	//song_not_found
		            	if (data.length == 0) {
		            		$('#lyricContent > h1,h2,p').empty();
		            		swal({
								type: 'error',
								title: 'Oops...',
								text: 'Não foi possível encontrar a música desejada ;('
							})
						//song_found
		            	} else {
		            		$('#songTitle').text(data.song);
		            		$('#singerName').html('<a href="#">'+ data.artist + '</a>');
		            		$('#lyricsText').text(data.lyrics);
		            		console.log(data.lyrics);
		            	}
		            }
	         	});
			    e.preventDefault(); // avoid to execute the actual submit of the form.
			});
		});
	</script>
@endsection