<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    // function for the relationship between note and noteHasUser
    function noteHasUsers() {
        return $this->hasMany('App\NoteHasUser');
    }
}
