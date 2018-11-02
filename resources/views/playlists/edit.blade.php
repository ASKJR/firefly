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
		<div class="col-md-9">
			<div class="row btnAddPlaylist" style="display: none;">
				<a href="#" class="btn btn-sm btn-success" id="addPlaylist">+ Adicionar na playlist</a>
			</div>
			<div id="lyricContent">
				<div class="row">
					<h1 id="songTitle"></h1>	
				</div>
				<div class="row">
					<h2 id="singerName"></h2>
				</div>
				<div  class="row "id="lyrics">
					<p id="lyricsText"></p>	
				</div>
			</div>
		</div>
	</div>
@endsection
@section('own_js')
	<script type="text/javascript">
		$(document).ready(function(){
			let song = null;

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
		            	song = JSON.parse(data);

		            	//song_not_found
		            	if (song.length == 0) {
		            		hideLyric();
		            		song = null;
		            		swal({
								type: 'error',
								title: 'Oops...',
								text: 'Não foi possível encontrar a música desejada ;('
							})
						//song_found
		            	} else {
		            		$('.btnAddPlaylist').show();
		            		$('#songTitle').text(song.song);
		            		$('#singerName').html('<a href="#">'+ song.artist + '</a>');
		            		$('#lyricsText').text(song.lyrics);
		            	}
		            }
	         	});
			    e.preventDefault(); // avoid to execute the actual submit of the form.
			});

			$('#addPlaylist').click(function(e){
				if (song != null) {
					$.ajaxSetup({
  						headers: {
    						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  						}
					});
				    $.ajax({
			            type: "POST",
			            url: "/playlistsong",
			            dataType:"json",
			            data: {
			            	'playlist_id': {{ $playlist->id }},
			            	'name': song.song,
			            	'artist': song.artist,
			            	'lyrics': song.lyrics
			            },
			            success: function(data)
			            {
			            	if (data.success) {
			            		swal({
									type: 'success',
									title: data.success,
								})
								hideLyric();
			            	}
			            	else {
			            		swal({
									type: 'error',
									title: 'Oops...',
									text: data.error
								})
								hideLyric();
			            	}
			            }
		         	});
	         	}
			});
		});

		function hideLyric()
		{
			$('#lyricContent div > *').empty();
		    $('.btnAddPlaylist').hide();        	
		}
	</script>
@endsection