@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-between">
            <h2>Notes</h2>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createNote">Maak een Notitie</button>
        </div>

        <!-- message when something went well -->
        @if(session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <!-- message when there are errors -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('notes.index') }}">
            <div class="form-group">
                <label for="filter-user">Filter notitie op een gebruiker:</label>
                <div class="input-group">
                    <select class="form-control" id="filter-user" name="filterUser">
                        <option {{ $filterUser == 0 ? 'selected' : ''}} value=0>Alle notities</option>
                        @foreach($users as $user)
                            <option {{ $filterUser == $user->id ? 'selected' : ''}} value={{ $user->id }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit">Filter</button>
                    </div>
                </div>
            </div>
        </form>

        <!-- if there is no relationship there will be an error -->
        @if(count($notes) >= 1)
            <div class="row justify-content-between">
                <!-- code will be repeated for each note -->
                @foreach($notes as $note)
                    
                    <!-- get the id of the user who write a note -->
                    @php($authorUserId = "")
                    <!-- code will be repeated for each noteHasUser -->
                    @foreach($noteHasUsers as $noteHasUser)
                        @if($noteHasUser->note_id == $note->id)
                            @if($noteHasUser->status_id == 1)
                                @php($authorUserId = $noteHasUser->user_id)
                            @endif
                        @endif
                    @endforeach

                    <div class="col-md-3" style="padding:30px; margin:20px; background-color:white;">
                        <h3>{{ $note->title }}</h3>
                        <p>{{ Str::limit($note->note, 150, '...') }}</p>
                        <div class="button-section">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#showNote{{$note->id}}">Show</button>
                            <!-- only admin or the user who write the note could open the edit en delete pop-up -->
                            @if(Auth::user()->getRoleNames() == '["admin"]' or Auth::user()->id == $authorUserId)
                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editNote{{$note->id}}">Edit</button>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteNote{{$note->id}}">Delete</button>
                            @endif
                        </div>
                    </div>

                    <!-- modal with the show method -->
                    <div class="modal fade" id="showNote{{$note->id}}">
                        <div class="modal-dialog">
                            <div class="modal-content">
            
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">{{ $note->title }}</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                    
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <p>{{ $note->note }}</p>
                                    <div>
                                        Personen gekoppeld aan deze notitite:
                                        <ul>
                                            <!-- for each NoteHasUser, the code will be repeated -->
                                            @foreach($noteHasUsers as $noteHasUser)
                                                @if($noteHasUser->note_id == $note->id)
                                                    <li>{{ $noteHasUser->user->name }} - {{ $noteHasUser->status->name }}</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                    
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Sluiten</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- only admin or the user who write the note could view this pop-up -->
                    @if(Auth::user()->getRoleNames() == '["admin"]' or Auth::user()->id == $authorUserId)
                        <!-- modal with the edit method -->
                        <div class="modal fade" id="editNote{{$note->id}}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{ $note->title }} Aanpassen</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                        
                                    <form method="POST" action="{{ route('notes.update', $note) }}">
                                    @csrf
                                    @method('PUT')
                    
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="container">
                                                <label>Titel van de notitie</label>
                                                <input class="form-control" name="title" type="text" placeholder="Vul hier de titel van de notitie" value="{{ $note->title }}"/>
                                                <label>Notitie</label>
                                                <textarea name="note" rows="10" class="form-control" placeholder="Vul de notitie in">{{ $note->note }}</textarea>
                                                <div>
                                                    Personen koppelen aan de notitie
                                                    <div class="row">
                                                        <!-- code will be repeated for each user -->
                                                        @foreach($users as $user)
                                                            @php($check = "")
                                                            @php($author = "")
                                                            <!-- code will be repeated for each noteHasUser -->
                                                            @foreach($noteHasUsers as $noteHasUser)
                                                                @if($noteHasUser->note_id == $note->id)
                                                                    @if($noteHasUser->user_id == $user->id)
                                                                        @php($check = "checked")
                                                                        @if($noteHasUser->status_id == 1)
                                                                            @php($author = "true")
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                            <!-- you can't assign the writer of the note -->
                                                            @if($author <> "true")
                                                                <div class="col-md-6 custom-control custom-checkbox">
                                                                    <input {{ $check }} id="note{{ $note->id }}User{{ $user->id }}" name="user_id[]" type="checkbox" class="custom-control-input" value="{{ $user->id }}"/>
                                                                    <label class="custom-control-label" for="note{{ $note->id }}User{{ $user->id }}">{{ $user->name }}</label>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-warning">Notitie Aanpassen</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- modal with the delete method -->
                        <div class="modal fade" id="deleteNote{{$note->id}}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{ $note->title }} Verwijderen</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                        
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <p>{{ $note->note }}</p>
                                        <div>
                                            Personen gekoppeld aan deze notitite:
                                            <ul>
                                                <!-- code will be repeated for each noteHasUser -->
                                                @foreach($noteHasUsers as $noteHasUser)
                                                    @if($noteHasUser->note_id == $note->id)
                                                        <li>{{ $noteHasUser->user->name }} - {{ $noteHasUser->status->name }}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                        
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <form method="POST" action="{{ route('notes.destroy', $note) }}">
                                        @csrf
                                        @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Verwijderen</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

                <!-- modal with the create method -->
                <div class="modal fade" id="createNote">
                    <div class="modal-dialog">
                        <div class="modal-content">
        
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Maak een notitie</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <form method="POST" action="{{ route('notes.store') }}">
                            @csrf
                            @method('POST')
                
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div class="container">
                                        <label>Titel van de notitie</label>
                                        <input class="form-control" name="title" type="text" placeholder="Vul hier de titel van de notitie"/>
                                        <label>Notitie</label>
                                        <textarea name="note" rows="10" class="form-control" placeholder="Vul de notitie in"></textarea>
                                        <div>
                                            Personen koppelen aan de notitie
                                            <div class="row">
                                                <!-- code will be repeated for each user, but logged in user will not be shown -->
                                                @foreach($users as $user)
                                                    @if(Auth::user()->id <> $user->id)
                                                        <div class="col-md-6 custom-control custom-checkbox">
                                                            <input id="user{{ $user->id }}" name="user_id[]" type="checkbox" class="custom-control-input" value="{{ $user->id }}"/>
                                                            <label class="custom-control-label" for="user{{ $user->id }}">{{ $user->name }}</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Maak Notitie</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-danger">
                Er zijn geen notities aan deze gebruiker gekoppeld
            </div>
        @endif
    </div>
@endsection
