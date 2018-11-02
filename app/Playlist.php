<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Playlist extends Model
{
    use SoftDeletes;

    protected $fillable = ['name','user_id'];
    protected $dates = ['deleted_at'];
    
    public function songs()
    {
    	return $this->hasMany('\App\Song');
    }
}
