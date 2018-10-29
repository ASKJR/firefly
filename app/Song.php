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
}
