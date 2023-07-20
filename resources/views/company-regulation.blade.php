@extends('layouts.master')

@section('title')
Company
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
@slot('title')Company @endslot
@endcomponent

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
                                        <div class="avatar-title bg-white rounded-circle">
                                            <img src="{{ URL::asset('assets/images/logo-refferal.jpg') }}" alt="" class="avatar-sm" />
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-md">
                                    <h4 class="fw-semibold" >Peraturan Perusahaan Periode 2021-2023 </h4>
                                    <div class="hstack gap-3 flex-wrap">
                                        
                                        
                                        <div class="text-muted">Create Date : <span class="fw-medium " id="create-date">21 Jul, 2021</span></div>
                                        <div class="vr"></div>
                                        <div class="text-muted">Due Date : <span class="fw-medium" id="due-date">29 Dec, 2023</span></div>
                                        <div class="vr"></div>
                                        <div class="badge rounded-pill bg-info fs-12" id="ticket-status">New</div>
                                        
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                        <!--end col-->
                        
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div><!-- end card body -->
            </div>
        </div><!-- end card -->
    </div><!-- end col -->
</div><!-- end row -->

<div class="d-flex justify-content-center gap-4 mx-4">
    <div class="w-100">
        <div class="card">
            
            <!--end card-body-->
            <div class="card-body p-4">
                <h5 class="card-title mb-4">Company Regulation</h5>
                <iframe src="https://drive.google.com/file/d/10sn-lOy1TNaKFIJGBp5_4Jus8sksl-QH/preview?usp=sharing" width="100%" height="800"> </iframe>
            </div>
            <!-- end card body -->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
    <div class="">
        
        <!--end card-->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title fw-semibold mb-0">Files Attachment</h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center border border-dashed p-2 rounded">
                    <div class="flex-shrink-0 avatar-sm">
                        <div class="avatar-title bg-light rounded">
                            <i class="ri-file-pdf-fill fs-20 text-danger"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1"><a href="javascript:void(0);">PP PT. MAA 2021-2023 + Daftar isi.pdf</a></h6>
                        <small class="text-muted">1 MB</small>
                    </div>
                    <div class="hstack gap-3 fs-16">
                        <a href="{{ asset('documents/PP-PT-MAA-2021-2023-Daftar-isi.pdf') }}" class="text-muted"><i class="ri-download-2-line"></i></a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->

@endsection


