    
    <?php $__env->startSection('title'); ?>
        <?php echo app('translator')->get('translation.dashboards'); ?>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('css'); ?>
        <link href="assets/libs/jsvectormap/jsvectormap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/swiper/swiper.min.css" rel="stylesheet" type="text/css" />
        <style>
            .flex-grow-1 {
                /* Gaya untuk container utama */
                display: flex;
                flex-direction: column;
                flex-grow: 1;
            }

            .text-muted {
                /* Gaya untuk teks abu-abu */
                color: #af2a25;
            }

            .language-container {
                /* Gaya untuk kontainer bahasa Indonesia */
                margin-top: 2px;
            }

            .indonesian-text {
                /* Gaya untuk teks dalam bahasa Indonesia */
                display: block;
                margin-top: 1px;
                font-style: italic;
                color: #555;
            }
        </style>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <?php $__env->startComponent('components.breadcrumb'); ?>
            <?php $__env->slot('li_1'); ?>
                Dashboard
            <?php $__env->endSlot(); ?>
            <?php $__env->slot('title'); ?>
                Home
            <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
        <div class="row">
            <div class="col">

                <div class="h-100">
                    <div class="row mb-1 pb-1">
                        <div class="col-12">
                            <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                <div class="flex-grow-1">
                                    <div class="card bg-red" style="background-color: #af2a25; color: white;">
                                        <div class="card-body">
                                            <h4 class="fs-20 mb-4 " style="color:white">Hello, <?php echo session('user')->nama; ?></h4>
                                            <p class="fs-15 mb-0">
                                                This system will help you to get GA & IT request and also help us for
                                                manage, and track request from your submission.
                                            </p>
                                            <div class="language-container">
                                                <p class="indonesian-text fs-14" style="color:white">
                                                    Sistem ini akan membantu Anda dalam pengajuan permintaan GA dan IT,
                                                    serta membantu kami dalam mengelola dan melacak permintaan dari
                                                    pengajuan Anda.
                                                </p>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div><!-- end card header -->
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->


                    <h4 class="text-left mb-4">Our Features</h4>
                    <!-- Cards in a row -->
                    <div class="row mt-4">

                        <!-- IT Helpdesk Card -->
                        <div class="col-xl-4">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="text-primary mb-2">IT Support</h5>
                                            <p class="text-muted mb-0">Submit your IT-related issues here. Our IT team will
                                                assist you as soon as possible.</p>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <a href="<?php echo e(route('it-helpdesk')); ?>" class="btn btn-primary">Open IT Helpdesk</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="text-danger mb-2">Building Maintenance</h5>
                                            <p class="text-muted mb-0">Submit building and facility-related maintenance
                                                requests here. Our team
                                                will assist you with building maintenance needs.</p>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <a href="<?php echo e(route('building-facilities.index')); ?>" class="btn btn-danger">Open
                                            Building Maintenance</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Other Facilities Card -->
                        <div class="col-xl-4">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="text-secondary mb-2">Other Facilities Request</h5>
                                            <p class="text-muted mb-0">For purchasing and replacing items, please attach the
                                                approved material
                                                request form and submit your request here.</p>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <a href="<?php echo e(route('other-facilities.index')); ?>" class="btn btn-secondary">Open Other
                                            Facilities Request</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ATK/Stationary Card -->
                        <div class="col-xl-4">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class=" mb-2" style="color: #af2a25">ATK/Stationary</h5>
                                            <p class="text-muted mb-0">Submit your stationary-related requests here. Our
                                                team will assist you with ATK/Stationary needs.</p>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <a href="<?php echo e(route('stationary-facilities.index')); ?>" class="btn "
                                            style="background-color: #af2a25; color:white">Open
                                            ATK/Stationary Request</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Project Card -->
                        <?php if(session('user')->divisi === 'HRGA' || session('user')->access_type === 'Admin'): ?>
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
                                            <a href="<?php echo e(route('projects.show')); ?>" class="btn btn-success">View
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
                                            <a href="<?php echo e(route('tasks.index')); ?>" class="btn btn-warning">View Tasks</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div> <!-- end row-->



                </div> <!-- end .h-100-->

            </div> <!-- end col -->
        </div>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
        <!-- apexcharts -->
        <script src="<?php echo e(URL::asset('/assets/libs/apexcharts/apexcharts.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('/assets/libs/jsvectormap/jsvectormap.min.js')); ?>"></script>
        
        <!-- dashboard init -->
        <script src="<?php echo e(URL::asset('/assets/js/pages/dashboard-ecommerce.init.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\it\ticket\resources\views/index.blade.php ENDPATH**/ ?>