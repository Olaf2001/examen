<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    // function for the relationship between status and noteHasUser
    function noteHasUsers() {
        return $this->hasMany('App\NoteHasUser');
    }
}
