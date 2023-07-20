@extends('layouts.master')

@section('title')
Employee
@endsection

@section('css')
<link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"> --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">

@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Dashboard @endslot
@slot('title') Employee @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Employee</h5>
                    <div class="flex-shrink-0">
                        <button class="btn btn-danger add-btn" data-bs-toggle="modal" data-bs-target="#showModal">
                            <i class="ri-add-line align-bottom me-1"></i> Create Employee
                        </button>
                    </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table id="exampleee" class="display table table-bordered dt-responsive" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>NIK</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Divisi</th>
                            <th>Lokasi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee )
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $employee->idnik }}</td>
                            <td>
                                <div class="avatar-group">
                                    <a href="" class="avatar-group-item" data-img="avatar-3.jpg"
                                        data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                        title="">
                                        
                                        <img src="{{ $employee->file_foto ? asset('uploads/uploads/'.$employee->file_foto) : asset('uploads/uploads/default.jpg') }}"
                                    class="rounded-circle avatar-xs">
                                    </a>
                                </div>
                            </td>
                            <td>{{ $employee->nama }}</td>
                            <td>{{ $employee->username }}</td>
                            <td>{{ $employee->divisi }}</td>
                            <td>{{ $employee->lokasi }}</td>
                            <td>
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill align-middle"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a href="/employee/view/{{ $employee->idnik }}" class="dropdown-item"><i
                                                    class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a>
                                        </li>
                                        <li><a  href="/employee/update/{{ $employee->idnik }}" class="dropdown-item edit-item-btn"><i
                                                    class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a>
                                        </li>
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

<div class="modal fade zoomIn" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-soft-info">
                <h5 class="modal-title" id="exampleModalLabel">Create New Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>
            <form action="{{ route('employees.insert') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div id="modal-id">
                                <label for="orderId" class="form-label">ID NIK</label>
                                <input type="text" id="orderId" class="form-control" placeholder="ID-NIK"
                                    name="idnik" required />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div>
                                <label for="tasksTitle-field" class="form-label">Nama Lengkap</label>
                                <input type="text" id="tasksTitle-field" class="form-control"
                                    placeholder="Nama Lengkap" name="nama" required />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="date-field" class="form-label">Divisi</label>
                            <input type="text" id="basiInput" class="form-control" placeholder="Divisi"
                                name="divisi" required />
                        </div>
                        <div class="col-lg-6">
                            <label for="duedate-field" class="form-label">Position</label>
                            <input type="text" id="basiInput" class="form-control" placeholder="Position"
                                name="position" required />
                        </div>
                        <div class="col-lg-6">
                            <label for="ticket-status" class="form-label">Lokasi</label>
                            <select class="form-control" data-plugin="choices" name="lokasi" id="ticket-status">
                                <option value="OBI">OBI</option>
                                <option value="HO-APL">HO-APL</option>
                                <option value="HO-SCBD">HO-SCBD</option>
                                <option value="ALL SITE">ALL SITE</option>
                                <option value="MLP">MLP</option>
                                <option value="HO-Neo Soho">HO-Neo Soho</option>
                                <option value="SITE MMS">SITE MMS</option>
                                <option value="Andros">Andros</option>
                                <option value="Berly">Berly</option>
                                <option value="LAMPUNG">LAMPUNG</option>
                                <option value="HO-RUKO">HO-RUKO</option>
                                <option value="PALU">PALU</option>
                                <option value="OBI-AWS">OBI-AWS</option>
                                <option value="Xiang Shan">Xiang Shan</option>
                                <option value="Kendari">Kendari</option>
                                <option value="NLI-Kendari">NLI-Kendari</option>
                                <option value="NLI-OBI">NLI-OBI</option>
                                <option value="NLI-Morowali">NLI-Morowali</option>
                                <option value="MALUKU">MALUKU</option>
                                <option value="PARE-PARE">PARE-PARE</option>
                                <option value="MAROS">MAROS</option>
                                <option value="SUMATERA">SUMATERA</option>
                                <option value="NAGANO">NAGANO</option>
                                <option value="HO-SITE">HO-SITE</option>
                                <option value="JAMBI">JAMBI</option>
                                <option value="KENDARI-JALAN">KENDARI-JALAN</option>
                                <option value="WUHAN">WUHAN</option>
                                <option value="SIDRAP">SIDRAP</option>
                                <option value="MINAHASA">MINAHASA</option>
                                <option value="AMBON">AMBON</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
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
<script>
   $(document).ready(function() {
    $('#exampleee').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>

@endsection
