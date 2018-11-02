<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vagalume\Vagalume;
use App\Playlist;
use App\Song;

class PlaylistSongController extends Controller
{
    /**
     * @return JSON
     */
    public function ajaxSearchSong()
    {
    	$data = request()->validate([
    		'artistName' => 'required|max:255',
    		'songName' => 'required|max:255'
    	]);

    	$vagalumeApi = new Vagalume(env('VAGALUME_API_KEY'));
    	$song = $vagalumeApi->searchSong($data['artistName'],$data['songName']);
    	
    	return json_encode($song);
    }

    public function ajaxStore()
    {
    	$data = request()->validate([
    		'playlist_id' => 'required',
    		'name' => 'required|max:255',
    		'artist'=> 'required|max:255',
    		'lyrics'=> 'required'
    	]);

    	$song = Song::ByPlaylistIdSongNameArtist($data['playlist_id'],$data['name'],$data['artist']);
    	
    	if (!empty($song->first())) {
    		return json_encode(['error' => 'Essa música já foi adicionada na sua playlist.']);
    	}

    	Song::create($data);

    	return json_encode(['success' => 'A música foi salva com sucesso na sua playlist :)']);
    }
}
