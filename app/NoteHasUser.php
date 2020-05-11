<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoteHasUser extends Model
{
    // function for the relationship between noteHasUser and note
    function note() {
        return $this->belongsTo('App\Note');
    }

    // function for the relationship between noteHasUser and user
    function user() {
        return $this->belongsTo('App\User');
    }
    
    // function for the relationship between noteHasUser and status
    function status() {
        return $this->belongsTo('App\Status');
    }
}
