<?php

namespace App\Http\Controllers;

use App\Playlist;
use Illuminate\Http\Request;
use Auth;

class PlaylistController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $playlists = Auth::user()->playlists;

        return view('playlists.index',compact('playlists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('playlists.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = request()->validate([
           'name' => 'required|max:255|min:3'
        ]);

        $validate['user_id'] = Auth::id();

        Playlist::create($validate);

        return redirect('/playlists');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function show(Playlist $playlist)
    {
        return view('playlists.show',compact('playlist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Playlist $playlist)
    {
        return view('playlists.edit', compact('playlist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Playlist $playlist)
    {
        $validate = request()->validate([
           'name' => 'required|max:255|min:3'
        ]);
       
        $playlist->update($validate);
        
        return redirect('/playlists');   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Playlist $playlist)
    {
        if (Auth::user()->id == $playlist->user_id) {
            $playlist->delete();
            return json_encode(['success'=>'Playlist excluída com sucesso.']);
        }
        else {
            return json_encode(['error'=>'Não foi possível excluir essa playlist.']);   
        }
    }
}
