<?php

namespace App\Http\Controllers;

use App\Note;
use App\NoteHasUser;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\NotesRequest;

class NotesController extends Controller
{
    // see a grid template of all notes
    public function index()
    {
        $notes = Note::all();
        $noteHasUsers = NoteHasUser::all();
        $users = User::all();

        return view('notes.index', compact('notes','noteHasUsers','users'));
    }

    // function to insert a note to the database
    public function store(NotesRequest $request)
    {
        $note = new Note();

        $note->title = $request->title;
        $note->note = $request->note;
        $note->save();

        // the asigned users will also be stored. First we will look at the author
        // and next the person who are asigned
        $noteAuthor = new NoteHasUser();
        
        $noteAuthor->status_id = 1;
        $noteAuthor->note_id = $note->id;
        $noteAuthor->user_id = auth()->user()->id;
        $noteAuthor->save();

        // the users who are asigned
        $requestUsers = $request->user_id;

        if($requestUsers <> '') {
            foreach($requestUsers as $requestUser) {
                $noteAsigned = new NoteHasUser();

                $noteAsigned->status_id = 2;
                $noteAsigned->note_id = $note->id;
                $noteAsigned->user_id = $requestUser;
                $noteAsigned->save();
            }
        }

        return redirect()->route('notes.index')->with('message','Notitie is gemaakt');
    }

    // update a note
    public function update(NotesRequest $request, Note $note)
    {
        $note->title = $request->title;
        $note->note = $request->note;
        $note->save();

        // the relationship between the users and note will first all be deleted, except the from the author.
        // then all relationships (the new ones) will be made.
        $noteHasUsers = NoteHasUser::all();

        foreach($noteHasUsers as $noteHasUser) {
            if($noteHasUser->note_id == $note->id) {
                if($noteHasUser->status_id <> 1) {
                    $noteHasUser->delete();
                }
            }
        }

        // the users who are asigned
        $requestUsers = $request->user_id;

        if($requestUsers <> '') {
            foreach($requestUsers as $requestUser) {
                $noteAsigned = new NoteHasUser();

                $noteAsigned->status_id = 2;
                $noteAsigned->note_id = $note->id;
                $noteAsigned->user_id = $requestUser;
                $noteAsigned->save();
            }
        }

        return redirect()->route('notes.index')->with('message','Notitie is aangepast');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        //
    }
}
