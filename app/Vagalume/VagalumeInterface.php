<?php

namespace App\Vagalume;

interface VagalumeInterface
{
	/**
	 * searchSong in vagalume.com
	 * @param  string $art name of the singer
	 * @param  string $mus name of the song
	 * @return string JSON
	 */
	public function searchSong($art = null, $mus = null);
}