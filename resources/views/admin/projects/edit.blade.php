@extends('layouts.app')

@section('content')

        <div class="container">
            <div class="row">
                <form method="POST" action="{{route('admin.projects.update',['project'=>$project->slug])}}" enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Titolo:</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{old('title', $project->title)}}">
                        
                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                       
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrizione:</label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" value="{{old('description', $project->description)}}">
                       
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                       
                    </div>
                    
                    <div class="mb-3">
                        <label for="url" class="form-label">Seleziona immagine di copertina</label>

                        @if ($project->url)
                        <div class="my-img-wrapper">
                            <img class="img-thumbnail my-img-thumb" src="{{asset('storage/' . $project->url)}}" alt="{{$project->title}}"/>
                           <a href="{{route('admin.projects.deleteImage', ['slug' => $project->slug])}}" class="my-img-delete btn btn-danger">X</a>
                        </div>
                        @endif


                        <input type="file" class="form-control @error('url') is-invalid @enderror" id="url" name="url">
                       
                            @error('url')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        
                    </div>
                    <div class="mb-3">
                        <label for="type_id" class="form-label">Seleziona tipo:</label>
                        <select class="form-select @error('type_id') is-invalid @enderror" name="type_id" id="type_id">
                            <option @selected(old('type_id', $project->type_id)=='') value="">Nessun tipo</option>
                            @foreach ($types as $type )
                                <option @selected(old('type_id', $project->type_id)==$type->id) value="{{$type->id}}">{{$type->name}}</option>   
                            @endforeach
                        </select>
                        
                       
                            @error('type_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        
                    </div>

                    <div class="mb-3">
                        @foreach($technologies as $technology)
                            @if ($errors->any())
                                <input id="tag_{{$technology->id}}" @if (in_array($technology->id , old('technologies', []))) checked @endif type="checkbox" name="technologies[]" value="{{$technology->id}}">
                            @else
                                <input id="tag_{{$technology->id}}" @if ($project->technologies->contains($technology->id)) checked @endif type="checkbox" name="technologies[]" value="{{$technology->id}}">
                            @endif
                                <label for="tag_{{$technology->id}}"  class="form-label">{{$technology->name}}</label>
                                <br>
                        @endforeach
                        @error('technologies')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
            

                    <button type="submit" class="btn btn-primary my-4">Modifica progetto</button>

            </form>

        </div>
    </div>

@endsection