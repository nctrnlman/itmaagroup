@extends('layouts.master')

@section('title')
    Stationary Facilities
@endsection

@section('css')
    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link href="{{ asset('css/ckeditor.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
    <style>
        .modal-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .note {
            font-size: 12px;
            margin-top: 20px;
            background-color: #f7f7f7;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .note-title {
            font-weight: bold;
            font-size: 15px;
            margin-bottom: 10px;
        }

        .note-item {
            margin-bottom: 5px;
            text-align: justify;
        }

        .highlight {
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            GA Facilities
        @endslot
        @slot('title')
            Stationary Facilities
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xxl-3 col-sm-6">
            <div class="card card-animate card-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="fw-medium text-muted mb-0">Total Tickets</p>
                            <h2 class="mt-4 ff-secondary fw-semibold">
                                <span class="counter-value"
                                    data-target="@if (session('user')['access_type'] === 'Admin' || session('user')['access_type'] === 'GA Stationary') {{ $totalTickets }}
                            @else
                                {{ $totalTickets }} @endif">
                                </span>
                            </h2>
                        </div>
                        <div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-info text-info rounded-circle fs-4">
                                    <i class="ri-ticket-2-line"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div> <!-- end card-->
        </div>
        <!--end col-->
        <div class="col-xxl-3 col-sm-6">
            <div class="card card-animate card-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="fw-medium text-muted mb-0">Pending Tickets</p>
                            <h2 class="mt-4 ff-secondary fw-semibold">
                                <span class="counter-value"
                                    data-target='@if (session('user')['access_type'] === 'Admin' || session('user')['access_type'] === 'GA Stationary') {{ $pendingTickets }}
                            @else
                                {{ $pendingTickets }} @endif'>

                                </span>
                            </h2>
                        </div>
                        <div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-info text-info rounded-circle fs-4">
                                    <i class="mdi mdi-timer-sand"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div>
        </div>
        <!--end col-->
        <div class="col-xxl-3 col-sm-6">
            <div class="card card-animate card-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="fw-medium text-muted mb-0">Process Tickets</p>
                            <h2 class="mt-4 ff-secondary fw-semibold">
                                <span class="counter-value"
                                    data-target='@if (session('user')['access_type'] === 'Admin' || session('user')['access_type'] === 'GA Stationary') {{ $processTickets }}
                            @else
                                {{ $processTickets }} @endif'>

                                </span>
                            </h2>
                        </div>
                        <div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-info text-info rounded-circle fs-4">
                                    <i class="ri-shopping-bag-line"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div>
        </div>
        <!--end col-->
        <div class="col-xxl-3 col-sm-6">
            <div class="card card-animate card-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="fw-medium text-muted mb-0">Closed Tickets</p>
                            <h2 class="mt-4 ff-secondary fw-semibold">
                                <span class="counter-value"
                                    data-target=' @if (session('user')['access_type'] === 'Admin' || session('user')['access_type'] === 'GA Stationary') {{ $closedTickets }}
                            @else
                                {{ $closedTickets }} @endif'>

                                </span>
                            </h2>
                        </div>
                        <div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-info text-info rounded-circle fs-4">
                                    <i class="ri-delete-bin-line"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->


    <div class="row overflow-auto ">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="card-title mb-0 flex-grow-1 flex">
                            <h5>ATK/Stationary</h5>
                            <h6>Offers support for stationary-related requests.</h6>
                        </div>

                        <div class="flex-shrink-0">
                            <button class="btn btn-danger add-btn" data-bs-toggle="modal" data-bs-target="#showModal">
                                <i class="ri-add-line align-bottom me-1"></i> Create Ticketing
                            </button>
                        </div>

                    </div>

                </div>
                <div class="card-body">
                    <table id="exampleee" class="display table table-bordered dt-responsive" style="width:100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>ID Ticket</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <?php if (session('user')['access_type'] === 'Admin' || session('user')['access_type'] === 'GA Stationary'): ?>
                                <th>Request by</th>
                                <?php endif; ?>
                                <th>Status</th>
                                <th>Type of service</th>
                                <th>PIC</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $ticket->id_ga_stationary }}</td>
                                    <td>{{ date('d F Y', strtotime($ticket->start_date)) }}</td>
                                    <td>{{ $ticket->end_date ? date('d F Y', strtotime($ticket->end_date)) : '-' }}</td>
                                    @if (session('user')['access_type'] === 'Admin' || session('user')['access_type'] === 'GA Stationary')
                                        <td>{{ $ticket->nama }}</td>
                                    @endif
                                    <td>{{ $ticket->status }}</td>
                                    <td>{{ $ticket->category }}</td>
                                    @php
                                        $userGA = $usersGA->firstWhere('idnik', $ticket->nik_pic);
                                    @endphp
                                    <td>{{ $userGA ? $userGA->nama : '-' }}</td>
                                    <td>
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill align-middle"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                @if (session('user')['access_type'] === 'Admin' ||
                                                        (session('user')['access_type'] === 'GA Stationary' && $ticket->category === 'ATK/Stationary'))
                                                    <li>
                                                        <a href="{{ route('stationary-facilities.detail', ['id_tiket' => $ticket->id_ga_stationary]) }}"
                                                            class="dropdown-item edit-item-btn">
                                                            <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="dropdown-item edit-item-btn"
                                                            onclick="event.preventDefault(); showConfirmation('{{ $ticket->id_ga_stationary }}');">
                                                            <i class="fa fa-trash align-bottom me-2 text-muted"></i> Delete
                                                        </a>
                                                        <form id="delete-form-{{ $ticket->id_ga_stationary }}"
                                                            action="{{ route('stationary-facilities.delete', ['id_tiket' => $ticket->id_ga_stationary]) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </li>
                                                @else
                                                    <li>
                                                        <a href="{{ route('stationary-facilities.detail', ['id_tiket' => $ticket->id_ga_stationary]) }}"
                                                            class="dropdown-item view-item-btn">
                                                            <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View
                                                        </a>
                                                    </li>
                                                    @if ($ticket->status == 'Pending')
                                                        <li>
                                                            <a href="#" class="dropdown-item edit-item-btn"
                                                                onclick="event.preventDefault(); showConfirmation('{{ $ticket->id_ga_stationary }}');">
                                                                <i class="fa fa-trash align-bottom me-2 text-muted"></i>
                                                                Delete
                                                            </a>
                                                            <form id="delete-form-{{ $ticket->id_ga_stationary }}"
                                                                action="{{ route('stationary-facilities.delete', ['id_tiket' => $ticket->id_ga_stationary]) }}"
                                                                method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </li>
                                                    @endif
                                                @endif
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
    </div><!-- end col -->
    </div>

    <div class="modal fade zoomIn" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 1070px;">
            <div class="modal-content border-0">
                <div class="modal-header p-3 bg-soft-info">
                    <h5 class="modal-title" id="exampleModalLabel">Create Request GA Facilities - ATK / Stationary</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>
                <form action="{{ route('stationary-facilities.insert') }}" method="POST" id="myForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-9">
                                <div class="row g-3">
                                    <div class="col-md-9">
                                        <div class="mb-3">
                                            <label for="request" class="form-label">Item 1</label>
                                            <select class="form-select" id="request" name="atk1" data-choices
                                                id="choices-status-input">
                                                <option value="">Select ATK / Stationary</option>
                                                @foreach ($atkList as $atk)
                                                    <option value="{{ $atk->id_atk }}">{{ $atk->description }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="qty1" class="form-label">Qty</label>
                                            <input type="text" id="qty1" class="form-control"
                                                placeholder="Insert Qty" name="qty1">
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-9">
                                        <div class="mb-3">

                                            <label for="request" class="form-label">Item 2</label>
                                            <select class="form-select" id="request" name="atk2" data-choices
                                                id="choices-status-input">
                                                <option value="">Select ATK / Stationary</option>
                                                @foreach ($atkList as $atk)
                                                    <option value="{{ $atk->id_atk }}">{{ $atk->description }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="qty1" class="form-label">Qty</label>
                                            <input type="text" id="qty1" class="form-control"
                                                placeholder="Insert Qty" name="qty2">
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-9">
                                        <div class="mb-3">

                                            <label for="request" class="form-label">Item 3</label>
                                            <select class="form-select" id="request" name="atk3" data-choices
                                                id="choices-status-input">
                                                <option value="">Select ATK / Stationary</option>
                                                @foreach ($atkList as $atk)
                                                    <option value="{{ $atk->id_atk }}">{{ $atk->description }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="qty1" class="form-label">Qty</label>
                                            <input type="text" id="qty1" class="form-control"
                                                placeholder="Insert Qty" name="qty3">
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-9">
                                        <div class="mb-3">

                                            <label for="request" class="form-label">Item 4</label>
                                            <select class="form-select" id="request" name="atk4" data-choices
                                                id="choices-status-input">
                                                <option value="">Select ATK / Stationary</option>
                                                @foreach ($atkList as $atk)
                                                    <option value="{{ $atk->id_atk }}">{{ $atk->description }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="qty1" class="form-label">Qty</label>
                                            <input type="text" id="qty1" class="form-control"
                                                placeholder="Insert Qty" name="qty4">
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-9">
                                        <div class="mb-3">

                                            <label for="request" class="form-label">Item 5</label>
                                            <select class="form-select" id="request" name="atk5" data-choices
                                                id="choices-status-input">
                                                <option value="">Select ATK / Stationary</option>
                                                @foreach ($atkList as $atk)
                                                    <option value="{{ $atk->id_atk }}">{{ $atk->description }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="qty1" class="form-label">Qty</label>
                                            <input type="text" id="qty1" class="form-control"
                                                placeholder="Insert Qty" name="qty5">
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-9">
                                        <div class="mb-3">
                                            <label for="request" class="form-label">If the item is not available, write
                                                it here</label>
                                            <input type="text" id="wa" class="form-control"
                                                placeholder="Write here if the item is not available" name="atk6" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="qty1" class="form-label">Qty</label>
                                            <input type="text" id="qty1" class="form-control"
                                                placeholder="Insert Qty" name="qty6">
                                        </div>
                                    </div>
                                </div>
                                <!-- Anda dapat menambahkan elemen "Barang" dan "Qty" yang lain di sini sesuai kebutuhan -->
                            </div>

                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="wa" class="form-label">No.Whatsapp</label>
                                    <input type="text" id="wa" class="form-control"
                                        placeholder="Insert your active number" name="wa" />
                                </div>
                                @if (session('user')['access_type'] === 'Admin' || session('user')['access_type'] === 'GA Building')
                                    <div class="mb-3">
                                        <label for="request" class="form-label">Request User</label>
                                        <select class="form-select" id="request" name="request" data-choices
                                            id="choices-status-input">
                                            <option value="">All Users</option>
                                            @foreach ($allUsers as $user)
                                                <option value="{{ $user->idnik }}">{{ $user->nama }} |
                                                    {{ $user->idnik }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <input type="hidden" name="request" value="{{ session('user')->idnik }}">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light"
                            onclick="submitForm(event)">Create</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    <script src="{{ URL::asset('assets/libs/@ckeditor/@ckeditor.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script>
        function showConfirmation(ticketId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to delete this item!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + ticketId).submit();
                }
            });
        }
    </script>
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
    <script>
        // Initialize Flatpickr
        flatpickr('#datepicker-deadline-input', {});

        // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#ckeditor-classic'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        function submitForm(event) {
            event.preventDefault();
            document.getElementById('myForm').submit();
        }
    </script>
@endsection
