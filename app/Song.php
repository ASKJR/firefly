<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
	protected $fillable = ['playlist_id','name','artist','lyrics'];

	public function playlist()
	{
		return $this->belongsTo('\App\Playlist');
	}

	public function scopeByPlaylistIdSongNameArtist($query,$playlistId,$songName,$artistName)
	{
		return $query->where('playlist_id',$playlistId)
					 ->where('name',$songName)
					 ->where('artist',$artistName);
	}
}
