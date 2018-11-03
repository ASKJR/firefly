@extends('layouts.app')

@section('own_css')
  <link href="{{ asset('css/song.css') }}" rel="stylesheet">
@endsection
@section('view-heading')
	{{ $playlist->name }}
@endsection

@section('content')
	@foreach($playlist->songs as $song)
		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  			<div class="panel panel-default">
    			<div class="panel-heading" role="tab" id="heading{{ $song->id }}">
      				<h4 class="panel-title">
        				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $song->id }}" aria-expanded="true" aria-controls="collapseOne">
          					{{ $loop->iteration }} . {{ $song->artist }} - {{ $song->name }}
        				</a>
      				</h4>
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
	@endforeach
	<a href="/playlists/{{ $playlist->id }}/edit" class="btn btn-sm btn-primary">Editar</a>	
@endsection