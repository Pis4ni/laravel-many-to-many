@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
@endsection
@section('content')
    <div class="container mt-5">
        {{-- @include('partials._navbtn') --}}

        <h1 class="my-5">
            Projects List
        </h1>
        <hr>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-outline-success me-3 py-0">Add new project</a>
        <hr>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Title</th>
                  <th scope="col">Type</th>
                  <th scope="col">Technologies</th>
                  <th scope="col">Slug</th>
                  <th scope="col">Created at</th>
                  <th scope='col'>Last Update</th>
                  <th scope='col'>Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($projects as $project)
                <tr>
                    <th scope="row">{{$project->id}}</th>
                    <td>{{$project->title}}</td>
                    <td><span class="badge" style="background-color: {{$project->type?->color}} ">{{$project->type?->label}}</span></td>
                    <td>
                        @forelse($project->technologies as $technology)
                          
                          <span class="badge" style="background-color: {{$technology->color}}">{{ $technology->label }}</span>

                          @unless($loop->last) 
                          @else 
                          @endunless
                          @empty
                          
                        @endforelse
                        </td>
                    <td>{{$project->slug}}</td>
                    <td>{{$project->created_at}}</td>
                    <td>{{$project->updated_at}}</td>
                    
                    {{--* actions buttons --}}
                    
                    <td class="h-100">
                        <div class="h-100 d-flex align-items-center justify-content-between">
                            <a href="{{ route('admin.projects.show', $project)}}"><i class="fa-solid fa-eye text-"></i></a>
                            <a href="{{ route('admin.projects.edit', $project)}}"><i class="fa-solid fa-pencil text-warning"></i></a>
                            <a href="#"data-bs-toggle="modal" data-bs-target="#modal-{{$project->id}}"><i class="fa-solid fa-trash text-danger"></i></a>
                        </div>
                    </td>
                  </tr>
                @empty
                    <h1>No Record Found :(</h1>
                @endforelse
              </tbody>
        </table>

        {{$projects->links('pagination::bootstrap-5')}}

        {{-- * modals --}}

        @foreach ($projects as $project)

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
              </div>
            </div>
        </div>
    </div>

        @endforeach
@endsection