@extends('layouts.master')
@section('title')
    Task
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/ckeditor.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/flatpickr.css') }}">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Task
        @endslot
        @slot('title')
            Create Task
        @endslot
    @endcomponent

    <form action="{{ route('tasks.create') }}" method="POST" id="createForm" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="project-title-input">Task Title</label>
                            <input type="text" class="form-control" id="project-title-input" name="title"
                                placeholder="Enter project title">
                        </div>

                        <div class="mb-3">
                            <label for="choices-project-input" class="form-label">Project</label>
                            <select class="form-select" data-choices id="choices-project-input" name="id_project">
                                <option value="">Project...</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id_project }}">{{ $project->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Task Description</label>
                            <textarea class="form-control" name="description" id="ckeditor-classic" rows="5"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 mb-3">
                                <div class="mb-3">
                                    <label for="choices-status-input" class="form-label">Status</label>
                                    <select class="form-select" data-choices id="choices-status-input" name="status">
                                        <option value="">Status...</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Progress">Progress</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Rejected">Rejected</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div>
                                    <label for="datepicker-deadline-input" class="form-label">Start Date</label>
                                    <input type="text" class="form-control" id="datepicker-deadline-input"
                                        name="start_date" placeholder="Enter start date" data-provider="flatpickr">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div>
                                    <label for="datepicker-deadline-input" class="form-label">Due Date</label>
                                    <input type="text" class="form-control" id="datepicker-deadline-input"
                                        name="due_date" placeholder="Enter due date" data-provider="flatpickr">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>

                <!-- Isi form input lainnya -->
                <div class="text-end mb-4" form="createForm">
                    <button type="button" class="btn btn-danger w-sm"><a href="{{ route('tasks.index') }}"
                            class="text-white">Cancel</a></button>
                    <button type="button" class="btn btn-success w-sm" id="createButton" id="sa-success">Create</button>
                </div>

            </div>
        </div>

        <!-- end row -->
    </form>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/@ckeditor/@ckeditor.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/libs/choices.js/choices.js.min.js') }}"></script>
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
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
@endsection
