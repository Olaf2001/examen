<?php

namespace App\Http\Controllers;

use App\User;
use App\NoteHasUser;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    // show table with all users
    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    // update a user
    public function update(Request $request, User $user)
    {
        // request is the same then the register method, with small changes
        $request->validate([
            'name' => ['required', 'string', 'max:45'],
            'email' => ['required', 'string', 'email', 'max:45','unique:users,email,'.$user->id],
            'password' => ['string', 'min:8', 'nullable'],
            'password2' => ['same:password'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if($request->password <> '') {
            $user->password = bcrypt($request->password);     
        }
        $user->save();

        if(auth()->user()->id == $user->id) {
            $message = 'Mijn gegevens zijn aangepast';
        }
        else {
            $message = 'Gebruiker is aangepast';
        }

        return redirect()->back()->with('message', $message);
    }

    // delete a user
    public function destroy(User $user)
    {
        // first the relationship between note and user will be deleted, then the user, note will stay.
        $noteHasUsers = NoteHasUser::all();

        foreach($noteHasUsers as $noteHasUser) {
            if($noteHasUser->user_id == $user->id) {
                $noteHasUser->delete();
            }
        }
        
        $user->delete();

        return redirect()->back()->with('message','Gebruiker is verwijderd');
    }
}
