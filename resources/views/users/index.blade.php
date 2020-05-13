@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h2>Gebruikers</h2>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Naam</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr style="background-color: white;">
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
