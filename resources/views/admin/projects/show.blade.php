@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
@endsection
@section('content')
<div class="container mt-5">
    <h1 class="my-5">
        {{$project->title}}
    </h1>
    <div class="mb-5">

        <hr>
        @include('partials._navbtn')
        <hr>
    </div>

    <div class="row">
        <div class="col-12 mb-2">
            <strong>Cover Image:</strong><br>
            <img src="{{asset('/storage/' . $project->cover_image)}}" class="img-fluid" id="cover_image_preview">
        </div>
        <div class="col-6">
            <p>
                <strong>Type:</strong>
                <br>
                {{$project->type?->label}}
            </p>
        </div>
        <div class="col-6">
            <strong>Technologies:</strong> <br>
            
            @forelse ($project->technologies as $technology)
                {{ $technology->label }} @unless($loop->last) @else  @endunless
            @empty
                Nessun technology associato
            @endforelse
        </div>
        <div class="col-100">
            <p>
                <strong>Slug:</strong>
                <br>
                {{$project->slug}}
            </p>
        </div>
        <div class="col-6">
            <p>
                <strong>Created on:</strong>
                <br>
                {{$project->created_at}}
            </p>
        </div>
        <div class="col-6">
            <p>
                <strong>Last Update:</strong>
                <br>
                {{$project->updated_at}}
            </p>
        </div>
        <div class="col-100">
            <p>
                <strong>Description:</strong>
                <br>
                {{$project->description}}
            </p>
        </div>
    </div>


</div>

<div class="modal fade" tabindex="-1" id="modal-{{$project->id}}">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header red-strip">
          <h5 class="modal-title">DELETE FROM DATABASE</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body ">
            <strong class="text-danger text-align-center">W A R N I N G</strong> <br>
            <hr>

            <p> Are you shure you want to delete permanently:
                <br>
                <strong>
                    ' {{$project->title}} ' 
                </strong>
                <br>
                <strong>
                    ID :
                </strong>
                 {{$project->id}}
                <br>
                 from the database?</p>
            <p class="text-danger">THIS ACTION IS IRREVERIBLE</p>

            <hr>
            
            <form action="{{ route('admin.projects.destroy', $project) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="send" class="btn btn-outline-danger"><strong>DELETE</strong></button>
            </form>
        </div>
        <div class="modal-footer red-strip"">
        </div>
@endsection