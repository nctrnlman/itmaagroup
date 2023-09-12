
<?php $__env->startSection('title'); ?>
    Task
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('assets/libs/dropzone/dropzone.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/ckeditor.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('css/flatpickr.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Task
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Edit Task
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <?php if(Session::has('success')): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: 'Success',
                    text: '<?php echo e(Session::get('success')); ?>',
                    icon: 'success',
                    showCloseButton: true
                });
            });
        </script>
    <?php endif; ?>

    <?php if(Session::has('error')): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: 'Error',
                    text: '<?php echo e(Session::get('error')); ?>',
                    icon: 'error',
                    showCloseButton: true
                });
            });
        </script>
    <?php endif; ?>


    <form action="<?php echo e(route('tasks.update', ['id_task' => $task->id_task])); ?>" method="POST" id="createForm"
        enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="project-title-input">Task Title</label>
                            <input type="text" class="form-control" id="project-title-input" name="title"
                                placeholder="Enter project title" value="<?php echo e($task->title); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="choices-project-input" class="form-label">Project</label>
                            <select class="form-select" data-choices id="choices-project-input" name="id_project">
                                <option value="">Project...</option>
                                <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($project->id_project); ?>"
                                        <?php echo e($project->id_project == $task->id_project ? 'selected' : ''); ?>>
                                        <?php echo e($project->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Task Description</label>
                            <textarea class="form-control" name="description" id="ckeditor-classic" rows="5"><?php echo e($task->description); ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 mb-3">
                                <div class="mb-3">
                                    <label for="choices-status-input" class="form-label">Status</label>
                                    <select class="form-select" data-choices id="choices-status-input" name="status">
                                        <option value="">Status...</option>
                                        <option value="Pending" <?php echo e($task->status == 'Pending' ? 'selected' : ''); ?>>Pending
                                        </option>
                                        <option value="Progress" <?php echo e($task->status == 'Progress' ? 'selected' : ''); ?>>
                                            Progress</option>
                                        <option value="Completed" <?php echo e($task->status == 'Completed' ? 'selected' : ''); ?>>
                                            Completed</option>
                                        <option value="Rejected" <?php echo e($task->status == 'Rejected' ? 'selected' : ''); ?>>
                                            Rejected</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div>
                                    <label for="datepicker-deadline-input" class="form-label">Start Date</label>
                                    <input type="text" class="form-control" id="datepicker-deadline-input"
                                        name="start_date" placeholder="Enter start date"
                                        data-provider="flatpickr"value="<?php echo e($task->start_date); ?>">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div>
                                    <label for="datepicker-deadline-input" class="form-label">Due Date</label>
                                    <input type="text" class="form-control" id="datepicker-deadline-input"
                                        name="due_date" placeholder="Enter due date" data-provider="flatpickr"
                                        value="<?php echo e($task->due_date); ?>">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div>
                                    <label for="file-input" class="form-label">Upload File</label>
                                    <input type="file" class="form-control" id="file-input" name="file">
                                    <?php if($task->file): ?>
                                        <p class="mt-2">File saat ini: <?php echo e($task->file); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->

                <!-- end card -->
                <!-- Isi form input lainnya -->
                <div class="text-end mb-4" form="createForm">
                    <button type="button" class="btn btn-danger w-sm"><a href="<?php echo e(route('tasks.index')); ?>"
                            class="text-white">Cancel</a></button>
                    <button type="button" class="btn btn-success w-sm" id="createButton">Update</button>
                </div>
            </div>
        </div>


        <!-- end row -->
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('assets/libs/@ckeditor/@ckeditor.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/libs/dropzone/dropzone.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/libs/flatpickr/flatpickr.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/js/pages/sweetalerts.init.js')); ?>"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
    <script>
        // Initialize Flatpickr
        flatpickr('#datepicker-deadline-input', {
            // Add any Flatpickr options if needed
        });

        // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#ckeditor-classic'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });

        // Handle form submission
        document.getElementById('createButton').addEventListener('click', function() {
            document.getElementById('createForm').submit();
        });
    </script>
    <script src="<?php echo e(asset('assets/libs/choices.js/choices.js.min.js')); ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var projectSelectElement = document.querySelector('#choices-project-input');
            var projectChoices = new Choices(projectSelectElement, {
                searchEnabled: true,
            });

            var statusSelectElement = document.querySelector('#choices-status-input');
            var statusChoices = new Choices(statusSelectElement, {
                searchEnabled: true,
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\ticket\resources\views/task/task-edit.blade.php ENDPATH**/ ?>