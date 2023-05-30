@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row my-5">
        <div class="card bg-white" style="width: 18rem;">
            @if ($project->url)
              <img class="card-img-top" src="{{asset('storage/'. $project->url)}}" alt="{{$project->title}}">
            @endif
            
            <div class="card-body">
              <p class="card-text fw-bold"><span> Titolo:</span> <br>{{$project->title}}</p>
              <p class="card-text"><span class="fw-bold">Categoria:</span> <br>{{$project->type?$project->type->name:'Nessuna Categoria abbinata'}}</p>
              @foreach ($project->technologies as $technology)
                <span class="badge rounded-pill text-bg-primary">{{$technology->name}}</span>
              @endforeach

              <p class="card-text"><span class="fw-bold">Descrizione:</span> <br>{{$project->description}}</p>
            </div>
            <div>
              <a class="btn btn-primary my-3" href="{{route('admin.projects.index')}}">Torna alla lista progetti</a>
            </div>
          </div>


    </div>

</div>
@endsection