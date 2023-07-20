@extends('layouts.master')
@section('title')
    @lang('translation.overview')
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0@/css/remixicon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0@/css/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />



    @php
        use App\Helpers\Helper;
    @endphp
@endsection


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mt-n4 mx-n4">
                <div class="bg-soft-warning">
                    <div class="card-body pb-0 px-4">
                        <div class="row mb-3">
                            <div class="col-md">
                                <div class="row align-items-center g-3">
                                    <div class="col-md-auto">
                                        <div class="avatar-md">
                                            <div class="avatar-title  rounded-circle" style="background-color: #b30000">
                                                <img src="{{ URL::asset('assets/images/logo_MAAA.png') }}" alt="logo"
                                                    width="65px">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div>
                                            <h4 class="fw-bold">{{ $project->title }}</h4>
                                            <div class="hstack gap-3 flex-wrap">
                                                <div><i class="ri-building-line align-bottom me-1"></i>MAA GROUP</div>
                                                <div class="vr"></div>
                                                <div>Create Date : <span
                                                        class="fw-medium">{{ date('d F Y', strtotime($project->create_date)) }}</span>
                                                </div>
                                                <div class="vr"></div>
                                                <div>Due Date : <span
                                                        class="fw-medium">{{ date('d F Y', strtotime($project->due_date)) }}</span>
                                                </div>
                                                <div class="vr"></div>
                                                <div>Status : <span class="fw-medium">{{ $project->status }}</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active fw-semibold" data-bs-toggle="tab" href="#project-overview"
                                    role="tab">
                                    Overview
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#project-documents"
                                    role="tab">
                                    Documents
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#project-activities"
                                    role="tab">
                                    Tasks
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- end card body -->
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="tab-content text-muted">
                <div class="tab-pane fade show active" id="project-overview" role="tabpanel">
                    <div class="row">
                        <div class="col-xl-9 col-lg-8">
                            <div class="card" style="height: 580px;">
                                <div class="card-body">
                                    <div class="text-muted">
                                        <h4 class="mb-3 fw-semibold text-uppercase ">Summary</h4>
                                        <p style=" overflow-y: auto;">{!! $project->description !!}</p>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                            <!-- end card -->
                        </div>
                        <!-- ene col -->
                        <div class="col-xl-3 col-lg-4">
                            <div class="card">
                                <div class="card-header align-items-center d-flex border-bottom-dashed">
                                    <h4 class="card-title mb-0 flex-grow-1">Members</h4>

                                </div>

                                <div class="card-body">
                                    <div data-simplebar style="height: 235px;" class="mx-n3 px-3">
                                        <div class="vstack gap-3">
                                            <?php foreach ($members as $member): ?>
                                            <?php if ($member->id_project == $project->id_project): ?>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-xs flex-shrink-0 me-3">

                                                    <img src="@if ($member->file_foto) {{ asset('uploads/uploads/' . $member->file_foto) }}@else{{ asset('uploads/uploads/default.jpg') }} @endif"
                                                        alt="" class="img-fluid rounded-circle">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h5 class="fs-13 mb-0">
                                                        <a href="/employee/view/{{ $member->idnik }}"
                                                            class="text-body d-block"><?= $member->nama ?></a>
                                                    </h5>
                                                </div>

                                            </div>
                                            <!-- end member item -->
                                            <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                        <!-- end list -->
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>

                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end tab pane -->
                <div class="tab-pane fade" id="project-documents" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4">
                                <h5 class="card-title flex-grow-1">Documents</h5>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive table-card" style="max-height: 580px; overflow-y: auto;">
                                        <table class="table table-borderless align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th scope="col">File Name</th>
                                                    <th scope="col">Type</th>
                                                    <th scope="col">Size</th>
                                                    <th scope="col">Upload Date</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($project->file !== null)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-sm">
                                                                    <div
                                                                        class="avatar-title bg-light text-secondary rounded fs-24">
                                                                        <?php
                                                                        $fileExtension = pathinfo($project->file, PATHINFO_EXTENSION);
                                                                        switch ($fileExtension) {
                                                                            case 'png':
                                                                            case 'jpg':
                                                                            case 'jpeg':
                                                                                $iconClass = 'fa fa-file-image text-primary';
                                                                                break;
                                                                            case 'pdf':
                                                                                $iconClass = 'fa fa-file-pdf text-danger';
                                                                                break;
                                                                            case 'xls':
                                                                            case 'xlsx':
                                                                                $iconClass = 'fa fa-file-excel text-success';
                                                                                break;
                                                                            case 'mp4':
                                                                            case 'mkv':
                                                                            case 'avi':
                                                                                $iconClass = 'fa fa-file-video text-warning';
                                                                                break;
                                                                            default:
                                                                                $iconClass = 'fa fa-file text-secondary'; // default icon if no matching icon found
                                                                                break;
                                                                        }
                                                                        ?>
                                                                        <i class="{{ $iconClass }}"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="ms-3 flex-grow-1">
                                                                    <h5 class="fs-14 mb-0">
                                                                        <a href="javascript:void(0)"
                                                                            class="text-dark">Resource
                                                                            {{ $project->title }}</a>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td><?php
                                                        $fileExtension = pathinfo($project->file, PATHINFO_EXTENSION);
                                                        echo strtoupper($fileExtension);
                                                        ?></td>
                                                        <td>{{ Helper::formatSizeUnits(filesize(storage_path('app/public/uploads/projects/' . $project->file))) }}
                                                        </td>
                                                        <td>{{ date('d F Y', strtotime($project->create_date)) }}</td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <a href="javascript:void(0);"
                                                                    class="btn btn-soft-secondary btn-sm btn-icon"
                                                                    data-bs-toggle="dropdown" aria-expanded="true">
                                                                    <i class="ri-more-fill"></i>
                                                                </a>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li>
                                                                        <a class="dropdown-item"
                                                                            href="{{ asset('storage/uploads/projects/' . $project->file) }}">
                                                                            <i
                                                                                class="ri-download-2-fill me-2 align-bottom text-muted"></i>
                                                                            Download
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif

                                                @foreach ($taskFiles as $file)
                                                    @if ($file->file !== null)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar-sm">
                                                                        <div
                                                                            class="avatar-title bg-light text-secondary rounded fs-24">
                                                                            <?php
                                                                            $fileExtension = pathinfo($file->file, PATHINFO_EXTENSION);
                                                                            switch ($fileExtension) {
                                                                                case 'png':
                                                                                case 'jpg':
                                                                                case 'jpeg':
                                                                                    $iconClass = 'fa fa-file-image text-primary';
                                                                                    break;
                                                                                case 'pdf':
                                                                                    $iconClass = 'fa fa-file-pdf text-danger';
                                                                                    break;
                                                                                case 'xls':
                                                                                case 'xlsx':
                                                                                    $iconClass = 'fa fa-file-excel text-success';
                                                                                    break;
                                                                                case 'mp4':
                                                                                case 'mkv':
                                                                                case 'avi':
                                                                                    $iconClass = 'fa fa-file-video text-warning';
                                                                                    break;
                                                                                default:
                                                                                    $iconClass = 'fa fa-file text-secondary'; // default icon if no matching icon found
                                                                                    break;
                                                                            }
                                                                            ?>
                                                                            <i class="{{ $iconClass }}"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="ms-3 flex-grow-1">
                                                                        <h5 class="fs-14 mb-0">
                                                                            <a href="javascript:void(0)"
                                                                                class="text-dark">{{ $file->title }}</a>
                                                                        </h5>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td><?php
                                                            $fileExtension = pathinfo($file->file, PATHINFO_EXTENSION);
                                                            echo strtoupper($fileExtension);
                                                            ?></td>
                                                            <td>{{ Helper::formatSizeUnits(filesize(storage_path('app/public/uploads/tasks/' . $file->file))) }}
                                                            </td>
                                                            <td>{{ date('d F Y', strtotime($file->create_date)) }}</td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-soft-secondary btn-sm btn-icon"
                                                                        data-bs-toggle="dropdown" aria-expanded="true">
                                                                        <i class="ri-more-fill"></i>
                                                                    </a>
                                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                                        <li>
                                                                            <a class="dropdown-item"
                                                                                href="{{ asset('storage/uploads/tasks/' . $file->file) }}">
                                                                                <i
                                                                                    class="ri-download-2-fill me-2 align-bottom text-muted"></i>
                                                                                Download
                                                                            </a>
                                                                        </li>
                                                                        <li class="dropdown-divider"></li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach

                                                @if ($project->file === null && $taskFiles->where('file', '!=', null)->isEmpty())
                                                    <tr>
                                                        <td colspan="5" class="text-center">No files available yet</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end tab pane -->
                <div class="tab-pane fade" id="project-activities" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Tasks</h5>
                            <div class="acitivity-timeline py-3">
                                <div class="card-body">
                                    <table id="exampleee" class="display table table-bordered dt-responsive"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Task</th>
                                                <th>Assign To</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($taskList as $task)
                                                <tr>
                                                    <td>{{ $task->title }}</td>
                                                    <td>{{ $task->nama }}</td>
                                                    <td>{{ date('d F Y', strtotime($task->due_date)) }}</td>
                                                    <td>{{ $task->status }}</td>
                                                    <td>
                                                        <div class="dropdown d-inline-block">
                                                            <button class="btn btn-soft-secondary btn-sm dropdown"
                                                                type="button" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                <i class="ri-more-fill align-middle"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <a href="{{ route('tasks.view', ['id_task' => $task->id_task]) }}"
                                                                    class="dropdown-item view-item-btn">
                                                                    <i
                                                                        class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                                    View
                                                                </a>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>




                            </div>
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>

            </div>
        </div>
        <!-- end col -->
    </div>
@endsection
@section('script')
    <script src="https://kit.fontawesome.com/{YOUR_FONTAWESOME_KIT_ID}.js" crossorigin="anonymous"></script>
    <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/tasks-list.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    <script src="assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>
    <script src="{{ URL::asset('assets/js/pages/project-overview.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#exampleee').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
@endsection
