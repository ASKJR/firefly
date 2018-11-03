@extends('layouts.app')

@section('view-heading')
	Minhas playlists:
@endsection

@section('content')
	<ul class="list-group">
		@foreach($playlists as $playlist)
			<li class="list-group-item d-flex justify-content-between align-items-center" id="{{ $playlist->id }}"> 
				<h4>
					<a href="/playlists/{{ $playlist->id }}"> {{ $playlist->name }} </a>
					<span class="badge badge-primary badge-pill">{{ $playlist->songs->count() }}</span> 
				</h4> 

				<span class="badge badge-danger badge-pill"   style="cursor: pointer;" data-id="{{ $playlist->id }}">Excluir</span>
			</li>
		@endforeach
	</ul>
	<br>
	<a href="playlists/create" class="btn btn-sm btn-primary">Adicionar nova playlist</a>
@endsection

@section('own_js')
	<script type="text/javascript">
		$('.badge-danger').click(function(){
			swal({
				title: 'Tem certeza que deseja excluir essa playlist?',
				text: "Essa ação é irreversível e todas suas músicas serão perdidas.",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				cancelButtonText: 'Cancelar',
				confirmButtonText: 'Sim, quero excluir'
			}).then((result) => {
  				if (result.value) {
    				let playlist_id = $(this).data("id");
					if (playlist_id && confirm) {
						let url = '/playlists/' + playlist_id; 
						$.ajaxSetup({
							headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							}
						});
					    $.ajax({
				            type: "DELETE",
				            url: url,
				            dataType:"json",
				            success: function(data)
				            {
				            	if (data.success) {
				            		swal({
										type: 'success',
										title: data.success,
									})
									$('#' + playlist_id).remove();
				            	}
				            	else {
				            		swal({
										type: 'error',
										title: 'Oops...',
										text: data.error
									})
				            	}
				            }
			         	});
					}		
  				}
			})
		});
	</script>
@endsection 