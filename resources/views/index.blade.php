    @extends('layouts.master')
    @section('title')
        @lang('translation.dashboards')
    @endsection
    @section('css')
        <link href="assets/libs/jsvectormap/jsvectormap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/swiper/swiper.min.css" rel="stylesheet" type="text/css" />
    @endsection
    @section('content')
        @component('components.breadcrumb')
            @slot('li_1')
                Dashboard
            @endslot
            @slot('title')
                Home
            @endslot
        @endcomponent
        <div class="row">
            <div class="col">

                <div class="h-100">
                    <div class="row mb-3 pb-1">
                        <div class="col-12">
                            <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                <div class="flex-grow-1">
                                    <h4 class="fs-20 mb-2">Hello!, {{ session('user')->nama }}</h4>
                                    <p class="text-muted mb-0"> Welcome to EIP (Enterprise Information Portal). We are
                                        delighted to have you onboard and contribute to managing company information more
                                        efficiently. Wishing you a day filled with energy and success!</p>
                                </div>
                            </div><!-- end card header -->
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->

                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                Total Employee</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <h5 class="text-success fs-14 mb-0">
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                                    data-target="{{ $totalEmployee }}">0</span> </h4>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-soft-success rounded fs-3">
                                                <i class="bx bx-user-circle text-warning"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                EMPLOYEE HO</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <h5 class="text-danger fs-14 mb-0">
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                                    data-target=" {{ $employeeHO }}">0</span></h4>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-soft-info rounded fs-3">
                                                <i class="bx bx-user-circle text-warning"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                EMPLOYEE OBI</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <h5 class="text-success fs-14 mb-0">
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                                    data-target=" {{ $employeeOBI }}">0</span>
                                            </h4>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title  bg-soft-info rounded fs-3">
                                                <i class="bx bx-user-circle text-warning"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                EMPLOYEE BCPM</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                                    data-target="{{ $employeeBCPM }}">0</span>
                                            </h4>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title  bg-soft-info rounded fs-3">
                                                <i class="bx bx-user-circle text-warning"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div> <!-- end row-->


                    <h4 class="text-left mb-4">Our Features</h4>
                    <!-- Cards in a row -->
                    <div class="row mt-4">

                        <!-- IT Helpdesk Card -->
                        <div class="col-xl-4">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="text-primary mb-2">IT Helpdesk</h5>
                                            <p class="text-muted mb-0">Submit your IT-related issues here. Our IT team will
                                                assist you as soon as possible.</p>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <a href="{{ route('it-helpdesk') }}" class="btn btn-primary">Open IT Helpdesk</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- GA Facilities Card -->
                        <div class="col-xl-4">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="text-info mb-2">GA Facilities</h5>
                                            <p class="text-muted mb-0">Manage and handle General Affairs (GA) Facilities
                                                requests and track requests.</p>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <a href="{{ route('ga-facilities.index') }}" class="btn btn-info">View GA
                                            Facilities</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Project Card -->
                        @if (session('user')->divisi === 'HRGA')
                            <div class="col-xl-4">
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="text-success mb-2">Project Management</h5>
                                                <p class="text-muted mb-0">View and manage ongoing projects, track
                                                    progress,
                                                    and
                                                    collaborate with team members.</p>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <a href="{{ route('projects.show') }}" class="btn btn-success">View
                                                Projects</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Task Card -->
                            <div class="col-xl-4">
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="text-warning mb-2">Task Management</h5>
                                                <p class="text-muted mb-0">Track and manage individual tasks within
                                                    projects.
                                                    Stay
                                                    organized and meet deadlines efficiently.</p>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <a href="{{ route('tasks.index') }}" class="btn btn-warning">View Tasks</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div> <!-- end row-->



                </div> <!-- end .h-100-->

            </div> <!-- end col -->
        </div>
    @endsection
    @section('script')
        <!-- apexcharts -->
        <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ URL::asset('/assets/libs/jsvectormap/jsvectormap.min.js') }}"></script>
        {{-- <script src="{{ URL::asset('assets/libs/swiper/swiper.min.js') }}"></script> --}}
        <!-- dashboard init -->
        <script src="{{ URL::asset('/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>
        <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    @endsection
