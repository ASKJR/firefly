<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
	protected $fillable = ['name','artist','lyrics'];

	public function playlists()
	{
		return $this->belongsToMany('\App\Playlist');
	}

	public function scopeByNameArtist($query,$songName,$artistName)
	{
		return $query->where('name',$songName)
					 ->where('artist',$artistName);
	}
}
