@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-between">
            <h2>Notes</h2>
        </div>
        <div class="row justify-content-between">
            @foreach($notes as $note)
            <div class="col-md-3" style="padding:30px; margin:20px; background-color:white;">
                <h3>{{ $note->title }}</h3>
                <p>{{ Str::limit($note->note, 150, '...') }}</p>
                <div class="button-section">
                    <button type="button" class="btn btn-primary"data-toggle="modal" data-target="#showNote{{$note->id}}">Show</button>
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
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Sluiten</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection