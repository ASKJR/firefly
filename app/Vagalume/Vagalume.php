<?php

namespace App\Vagalume;

use GuzzleHttp\Client;

class Vagalume implements VagalumeInterface
{
	//api.vagalume.com.br responses
	CONST SONG_FOUND = 'exact'; // Resposta exata (artista e música foram encontrados).
	CONST SONG_APROX_FOUND = 'aprox'; // O título da música não foi encontrada exatamente como pesquisado.
	CONST SONG_NOT_FOUND = 'song_notfound'; // O título da música não foi encontrado e não existem possíveis resultados.
	CONST ARTIST_NOT_FOUND = 'notfound'; //O artista não foi encontrado.

	private $endPoint = 'https://api.vagalume.com.br/';
	private $apiKey;
	private $httpClient;

	/**
	 * Constructor
	 * @param string $apiKey
	 */
	public function __construct($apiKey)
	{
		$this->apiKey = $apiKey;
		$this->httpClient = new Client();
	}

	/**
	 * searchSong in vagalume.com
	 * @param  string $art name of the singer
	 * @param  string $mus name of the song
	 * @return string JSON
	 */
	public function searchSong($art = null, $mus = null) 
	{
		if (!empty($art) && !empty($mus) && !empty($this->apiKey)) {

			$url = $this->endPoint . sprintf("search.php?art=%s&mus=%s&apikey=%s", $art, $mus, $this->apiKey);
			$song = json_decode($this->makeRequest($url),true);

			if ($song['type'] !== self::SONG_NOT_FOUND && $song['type'] !== self::ARTIST_NOT_FOUND) {
				
				return json_encode([
					'artist' => $song['art']['name'],
					'song' => $song['mus']['0']['name'], 
					'lyrics' =>$song['mus']['0']['text'] 
				]);
			}
		}

		return json_encode([]);
	}

	/**
	 * @param  string $url
	 * @param  string $method 
	 * @return string         JSON
	 */
	private function makeRequest ($url, $method = 'GET')
	{
		return $this->httpClient->request($method, $url)->getBody()->getContents();
	}
}