<div class="d-flex">
    @if (!Request::is('admin/projects/*/edit'))

        <a href="{{route('admin.projects.edit',$project)}}" class="btn btn-outline-warning me-3 py-0"><i class="fa-solid fa-pencil me-2"></i>Edit</a>

    @endif

        <a href="{{route('admin.projects.index')}}" class="btn btn-outline-primary me-3 py-0"><i class="fa-solid fa-arrow-left me-2"></i>Back to list</a>
        {{-- <a href="{{route('admin.projects.edit',$project)}}" class="btn btn-outline-danger me-3 py-0">Delete</a> --}}

        <a href="#"data-bs-toggle="modal" data-bs-target="#modal-{{$project->id}}" class="btn btn-outline-danger me-3 py-0"><i class="fa-solid fa-trash me-2"></i>Delete</a>

        <a href="{{ route('admin.projects.create') }}" class="btn btn-outline-success me-3 py-0"><i class="fa-solid fa-plus me-2"></i>Add new project</a>
</div>

