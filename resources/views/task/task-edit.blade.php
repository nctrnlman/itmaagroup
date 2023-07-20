@extends('layouts.master')
@section('title')
Task
@endsection
@section('css')
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/ckeditor.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/flatpickr.css') }}">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Task @endslot
@slot('title')Edit Task @endslot
@endcomponent

@if(Session::has('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: 'Success',
                text: '{{ Session::get('success') }}',
                icon: 'success',
                showCloseButton: true
            });
        });
    </script>
@endif

@if(Session::has('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: 'Error',
                text: '{{ Session::get('error') }}',
                icon: 'error',
                showCloseButton: true
            });
        });
    </script>
@endif


<form action="{{ route('tasks.update', ['id_task' => $task->id_task]) }}" method="POST" id="createForm" enctype="multipart/form-data">
    @csrf
    {{-- @method('PUT') --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
    <div class="mb-3">
        <label class="form-label" for="project-title-input">Task Title</label>
        <input type="text" class="form-control" id="project-title-input" name="title" placeholder="Enter project title" value="{{ $task->title }}">
    </div>
    
    <div class="mb-3">
        <label for="choices-project-input" class="form-label">Project</label>
        <select class="form-select" data-choices id="choices-project-input" name="id_project">
            <option value="">Project...</option>
            @foreach($projects as $project)
                <option value="{{ $project->id_project }}" {{ $project->id_project == $task->id_project ? 'selected' : '' }}>{{ $project->title }}</option>
            @endforeach
        </select>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Task Description</label>
        <textarea class="form-control" name="description" id="ckeditor-classic" rows="5">{{ $task->description }}</textarea>
    </div>
    
    <div class="row">
        <div class="col-lg-4 mb-3">
            <div class="mb-3">
                <label for="choices-status-input" class="form-label">Status</label>
                <select class="form-select" data-choices id="choices-status-input" name="status">
                    <option value="">Status...</option>
                    <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Progress" {{ $task->status == 'Progress' ? 'selected' : '' }}>Progress</option>
                    <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="Rejected" {{ $task->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
        </div>
        <div class="col-lg-4">
            <div>
                <label for="datepicker-deadline-input" class="form-label">Deadline</label>
                <input type="text" class="form-control" id="datepicker-deadline-input" name="due_date" placeholder="Enter due date" data-provider="flatpickr" value="{{ $task->due_date }}">
            </div>
        </div>
        <div class="col-lg-4">
            <div>
                <label for="file-input" class="form-label">Upload File</label>
                <input type="file" class="form-control" id="file-input" name="file">
                @if ($task->file)
                    <p class="mt-2">File saat ini: {{ $task->file }}</p>
                @endif
            </div>
        </div>
        
    </div>
</div>
<!-- end card body -->
</div>
<!-- end card -->

<!-- end card -->
<!-- Isi form input lainnya -->
<div class="text-end mb-4" form="createForm">
<button type="button" class="btn btn-danger w-sm"><a  href="{{ route('tasks.index') }}" class="text-white">Cancel</a></button>
<button type="button" class="btn btn-success w-sm" id="createButton">Update</button>
</div>
</div>
</div>
    

    <!-- end row -->
</form>
@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/@ckeditor/@ckeditor.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/pages/sweetalerts.init.js') }}"></script>
<script src="assets/js/app.min.js"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script>
    // Initialize Flatpickr
    flatpickr('#datepicker-deadline-input', {
        // Add any Flatpickr options if needed
    });

    // Initialize CKEditor
    ClassicEditor
        .create(document.querySelector('#ckeditor-classic'))
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });

        // Handle form submission
    document.getElementById('createButton').addEventListener('click', function() {
        document.getElementById('createForm').submit();
    });
</script>
<script src="{{ asset('assets/libs/choices.js/choices.js.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var projectSelectElement = document.querySelector('#choices-project-input');
        var projectChoices = new Choices(projectSelectElement, {
            searchEnabled: true,
        });

        var statusSelectElement = document.querySelector('#choices-status-input');
        var statusChoices = new Choices(statusSelectElement, {
            searchEnabled: true,
        });
    });
</script>

@endsection
