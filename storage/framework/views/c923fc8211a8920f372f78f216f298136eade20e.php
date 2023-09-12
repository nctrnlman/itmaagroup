
<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.task-details'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('assets/libs/jsvectormap/jsvectormap.min.css')); ?>" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0@/css/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <!-- ... -->


    <?php
        use App\Helpers\Helper;
    ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">

        <!---end col-->
        <div class="col-xxl-8">
            <div class="card" style="height: 585px;">
                <div class="card-body">
                    <div class="text-muted">
                        <h6 class="mb-3 fw-semibold text-uppercase" style="font-size: 16px;">Summary</h6>
                        <p><?php echo $task->description; ?></p>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xxl-4">

            <!--end card-->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="card-title mb-0 flex-grow-1">Review</h6>
                    </div>
                    <div class="table-card">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <td class="fw-medium">Tasks ID</td>
                                    <td><?php echo e($task->id_task); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Tasks Title</td>
                                    <td><?php echo e($task->title); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Project Name</td>
                                    <td><?php echo e($task->project->title); ?> </td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Status</td>
                                    <td><?php echo e($task->status); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Start Date</td>
                                    <td><?php echo e(date('d F Y', strtotime($task->start_date))); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Due Date</td>
                                    <td><?php echo e(date('d F Y', strtotime($task->due_date))); ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <!--end table-->
                    </div>
                </div>
            </div>
            <!--end card-->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <h6 class="card-title mb-0 flex-grow-1">Assigned To</h6>
                    </div>
                    <div class="scrollable-list" style="max-height: 192px; overflow-y: auto;">
                        <ul class="list-unstyled vstack gap-3 mb-0">
                            <?php $__currentLoopData = $projectMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projectMember): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $employee = $employees->where('idnik', $projectMember->idnik)->first();
                                ?>
                                <li>
                                    <?php if($employee): ?>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="<?php echo e($employee->file_foto ? asset('uploads/uploads/' . $employee->file_foto) : asset('uploads/uploads/default.jpg')); ?>"
                                                    alt="<?php echo e($employee->nama); ?>" class="avatar-xs rounded-circle">
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <h6 class="mb-1"><a href="pages-profile"><?php echo e($employee->nama); ?></a></h6>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="dropdown">
                                                    <button class="btn btn-icon btn-sm fs-16 text-muted dropdown"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ri-more-fill"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item"
                                                                href="<?php echo e(route('employee.view', ['idnik' => $employee->idnik])); ?>"><i
                                                                    class="ri-eye-fill text-muted me-2 align-bottom"></i>View</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <p>Employee not found for idnik: <?php echo e($projectMember->idnik); ?></p>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>


            <!--end card-->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Attachments</h5>
                    <div class="vstack gap-2">
                        <div class="border rounded border-dashed p-2">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-light text-secondary rounded fs-24">
                                            <?php
                                            $extension = pathinfo($task->file, PATHINFO_EXTENSION);
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
                                                    $iconClass = 'fa fa-file text-secondary'; // default icon if no matching icon found
                                                    break;
                                            }
                                            ?>
                                            <i class="<?php echo e($iconClass); ?>"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <?php if($task->file): ?>
                                        <h5 class="fs-13 mb-1"><a
                                                href="<?php echo e(asset('storage/uploads/tasks/' . $task->file)); ?>"
                                                download>File</a></h5>
                                        <div>
                                            <?php echo e(Helper::formatSizeUnits(filesize(storage_path('app/public/tasks/' . $task->file)))); ?>

                                        </div>
                                    <?php else: ?>
                                        <h5 class="fs-13 mb-1">No file attached</h5>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-shrink-0 ms-2">
                                    <?php if($task->file): ?>
                                        <div class="d-flex gap-1">
                                            <a href="<?php echo e(route('download', ['folder' => 'tasks', 'filename' => $task->file])); ?>"
                                                download>
                                                <button type="button" class="btn btn-icon text-muted btn-sm fs-18">
                                                    <i class="ri-download-2-line"></i>
                                                </button>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>





            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->
    <!-- end modal -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
    <script>
        function formatSizeUnits($bytes) {
            $sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
            if ($bytes == 0) {
                return '0 '.$sizes[0];
            }
            $i = floor(log($bytes, 1024));
            return round($bytes / pow(1024, $i), 2).
            ' '.$sizes[$i];
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\ticket\resources\views/task/task-view.blade.php ENDPATH**/ ?>