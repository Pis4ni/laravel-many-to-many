@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

@endsection
@section('content')
<div class="container mt-5">
    <h1 class="my-5">
        Edit Project: <span class="text-primary">{{$project->id}}</span> ( EX {{$project->title}} )
    </h1>
    
    <hr>    
    @include('partials._navbtn')
    @if ($errors->any())
    <div class="alert alert-danger bg-danger-subtle bg-gradient my-5">
        <h4> <i class="fa-solid fa-triangle-exclamation fa-spin"></i> Correggi i seguenti errori per proseguire:</h4>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <hr>    
    
    <form action="{{ route('admin.projects.update', $project) }}" method="post">
        
        @csrf
        
        @method('put')

        <div class="mb-3">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{$project->title}}">
        </div>
        {{-- <div class="mb-3">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description">
        </div> --}}
        <div class="mb-3">

            <label for="type_id" class="form-label">Type:</label>
            <select name="type_id" id="type_id" class="form-select @error('type_id') is-invalid @enderror">
                <option value="">No Type</option>
                @foreach ($types as $type)
                <option value="{{ $type->id }}" @if (old('type_id') == $type->id) selected @endif>{{ $type->label }}
                </option>
                @endforeach
            </select>
                @error('type_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" value="{{$project->description}}"></textarea>
        </div>


        <button type="submit" class="btn btn-outline-warning">Edit</button>
        

        {{-- <div class="mb-3">
            <label for=""></label>
            <input type="text" class="form-control" id="" name="">
        </div> --}}

    
    </form>

    <div class="modal fade" tabindex="-1" id="modal-{{$project->id}}">
        <div class="modal-dialog ">
          <div class="modal-content">
            <div class="modal-header bg-danger">
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
</div>
@endsection
