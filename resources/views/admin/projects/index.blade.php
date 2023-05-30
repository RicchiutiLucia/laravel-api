@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row my-5">
        <table class="table table-hover table-striped table-bordered ">
            <thead>
            <tr>
                <th scope="col">Progetto</th>
                <th scope="col">Titolo</th>
                <th scope="col">Url</th>
                <th scope="col">Categoria</th>
                <th scope="col">Tecnologie</th>
                <th scope="col">Azioni</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <th>{{$project->id}}</th>
                        <td>{{$project->title}}</td>
                        <td> @if ($project->url)
                            <img class="img-thumbnail my-img-index" src="{{asset('storage/' . $project->url)}}" alt="{{$project->title}}"/>
                        @endif</td>
                        <td>{{$project->type?->name}}</td>
                        <td>
                            @foreach ($project->technologies as $technology)
                                <span class="badge rounded-pill text-bg-primary">{{$technology->name}}</span>
                                
                            @endforeach
                        </td>
                        <td class="d-flex">
                            <div class="my-2">
                                <a href="{{route('admin.projects.show',$project->slug)}}" class="btn btn-primary ">Info</a>
                            </div>
                            <div class="mx-2 my-2">
                                <a href="{{route('admin.projects.edit',$project->slug)}}" class="btn btn-warning ">Modifica</a>
                            </div>
                            <form    class="form_delete_post my-2"  action="{{route('admin.projects.destroy',$project->slug)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Elimina</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Conferma eliminazione</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Confermi di voler eliminare l'elemento selezionato?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger">Conferma eliminazione</button>
            </div>
            </div>
        </div>
    </div>

</div>
@endsection