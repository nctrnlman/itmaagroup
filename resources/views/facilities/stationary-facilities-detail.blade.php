@extends('layouts.master')

@section('title')
    Stationary Facilities
@endsection

@section('css')
    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0@/css/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="{{ asset('css/ckeditor.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
    <!-- ... -->
    @php
        use App\Helpers\Helper;
    @endphp
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Stationary Facilities
        @endslot
        @slot('title')
            Detail Ticketing
        @endslot
    @endcomponent

    <form action="{{ route('stationary-facilities.update', ['id_tiket' => $ticket->id_ga_stationary]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-12">
                <div class="card mt-n4 mx-n4 mb-n5">
                    <div class="bg-soft-warning">
                        <div class="card-body pb-4 mb-5">
                            <div class="row">
                                <div class="col-md">
                                    <div class="row align-items-center">
                                        <div class="col-md-auto">
                                            <div class="avatar-md mb-md-0 mb-4">
                                                <input type="hidden" name="_method" value="PUT">
                                                <div class="avatar-title  rounded-circle" style="background-color: #b30000">
                                                    <img src="{{ URL::asset('assets/images/logo_MAAA.png') }}"
                                                        alt="" width="65px" />
                                                </div>
                                            </div>
                                        </div>
                                        <!--end col-->

                                        <div class="col-md">
                                            <h4 class="fw-semibold pb-2">#{{ $ticket->id_ga_stationary }} - ATK / Stationary
                                            </h4>
                                            <div class="hstack gap-3 flex-wrap">
                                                <div class="text-muted"><i class="ri-building-line align-bottom me-1"></i>
                                                    MAA GROUP</div>
                                                <div class="vr"></div>
                                                @if (session('user')['access_type'] === 'Admin' || session('user')['access_type'] === 'GA Stationary')
                                                    <div class="text-muted">Status : <span class="fw-medium"></span></div>
                                                    <div>
                                                        <select class="form-select" data-choices id="choices-status-input"
                                                            name="status">
                                                            <option value="">Default</option>
                                                            @foreach (['Pending', 'Process', 'Closed', 'Rejected'] as $option)
                                                                <option value="{{ $option }}"
                                                                    {{ $ticket->status == $option ? 'selected' : '' }}>
                                                                    {{ $option }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                    <div class="vr"></div>
                                                    <div class="text-muted">Assigned To : <span class="fw-medium"> </span>
                                                    </div>
                                                    <div>
                                                        <select class="form-select" name="nik_pic" data-choices
                                                            id="choices-status-input">
                                                            <option value="">No Set</option>
                                                            @foreach ($usersGA as $userGA)
                                                                <option value="{{ $userGA->idnik }}"
                                                                    {{ $ticket->nik_pic == $userGA->idnik ? 'selected' : '' }}>
                                                                    {{ $userGA->nama }}
                                                                </option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                    <div>

                                                        <button type="submit" class="btn btn-primary">Update</button>

                                                    </div>
                                                @else
                                                    <div class="text-muted">Status : <span class="fw-medium">
                                                            {{ $ticket->status ?: '-' }}</span></div>
                                                    <div class="vr"></div>
                                                    <div class="text-muted">Request type : <span class="fw-medium">
                                                            {{ $ticket->category ?: '-' }}</span></div>
                                                    <div class="vr"></div>
                                                    <div class="text-muted">Assigned To : <span class="fw-medium">
                                                            @foreach ($usersGA as $userGA)
                                                                @if ($userGA->idnik == $ticket->nik_pic)
                                                                    {{ $userGA->nama ?: '-' }}
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    </span></div>

                                            @endif
</form>

</div>
</div>
<!--end col-->
</div>
<!--end row-->
</div>
<!--end col-->
<div class="col-md-auto mt-md-0 mt-4">
    <div class="hstack gap-1 flex-wrap">

        <button type="button" class="btn py-0 fs-16 text-body" id="settingDropdown" data-bs-toggle="dropdown">
            <i class="ri-share-line"></i>
        </button>

    </div>
</div>
<!--end col-->
</div>
<!--end row-->
</div><!-- end card body -->
</div>
</div><!-- end card -->
</div><!-- end col -->
</div><!-- end row -->

<div class="row">

    <div class="col-xxl-9">
        <div class="card">
            <div class="card-body p-4">
                <table id="exampleee" class="display table table-bordered dt-responsive" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ID Ticket</th>
                            <th>ID ATK</th>
                            <th>Desc ATK</th>
                            <th>Total Request</th>
                            <th>Total Approve</th>
                            <th>Feedback</th>
                            @if (session('user')['access_type'] === 'Admin' || session('user')['access_type'] === 'GA Stationary')
                                <th>Action</th>
                            @endif

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requestDetails as $detail)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $detail->id_ga_stationary }}</td>
                                <td>{{ $detail->id_atk }}</td>
                                <td>{{ $detail->description }}</td>
                                <td>{{ $detail->total_request }}</td>
                                <td>{{ $detail->total_approve }}</td>
                                <td>{{ $detail->feedback ?: '-' }}</td>
                                @if (session('user')['access_type'] === 'Admin' || session('user')['access_type'] === 'GA Stationary')
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#editModal{{ $detail->id_request_detail }}">
                                            Edit
                                        </button>
                                    </td>
                                @endif

                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="editModal{{ $detail->id_request_detail }}" tabindex="-1"
                                role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Total Approve and
                                                Feedback</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form
                                                action="{{ route('stationary-detail.update', ['id_tiket' => $detail->id_request_detail]) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')

                                                <input type="hidden" name="id_request_detail"
                                                    value="{{ $detail->id_request_detail }}">


                                                <div class="form-group mb-3">
                                                    <label for="id_atk">ID ATK:</label>
                                                    <input type="text" class="form-control" id="id_atk"
                                                        name="id_atk" value="{{ $detail->id_atk }}" readonly>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="description_atk">Description ATK:</label>
                                                    <input type="text" class="form-control" id="description_atk"
                                                        name="description_atk" value="{{ $detail->description }}"
                                                        readonly>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="total_request">Total Request:</label>
                                                    <input type="text" class="form-control" id="total_request"
                                                        name="total_request" value="{{ $detail->total_request }}"
                                                        readonly>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="total_approve">Total Approve:</label>
                                                    <input type="text" class="form-control" id="total_approve"
                                                        name="total_approve" value="{{ $detail->total_approve }}">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="feedback">Feedback:</label>
                                                    <textarea class="form-control" id="feedback" name="feedback"></textarea>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save
                                                        changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>


            </div>




            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>

    <!-- end col -->
    <!-- end row -->


    <div class="col-xxl-3">

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Ticket Details</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive table-card">

                    <table class="table table-borderless align-middle mb-0">
                        <tbody>
                            <tr>
                                <td class="fw-medium">Ticket</td>
                                <td>#{{ $ticket->id_ga_stationary ?: '' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-medium">Client</td>
                                <td>{{ $ticket->nama ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-medium">Email</td>
                                <td>{{ $ticket->username ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-medium">No.Hp</td>
                                <td>{{ $ticket->whatsapp ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-medium">Division</td>
                                <td>{{ $ticket->divisi ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-medium">Office Location</td>
                                <td>{{ $ticket->lokasi ?: '-' }}</td>
                            </tr>

                            <tr>
                                <td class="fw-medium">Start Date</td>
                                <td>{{ date('Y-m-d', strtotime($ticket->start_date)) }}</td>
                            </tr>
                            <tr>
                                <td class="fw-medium">End Date</td>
                                <td>{{ $ticket->end_date ? date('Y-m-d', strtotime($ticket->end_date)) : '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- </form> --}}
            <!--end card-body-->
        </div>
        <!--end card-->

        @if (session('user')['access_type'] !== 'Admin' || session('user')['access_type'] !== 'GA Stationary')
            <div class="col-lg-12">
                <div class="hstack gap-2 justify-content-end">
                    <a href="{{ route('stationary-facilities.index') }}" class="btn btn-soft-success">Cancel</a>
                </div>
            </div>
        @endif
        <!--end col-->
    </div>
</div>

<!--end row-->
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

<script src="{{ URL::asset('assets/js/pages/ticketdetail.init.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>
<script src="{{ URL::asset('assets/libs/@ckeditor/@ckeditor.min.js') }}"></script>
<script src="{{ asset('assets/libs/choices.js/choices.js.min.js') }}"></script>
<script src="assets/js/app.min.js"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<!-- Pastikan Anda memuat jQuery dan Bootstrap JavaScript -->
@if (session('user')['access_type'] === 'Admin' || session('user')['access_type'] === 'GA Stationary')
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
@endif


<script>
    ClassicEditor
        .create(document.querySelector('#ckeditor-classic-justification'))
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });

    ClassicEditor
        .create(document.querySelector('#ckeditor-classic-action-note'))
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var viewFileButtons = document.querySelectorAll(".view-file");
        var fileModal = document.getElementById("fileModal");
        var fileContent = document.getElementById("fileContent");
        var materialRequestLink = document.getElementById("materialRequestLink");

        viewFileButtons.forEach(function(button) {
            button.addEventListener("click", function(event) {
                event.preventDefault();
                var fileUrl = button.getAttribute("data-file-url");
                var extension = fileUrl.split('.').pop().toLowerCase();

                if (extension === 'pdf') {
                    // Jika berkas adalah PDF, gunakan tag iframe untuk menampilkannya
                    fileContent.innerHTML = '<iframe src="' + fileUrl +
                        '" style="width: 100%; height: 500px;"></iframe>';
                } else if (['png', 'jpg', 'jpeg'].includes(extension)) {
                    // Jika berkas adalah gambar, gunakan tag img untuk menampilkannya
                    fileContent.innerHTML = '<img src="' + fileUrl +
                        '" alt="Gambar" style="max-width: 100%; max-height: 500px;">';
                } else {
                    // Jika tipe berkas tidak dikenali, tampilkan pesan error
                    fileContent.innerHTML =
                        '<p class="text-danger">Tipe berkas tidak didukung.</p>';
                }

                // Tampilkan modal
                $(fileModal).modal("show");
            });
        });

        // Hapus event listener untuk teks "Material Request Form"
        materialRequestLink.removeEventListener("click", function(event) {
            // Tambahkan tindakan yang ingin Anda lakukan ketika teks diklik di sini
            alert("Teks 'Material Request Form' diklik.");
            event.preventDefault();
        });
    });
</script>
@endsection
