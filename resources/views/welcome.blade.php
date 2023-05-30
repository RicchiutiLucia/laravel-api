@extends('layouts.app')
@section('content')

    <h1 class="text-center py-5!!">Benvenuto in BoolProject</h1>

    <ul>
       <h2>Elenco dei Progetti:</h2> 
        @foreach ($projects as $project)
            <li>{{$project->title}}</li>
        @endforeach
    </ul>
@endsection