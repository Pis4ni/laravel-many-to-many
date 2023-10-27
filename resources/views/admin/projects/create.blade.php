@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

@endsection
@section('content')
<div class="container mt-5">

    <h1 class="my-5">
        Create New Project
    </h1>

    <hr>
    <a href="{{route('admin.projects.index')}}" class="btn btn-outline-primary me-3 py-0">Back to list</a>
    @if ($errors->any())
    <div class="alert alert-danger bg-danger-subtle bg-gradient my-5">

        <h4> <i class="fa-solid fa-triangle-exclamation fa-beat"></i> Correggi i seguenti errori per proseguire:</h4>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <hr>
    <form action="{{ route('admin.projects.store') }}" method="post">
        
        @csrf
        {{-- * title --}}
        <div class="mb-3">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>


        {{-- * select type --}}
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

        {{-- * description --}}
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
        </div>


                <button type="submit" class="btn btn-outline-success">Save</button>
        

        {{-- <div class="mb-3">
            <label for=""></label>
            <input type="text" class="form-control" id="" name="">
        </div> --}}

    
    </form>

</div>
@endsection
