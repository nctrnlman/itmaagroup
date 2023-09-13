    
    <?php $__env->startSection('title'); ?>
        <?php echo app('translator')->get('translation.project-list'); ?>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('css'); ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <?php $__env->startComponent('components.breadcrumb'); ?>
            <?php $__env->slot('li_1'); ?>
                Project
            <?php $__env->endSlot(); ?>
            <?php $__env->slot('title'); ?>
                Project List
            <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>

        <div class="row g-4 mb-3">
            <div class="col-sm-auto">
                <div>
                    <a href="<?php echo e(route('projects.index')); ?>" class="btn btn-success"><i
                            class="ri-add-line align-bottom me-1"></i> Add New</a>
                </div>
            </div>
            <div class="col-sm">
                <form action="<?php echo e(route('projects.show')); ?>" method="GET">
                    <div class="d-flex justify-content-sm-end gap-2">
                        <div class="search-box ms-2">
                            <input type="text" class="form-control" placeholder="Search..." name="search"
                                value="<?php echo e(request('search')); ?>">
                            <i class="ri-search-line search-icon"></i>
                        </div>
                        <button type="submit" class="btn btn-primary mr-4">Search</button>
                        <select class="form-control w-md" data-choices data-choices-search-false name="status_filter">
                            <option value="All">All</option>
                            <option value="Open">Open</option>
                            <option value="On Progress">On Progress</option>
                            <option value="Closed">Closed</option>
                            <option value="Canceled">Canceled</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <div class="row w-1000px">
            <?php
                $projectExists = false;
                $isAdmin = session('user')->access_type === 'Admin';
            ?>

            <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $projectMembers = $members->where('id_project', $project->id_project)->where('idnik', session('user')->idnik);
                    $count = $projectMembers->count();
                    $isClosedOrCanceled = $project->status === 'Closed' || $project->status === 'Canceled';
                ?>

                <?php if($isAdmin || $count > 0): ?>
                    <?php
                        $projectExists = true;
                    ?>
                    <div class="col-xxl-3 col-sm-6 project-card"
                        style="opacity: <?php echo e($isClosedOrCanceled ? '0.7' : '1'); ?>;
                        filter: <?php echo e($isClosedOrCanceled ? 'grayscale(100%)' : 'none'); ?>;">
                        <div class="card card-height-100">
                            <div class="card-body">
                                <div class="d-flex flex-column h-100">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">

                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="d-flex gap-1 align-items-center">
                                                <button type="button" class="btn avatar-xs mt-n1 p-0 favourite-btn">
                                                    <span class="avatar-title bg-transparent fs-15">
                                                        <i class="ri-star-fill"></i>
                                                    </span>
                                                </button>
                                                <div class="dropdown">
                                                    <button
                                                        class="btn btn-link text-muted p-1 mt-n2 py-0 text-decoration-none fs-15"
                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        <i data-feather="more-horizontal" class="icon-sm"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <?php if($project->status === 'Closed'): ?>
                                                            <a class="dropdown-item"
                                                                href="<?php echo e(route('projects.view', ['id' => $project->id_project])); ?>">
                                                                <i class="ri-eye-fill align-bottom me-2 text-muted"></i>View
                                                            </a>
                                                        <?php else: ?>
                                                            <?php if($project->idnik == session('user')->idnik || $isAdmin): ?>
                                                                <a class="dropdown-item"
                                                                    href="<?php echo e(route('projects.edit', ['id' => $project->id_project])); ?>">
                                                                    <i
                                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i>Edit
                                                                </a>
                                                            <?php endif; ?>
                                                            <a class="dropdown-item"
                                                                href="<?php echo e(route('projects.view', ['id' => $project->id_project])); ?>">
                                                                <i class="ri-eye-fill align-bottom me-2 text-muted"></i>View
                                                            </a>
                                                            <a class="dropdown-item"
                                                                onclick="event.preventDefault(); showConfirmation('<?php echo e($project->id_project); ?>');">
                                                                <i
                                                                    class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>Delete
                                                            </a>
                                                            <form id="delete-form-<?php echo e($project->id_project); ?>"
                                                                action="<?php echo e(route('projects.delete', ['id' => $project->id_project])); ?>"
                                                                method="POST" style="display: none;">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('DELETE'); ?>
                                                            </form>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar-md">
                                                <span class="avatar-title rounded p-2" style="background-color: #b30000">
                                                    <img src="<?php echo e(URL::asset('assets/images/logo_MAAA.png')); ?>"
                                                        alt="Thumbnail" class="img-fluid p-1">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="mb-1 fs-15"><a
                                                    href="<?php echo e(route('projects.view', ['id' => $project->id_project])); ?>"
                                                    class="text-dark"><?php echo e($project->title); ?></a></h5>
                                            <div class="text-muted text-truncate-two-lines mb-3"><?php echo e($project->status); ?>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-auto">
                                        <div class="d-flex mb-2">
                                            <div class="flex-grow-1">
                                                <div>Tasks</div>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div>
                                                    <i class="ri-list-check align-bottom me-1 text-muted"></i>
                                                    <?php echo e($project->completedTasksCount); ?>/<?php echo e($project->totalTasksCount); ?>

                                                    task
                                                </div>
                                            </div>
                                        </div>
                                        <div class="progress progress-sm animated-progress">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                aria-valuenow="<?php echo e($project->progressPercentage); ?>" aria-valuemin="0"
                                                aria-valuemax="100" style="width: <?php echo e($project->progressPercentage); ?>%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card body -->
                            <div class="card-footer bg-transparent border-top-dashed py-2">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <div class="avatar-group">
                                            <?php $count = 0; ?>
                                            <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($member->id_project == $project->id_project): ?>
                                                    <?php $count++; ?>
                                                    <?php if($count <= 5): ?>
                                                        <a href="javascript: void(0);" class="avatar-group-item"
                                                            data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                            data-bs-placement="top" title="<?php echo e($member->nama); ?>">
                                                            <div class="avatar-xxs">
                                                                <img src="<?php echo e($member->file_foto == null || '' ? asset('uploads/uploads/default.jpg') : asset('uploads/uploads/' . $member->file_foto)); ?>"
                                                                    alt="" class="rounded-circle img-fluid">
                                                            </div>
                                                        </a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($count > 5): ?>
                                                <a href="javascript: void(0);" class="avatar-group-item"
                                                    data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                    data-bs-placement="top" title="<?php echo e($count - 5); ?> more">
                                                    <div class="avatar-xxs">
                                                        <span
                                                            class="avatar-title rounded-circle bg-light text-primary">+</span>
                                                    </div>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="text-muted">
                                            <i class="ri-calendar-event-fill me-1 align-bottom"></i>
                                            <?php echo e(date('d F Y', strtotime($project->due_date))); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card footer -->
                        </div>
                        <!-- end card -->
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if(!$projectExists): ?>
                <div class="col-12">
                    <div class="alert alert-info">No Projects</div>
                </div>
            <?php endif; ?>
        </div>

        <!-- end col -->
        <!-- end row -->

        <div class="row g-0 text-center text-sm-start align-items-center mb-4">
            <div class="col-sm-6">
                <div>
                    <p class="mb-sm-0 text-muted">Showing <span
                            class="fw-semibold"><?php echo e($projectPage->firstItem()); ?></span> to <span
                            class="fw-semibold"><?php echo e($projectPage->lastItem()); ?></span> of <span
                            class="fw-semibold text-decoration-underline"><?php echo e($projectPage->total()); ?></span> entries</p>
                </div>
            </div>
            <div class="col-sm-6">
                <ul class="pagination pagination-separated justify-content-center justify-content-sm-end mb-sm-0">
                    <!-- Tombol Previous -->
                    <?php if($projectPage->currentPage() > 1): ?>
                        <li class="page-item">
                            <a href="<?php echo e($projectPage->previousPageUrl()); ?>" class="page-link">Previous</a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled">
                            <a href="#" class="page-link">Previous</a>
                        </li>
                    <?php endif; ?>

                    <!-- Tombol Halaman -->
                    <?php for($i = 1; $i <= $projectPage->lastPage(); $i++): ?>
                        <?php if($i == $projectPage->currentPage()): ?>
                            <li class="page-item active">
                                <a href="#" class="page-link"><?php echo e($i); ?></a>
                            </li>
                        <?php else: ?>
                            <li class="page-item">
                                <a href="<?php echo e($projectPage->url($i)); ?>" class="page-link"><?php echo e($i); ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <!-- Tombol Next -->
                    <?php if($projectPage->hasMorePages()): ?>
                        <li class="page-item">
                            <a href="<?php echo e($projectPage->nextPageUrl()); ?>" class="page-link">Next</a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled">
                            <a href="#" class="page-link">Next</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>


        <!-- END layout-wrapper -->
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
        <script src="<?php echo e(URL::asset('assets/js/pages/project-list.init.js')); ?>"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
        <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
        <script>
            $('#removeProjectModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Tombol yang diklik
                var projectId = button.data('project-id'); // Mendapatkan ID proyek dari atribut data-project-id
                var modal = $(this);

                // Mengatur tindakan formulir untuk mengarahkan ke rute penghapusan proyek yang sesuai
                modal.find('form').attr('action', '/projects/' + projectId);
            });
        </script>
        <script>
            function showConfirmation(projectId) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to delete this project!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + projectId).submit();
                    }
                });
            }
        </script>
        <script src="assets/js/app.min.js"></script>
        <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\it\ticket\resources\views/project/project-list.blade.php ENDPATH**/ ?>