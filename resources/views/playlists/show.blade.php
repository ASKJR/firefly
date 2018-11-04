@extends('layouts.app')

@section('own_css')
  <link href="{{ asset('css/song.css') }}" rel="stylesheet">
@endsection
@section('view-heading')
	{{ $playlist->name }}
@endsection

@section('content')
	@foreach($playlist->songs as $song)
        <ul class="list-group">
    		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
      			<div class="panel panel-default">
        			<div class="panel-heading" role="tab" id="heading{{ $song->id }}">
                        <li class="list-group-item d-flex justify-content-between align-items-center" id="{{ $song->id }}"> 
                            <h4 class="panel-title">
                				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $song->id }}" aria-expanded="true" aria-controls="collapseOne">
                  					{{ $loop->iteration }} . {{ $song->artist }} - {{ $song->name }}
                				</a>
                            </h4>
                            <span class="badge badge-danger badge-pill"   style="cursor: pointer;" data-idsong="{{ $song->id }}" data-idplaylist="{{ 
                                $playlist->id }}">Excluir</span>
                        </li>
        			</div>
        			<div id="collapse{{ $song->id }}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading{{ $song->id }}">
          				<div class="panel-body">
                            <div id="lyricContent">
                                <div id="lyrics">
                                    <p> {{ $song->lyrics }} </p>
                                </div>
                            </div>
          				</div>
        			</div>
      			</div>
      		</div>
        </ul>
	@endforeach
	<a href="/playlists/{{ $playlist->id }}/edit" class="btn btn-sm btn-primary" style="margin-top: 15px;">Editar</a>	
@endsection

@section('own_js')
    <script type="text/javascript">
        $('.badge-danger').click(function() {
            let playlist_id = $(this).data("idplaylist");
            let song_id = $(this).data("idsong");
            if (playlist_id && song_id) {
                let url = '/playlistsong/ajax/remove-song';
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "DELETE",
                    url: url,
                    data: {
                        'playlist_id' : playlist_id,
                        'song_id':song_id
                    },
                    dataType:"json",
                    success: function(data)
                    {
                        if (data.success) {
                            swal({
                                type: 'success',
                                title: data.success,
                            })
                            $('#' + song_id).remove();
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
        });
    </script>
@endsection 