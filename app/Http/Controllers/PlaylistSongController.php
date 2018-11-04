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

    /**
     * ajaxStore: 
     * 1) Insert a  new (unique) song in the database.
     * 2) Insert in the user's playlist the newest song.
     * @return JSON
     */
    public function ajaxStore()
    {
    	$data = request()->validate([
    		'playlist_id' => 'required',
    		'name' => 'required|max:255',
    		'artist'=> 'required|max:255',
    		'lyrics'=> 'required'
    	]);

        $playlist = Playlist::findOrFail($data['playlist_id']);
    	$song = Song::ByNameArtist($data['name'],$data['artist'])->first();

    	//Insert a new song in database, if does not exist already
        if (empty($song)) {
            unset($data['playlist_id']);
    		$song = Song::create($data);
    	}
        //get an array with songIds from user's playlist
        $playlistSongIds = $playlist->songs->map->id->toArray();

        //song doest no exist in user playlist
        if (!in_array($song->id, $playlistSongIds)) {
            //insert in the pivot table (playlist_song)
            $playlist->songs()->attach($song->id);
            return json_encode(['success' => 'A música foi salva com sucesso na sua playlist :)']);
        }
        //songs already exists in user's playlist
        else {
            return json_encode(['error' => 'Essa música já foi adicionada na sua playlist.']);
        }
    }

    /**
     * @return JSON
     */
    public function removeSongFromPlaylist()
    {
        $data = request()->validate([
            'playlist_id' => 'required',
            'song_id' => 'required'
        ]);

        $playlist = Playlist::findOrFail($data['playlist_id']);
        
        //removing a song from playlist.. removing data from pivot table (PlaylistSong) 
        if ($playlist->songs()->detach($data['song_id'])) {
            return json_encode(['success' => 'Música removida com sucesso da playlist:)']);
        }
        //not possible to remove song from playlist    
        else {
            return json_encode(['error' => 'Não foi possível remover essa música da playlist.']);
        }
    }
}
