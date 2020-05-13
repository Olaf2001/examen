@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h2>Gebruikers</h2>
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

        <div class="table-responsive">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Naam</th>
                        <th>Email</th>
                        <th>Verwijderen en Aanpassen</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- code will be repeated for each user -->
                    @foreach($users as $user)
                        <tr style="background-color: white;">
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email}}</td>
                            <td>
                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editUser{{$user->id}}">Edit</button>
                                <button {{ Auth::user()->id == $user->id ? "disabled" : ""}} type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteUser{{$user->id}}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- the edit and delete modal will be created here, because forms in a table doesn't work -->
        @foreach($users as $user)
            <!-- Edit Modal -->
            <div class="modal fade" id="editUser{{ $user->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Gebruiker aanpassen</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <form action="{{ route('users.update', $user) }}" method="POST">
                            @csrf
                            @method('PUT')
                                                
                            <!-- Modal Body -->
                            <div class="modal-body">
                                <div class="container">
                                    <label>Naam van de gebruiker</label>
                                    <input name="name" type="text" class="form-control" placeholder="Vul hier de naam in" value="{{ $user->name }}">
                                    <label>Email van de gebruiker</label>
                                    <input name="email" type="email" class="form-control" placeholder="Vul hier de email in" value="{{ $user->email }}">
                                    <a class="btn btn-link" href="#user{{ $user->id }}change-password" data-toggle="collapse">Wachtwoord aanpassen</a>
                                    <div id="user{{ $user->id }}change-password" class="collapse">
                                        <label>Nieuw wachtwoord van gebruiker</label>
                                        <input name="password" type="password" class="form-control" placeholder="Vul het nieuwe wachtwoord in">
                                        <label>Herhaal nieuw wachtwoord van gebruiker</label>
                                        <input name="password2" type="password" class="form-control" placeholder="Vul het nieuwe wachtwoord in">
                                        <span class="text-danger">Wachtwoord aanpassen is niet verplicht, dus wil je ze niet veranderen, laat de velden leeg</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Footer -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-warning">Gebruiker Aanpassen</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Delete Modal -->
            <div class="modal fade" id="deleteUser{{$user->id}}">
                <div class="modal-dialog">
                    <div class="modal-content">
                                            
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">{{ $user->name }} Verwijderen</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <ul>
                                <li><strong>Naam:</strong> {{ $user->name }}</li>
                                <li><strong>Email:</strong> {{ $user->email }}</li>
                            </ul>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <form action="{{ route('users.destroy', $user) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger">Verwijderen</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
