@extends('layouts.master')

@section('title')
    GA Facilities
@endsection

@section('css')
    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">
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
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            GA Facilities
        @endslot
        @slot('title')
            Detail Ticketing
        @endslot
    @endcomponent

    <form action="{{ route('ga-facilities.update', ['id_tiket' => $ticket->id_ga_facilities]) }}" method="POST">
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
                                            <h4 class="fw-semibold">#{{ $ticket->id_ga_facilities }} - Request Ticketing
                                            </h4>
                                            <div class="hstack gap-3 flex-wrap">
                                                <div class="text-muted"><i class="ri-building-line align-bottom me-1"></i>
                                                    MAA GROUP</div>
                                                <div class="vr"></div>
                                                <div class="text-muted">Create Date : <span
                                                        class="fw-medium">{{ date('Y-m-d', strtotime($ticket->start_date)) }}</span>
                                                </div>
                                                <div class="vr"></div>
                                                @if (session('user')['access_type'] === 'Admin' ||
                                                        (session('user')['access_type'] === 'GA Building' && $ticket->kategori_tiket === 'Building Maintenance support') ||
                                                        (session('user')['access_type'] === 'GA RP' && $ticket->kategori_tiket === 'Other facilities Request (Purchase Request)') ||
                                                        (session('user')['access_type'] === 'GA ATK' && $ticket->kategori_tiket === 'ATK/Stationary'))
                                                    <div class="text-muted">Status : <span class="fw-medium"></span></div>
                                                    <div>
                                                        <select class="form-select" data-choices id="choices-status-input"
                                                            name="status_tiket">
                                                            <option value="">Default..</option>
                                                            @foreach (['Pending', 'Process', 'Closed', 'Rejected'] as $option)
                                                                <option value="{{ $option }}"
                                                                    {{ $ticket->status_tiket == $option ? 'selected' : '' }}>
                                                                    {{ $option }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                    <div class="vr"></div>
                                                    <div class="text-muted">Request type : <span class="fw-medium"> </span>
                                                    </div>
                                                    <div>
                                                        <select class="form-select" name="kategori_tiket"
                                                            id="choices-status-input" disabled>
                                                            <option value="" disabled selected>Service..</option>
                                                            <option value="Building Management"
                                                                {{ $ticket->kategori_tiket == 'Building Maintenance support' ? 'selected' : '' }}>
                                                                Building Maintenance support</option>
                                                            <option value="Repair & Purchase"
                                                                {{ $ticket->kategori_tiket == 'Other facilities Request (Purchase Request)' ? 'selected' : '' }}>
                                                                Repair & Purchase</option>
                                                            <option value="ATK/Stationary"
                                                                {{ $ticket->kategori_tiket == 'ATK/Stationary' ? 'selected' : '' }}>
                                                                ATK/Stationary</option>
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
                                                @else
                                                    <div class="text-muted">Status : <span class="fw-medium">
                                                            {{ $ticket->status_tiket ?: '-' }}</span></div>
                                                    <div class="vr"></div>
                                                    <div class="text-muted">Request type : <span class="fw-medium">
                                                            {{ $ticket->kategori_tiket ?: '-' }}</span></div>
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

                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                            <!--end col-->
                            <div class="col-md-auto mt-md-0 mt-4">
                                <div class="hstack gap-1 flex-wrap">
                                    <button type="button" class="btn avatar-xs mt-n1 p-0 favourite-btn active">
                                        <span class="avatar-title bg-transparent fs-15">
                                            <i class="ri-star-fill"></i>
                                        </span>
                                    </button>
                                    <button type="button" class="btn py-0 fs-16 text-body" id="settingDropdown"
                                        data-bs-toggle="dropdown">
                                        <i class="ri-share-line"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="settingDropdown">
                                        <li><a class="dropdown-item" href="#" onclick="copyLink()"><i
                                                    class="ri-share-forward-fill align-bottom me-2 text-muted"></i>
                                                Share with</a></li>
                                    </ul>
                                    <button type="button" class="btn py-0 fs-16 text-body">
                                        <i class="ri-flag-line"></i>
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
                    <h6 class="fw-semibold text-uppercase mb-3 fs-5">Ticket Description</h6>
                    <p class="text-muted">{!! $ticket->disc_keluhan !!}</p>

                    <h6 class="fw-semibold text-uppercase mb-3 fs-5">Justification</h6>
                    @if (session('user')['access_type'] === 'Admin' ||
                            (session('user')['access_type'] === 'GA Building' && $ticket->kategori_tiket === 'Building Maintenance support') ||
                            (session('user')['access_type'] === 'GA RP' && $ticket->kategori_tiket === 'Other facilities Request (Purchase Request)') ||
                            (session('user')['access_type'] === 'GA ATK' && $ticket->kategori_tiket === 'ATK/Stationary'))
                        <textarea class="form-control" id="ckeditor-classic-justification"
                            placeholder="Write Justrification in this field..." rows="5" name="justification">{{ $ticket->justification }}</textarea>
                    @else
                        <p class="text-muted">{!! $ticket->justification !!}</p>
                    @endif

                    <div class="mt-4">
                        <h6 class="fw-semibold text-uppercase mb-3 fs-5">Progress / Action Note</h6>
                        @if (session('user')['access_type'] === 'Admin' ||
                                (session('user')['access_type'] === 'GA Building' && $ticket->kategori_tiket === 'Building Maintenance support') ||
                                (session('user')['access_type'] === 'GA RP' && $ticket->kategori_tiket === 'Other facilities Request (Purchase Request)') ||
                                (session('user')['access_type'] === 'GA ATK' && $ticket->kategori_tiket === 'ATK/Stationary'))
                            <textarea class="form-control" id="ckeditor-classic-action-note"
                                placeholder="Write Progress/Action Note in this field..." rows="5" name="actionNote">{{ $ticket->action_note }}</textarea>
                        @else
                            <p class="text-muted">{!! $ticket->action_note !!}</p>
                        @endif
                    </div>

                    @if (session('user')['access_type'] === 'Admin' ||
                            (session('user')['access_type'] === 'GA Building' && $ticket->kategori_tiket === 'Building Maintenance support') ||
                            (session('user')['access_type'] === 'GA RP' && $ticket->kategori_tiket === 'Other facilities Request (Purchase Request)') ||
                            (session('user')['access_type'] === 'GA ATK' && $ticket->kategori_tiket === 'ATK/Stationary'))
                        <div class="flex pt-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    @endif

                </div>
</form>

<div class="card-body p-4">
    <h5 class="card-title mb-4">Comments</h5>

    @if ($comments->isEmpty())
        <div data-simplebar style="height: 300px;" class="px-3 mx-n3">
            <div class="d-flex mb-4">
                <div class="flex-shrink-0">
                    <img src="{{ URL::asset('assets/images/users/avatar-9.jpg') }}" alt=""
                        class="avatar-xs rounded-circle" />
                </div>
                <div class="flex-grow-1 ms-3">
                    <h5 class="fs-13">General Affair PIC <small
                            class="text-muted">{{ date('d M Y - h:iA', strtotime('2023-12-27 05:47AM')) }}</small>
                    </h5>
                    <p class="text-muted">I got a message from you guys that they have a problem. Can you state their
                        problems?</p>
                </div>
            </div>
        </div>
    @else
        <div data-simplebar style="max-height: 300px; overflow-y: auto;" class="px-3 mx-n3">
            @foreach ($comments as $comment)
                <div class="d-flex mb-4">
                    <div class="flex-shrink-0">
                        <img src="{{ $comment->file_foto == null || '' ? asset('uploads/uploads/default.jpg') : asset('uploads/uploads/' . $comment->file_foto) }}"
                            alt="" class="avatar-xs rounded-circle" />
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="fs-13">{{ $comment['nama'] }} <small
                                class="text-muted">{{ date('d M Y - h:iA', strtotime($comment['datetime'])) }}</small>
                        </h5>
                        <p class="text-muted">{{ $comment['keterangan_komen'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    @if ($ticket->status_tiket == 'Closed')
        <div class="alert alert-warning" role="alert">
            Comment cannot be added as the ticket is already closed.
        </div>
    @else
        <form action="{{ route('ga-facilities.komentar') }}" method="POST" class="mt-3">
    @csrf
    <input type="hidden" name="id_tiket" value="{{ $ticket->id_ga_facilities }}">
    <div class="row g-3">
        <div class="col-lg-12">
            <label for="keterangan_komen" class="form-label">Leave a Comment</label>
            <textarea class="form-control bg-light border-light" name="keterangan_komen" rows="3"
                placeholder="Enter comments"></textarea>
        </div>
        <div class="col-lg-12">
            <button type="submit" class="btn btn-success">Post Comment</button>
        </div>
    </div>
</form>

    @endif

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
                            <td>#{{ $ticket->id_ga_facilities ?: '' }}</td>
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
        </form>
        <!--end card-body-->
    </div>
    <!--end card-->
    <div class="card">
        <div class="card-header">
            <h6 class="card-title fw-semibold mb-0">Files Attachment</h6>
        </div>
        <div class="card-body">
            @if ($ticket->lampiran1 || $ticket->lampiran2)
                @foreach ([$ticket->lampiran1, $ticket->lampiran2] as $lampiran)
                    @if ($lampiran)
                        <div class="d-flex align-items-center border border-dashed p-2 rounded mt-2">
                            <div class="flex-shrink-0 avatar-sm">
                                @php
                                    $extension = pathinfo($lampiran, PATHINFO_EXTENSION);
                                    $iconClass = '';
                                    
                                    switch ($extension) {
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
                                            $iconClass = 'fa fa-file text-secondary';
                                            break;
                                    }
                                @endphp

                                <div class="avatar-title bg-light rounded">
                                    <i class="{{ $iconClass }} fs-20"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">
                                    <a href="{{ asset('storage/gafacilities/' . $lampiran) }}">Material Request Form
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    {{ Helper::formatSizeUnits(filesize(storage_path('app/public/gafacilities/' . $lampiran))) }}
                                </small>
                            </div>
                            <div class="hstack gap-3 fs-16">
                                <a href="{{ route('download', ['folder' => 'gafacilities', 'filename' => $lampiran]) }}"
                                    class="text-muted">
                                    <i class="fa fa-download"></i>
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="alert alert-info mt-3" role="alert">
                    <i class="fa fa-info-circle me-2"></i>
                    No files uploaded.
                </div>
            @endif
        </div>
    </div>
    @if (session('user')['access_type'] !== 'Admin' || session('user')['access_type'] !== 'IT')
        <div class="col-lg-12">
            <div class="hstack gap-2 justify-content-end">
                <a href="{{ route('ga-facilities.index') }}" class="btn btn-soft-success">Cancel</a>
            </div>
        </div>
    @endif
    <!--end col-->
</div>
</div>






<!--end row-->
@endsection
@section('script')
<script src="{{ URL::asset('assets/js/pages/ticketdetail.init.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>
<script src="{{ URL::asset('assets/libs/@ckeditor/@ckeditor.min.js') }}"></script>
<script src="{{ asset('assets/libs/choices.js/choices.js.min.js') }}"></script>
<script src="assets/js/app.min.js"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
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
@endsection
