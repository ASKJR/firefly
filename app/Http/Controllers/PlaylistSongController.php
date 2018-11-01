<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vagalume\Vagalume;

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
}
