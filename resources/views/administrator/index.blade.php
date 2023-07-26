@extends('layouts.master')

@section('title')
    Administrator
@endsection

@section('css')
    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/ckeditor.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Administrator
        @endslot
        @slot('title')
            Assign PIC
        @endslot
    @endcomponent

    {{-- @if (Session::has('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: '{{ Session::get('success') }}',
                    icon: 'success',
                    showCloseButton: false
                });
            });
        </script>
    @endif

    @if (Session::has('error'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: '{{ Session::get('error') }}',
                    icon: 'error',
                    showCloseButton: false
                });
            });
        </script>
    @endif --}}

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Administrator</h5>
                        <div class="flex-shrink-0">
                            <button class="btn btn-danger add-btn" data-bs-toggle="modal" data-bs-target="#showModal">
                                <i class="ri-add-line align-bottom me-1"></i> Assign PIC
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="exampleee" class="display table table-bordered dt-responsive" style="width:100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>NIK</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Access Type</th>
                                <th>Division</th>
                                <th>Location</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $admin)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $admin->idnik }}</td>
                                    <td>
                                        <div class="avatar-group">
                                            <a href="" class="avatar-group-item" data-img="avatar-3.jpg"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="">

                                                <img src="{{ $admin->file_foto ? asset('uploads/uploads/' . $admin->file_foto) : asset('uploads/uploads/default.jpg') }}"
                                                    class="rounded-circle avatar-xs">
                                            </a>
                                        </div>
                                    </td>
                                    <td>{{ $admin->nama }}</td>
                                    <td>{{ $admin->access_type }}</td>
                                    <td>{{ $admin->divisi }}</td>
                                    <td>{{ $admin->lokasi }}</td>
                                    <td>
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill align-middle"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a href="javascript:void(0);" class="dropdown-item edit-item-btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $admin->id_access }}"
                                                        data-nama="{{ $admin->nama }}"
                                                        data-access-type="{{ $admin->access_type }}">
                                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>Edit
                                                    </a>
                                                </li>
                                                <form action="{{ route('admin.destroy', ['id' => $admin->id_access]) }}"
                                                    method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item edit-item-btn">
                                                        <i class="fa fa-trash align-bottom me-2 text-muted"></i> Delete
                                                    </button>
                                                </form>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- end col -->
    </div>


    </div>

    <!-- Modal for Adding New Administrator -->
    <div class="modal fade zoomIn" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header p-3 bg-soft-info">
                    <h5 class="modal-title" id="exampleModalLabel">Assign PIC</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>
                <form action="{{ route('admin.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <div id="modal-id">
                                    <label for="choices-status-input" class="form-label">User</label>
                                    <select class="form-select" name="idnik" data-choices id="choices-status-input">
                                        <option value="">Select User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->idnik }}">
                                                {{ $user->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="choices-status-input" class="form-label">Access Type</label>
                                <select class="form-select" data-choices id="choices-status-input" name="access_type">
                                    <option value="">Select Access Type</option>
                                    <option value="IT">IT</option>
                                    <option value="GA">GA</option>
                                    <option value="Admin">Super Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Assign</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modals for Editing Existing Administrators -->
    @foreach ($admins as $admin)
        <div class="modal fade zoomIn" id="editModal{{ $admin->id_access }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0">
                    <div class="modal-header p-3 bg-soft-info">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Admin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="close-edit-modal"></button>
                    </div>
                    <form action="{{ route('admin.update', ['id' => $admin->id_access]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <div id="modal-id">
                                        <label for="choices-status-input" class="form-label">User</label>
                                        <input type="text" class="form-control" name="id_access"
                                            value="{{ $admin->nama }}" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="choices-status-input" class="form-label">Access Type</label>
                                    <select class="form-select" data-choices id="choices-status-input"
                                        name="access_type">
                                        <option value="">Select Access Type</option>
                                        <option value="IT" {{ $admin->access_type === 'IT' ? 'selected' : '' }}>IT
                                        </option>
                                        <option value="GA" {{ $admin->access_type === 'GA' ? 'selected' : '' }}>GA
                                        </option>
                                        <option value="Admin" {{ $admin->access_type === 'Admin' ? 'selected' : '' }}>
                                            Super Admin</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger waves-effect"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
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
    <script src="{{ asset('assets/libs/choices.js/choices.js.min.js') }}"></script>
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/sweetalerts.init.js') }}"></script>
    {{-- <script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script> --}}
    <script src="assets/js/app.min.js"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#exampleee').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            // Fungsi untuk menampilkan data di dalam modal "Edit" saat modal ditampilkan
            $('.edit-item-btn').on('click', function() {
                var nama = $(this).data('nama');
                var accessType = $(this).data('access-type');

                $('#modal-id select[name="id_access"]').val(nama);
                $('#modal-id select[name="access_type"]').val(accessType);
            });
        });

        // $('.delete-form').on('submit', function(event) {
        //     event.preventDefault();
        //     const form = this;
        //     Swal.fire({
        //         title: 'Konfirmasi Hapus',
        //         text: 'Apakah Anda yakin ingin menghapus administrator ini?',
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonText: 'Ya, hapus!',
        //         cancelButtonText: 'Batal'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             // Submit formulir jika pengguna mengonfirmasi
        //             form.submit();
        //         }
        //     });
        // });
        $('.delete-form').on('submit', function(event) {
            // Hentikan proses submit form secara default
            event.preventDefault();

            // Ambil form yang sedang diklik
            const form = this;

            // Submit formulir untuk menghapus item langsung
            form.submit();
        });
    </script>
@endsection