@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
@section('scripts')
<script type="text/javascript">
    const inputFileElement = document.getElementById('cover_image')
    const coverImagePreview = document.getElementById('cover_image_preview')
    if(!coverImagePreview.getAttribute('src')){
        coverImagePreview.src = "https://placehold.co/400"
    }
    
    inputFileElement.addEventListener('change', function() => {
        const [ file ] = this.files;
        coverImagePreview.src = URL.createObjectURL(file)
    })
</script>
@endsection

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
    <form action="{{ route('admin.projects.store') }}" method="post" enctype="multipart/form-data">
        
        @csrf

        <div class="row">

            {{-- * title --}}
            <div class="col-12">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>
    
            {{-- * select type --}}
            <div class="col-6">
        
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

            {{-- * technologies --}}
    
            <div class="col-6">
            
                <label class="form-label">Technologies</label>
                <div class="dropdown">
                    <a class="btn btn-outline-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                        Technologies
                    </a>
                
                    <ul class="dropdown-menu">
                        @foreach ($technologies as $technology)
                            <li class="px-2">
                                <input
                                    type="checkbox"
                                    id="technology-{{ $technology->id }}"
                                    value="{{ $technology->id }}"
                                    name="technologies[]"
                                    class="form-check-input"
                                    @if (in_array($technology->id, old('technologies', $project_technologies ?? []))) checked @endif
                                >
                                <label for="technology-{{ $technology->id }}" class="ms-3">
                                    {{ $technology->label }}
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            
               {{--  <div class="form-check @error('technologies') is-invalid @enderror p-0">
                    @foreach ($technologies as $technology)
                    <label for="technology-{{ $technology->id }}">
                    {{ $technology->label }}
                    </label>
                    <input
                    type="checkbox"
                    id="technology-{{ $technology->id }}"
                    value="{{ $technology->id }}"
                    name="technologies[]"
                    class="form-check-control"
                    @if (in_array($technology->id, old('technologies', $project_technologies ?? []))) checked @endif
                    >
                    @endforeach
                    @error('technologies')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div> --}}
            
            </div>

            {{-- * file upload --}}

            <div class="col-6">
                <label for="cover_image" class="form-label">Cover Image</label>
                <input class="form-control" type="file" id="cover_image" name="cover_image">
            </div>

            {{-- * file preview --}}

            <div class="col-6">
                <label for="cover_image_preview">Cover Preview</label>
                <img src="" alt="" id="cover_image_preview" name="cover_image_preview">
            </div>

            {{-- * description --}}
    
            <div class="col-12">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-outline-success my-4">Save</button>
        
        {{-- <div class="col-6">
            <label for=""></label>
            <input type="text" class="form-control" id="" name="">
        </div> --}}

    </form>

</div>
@endsection
