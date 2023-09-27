

<?php $__env->startSection('title'); ?>
    ATK
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('assets/libs/jsvectormap/jsvectormap.min.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <link href="<?php echo e(asset('css/ckeditor.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Administrator
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            ATK
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">ATK List</h5>
                        <div class="flex-shrink-0">
                            <button class="btn btn-danger add-btn" data-bs-toggle="modal" data-bs-target="#showModal">
                                <i class="ri-add-line align-bottom me-1"></i> Add ATK
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="exampleee" class="display table table-bordered dt-responsive" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID ATK</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $atkList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($atk->id_atk); ?></td>
                                    <td><?php echo e($atk->description); ?></td>
                                    <td>
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill align-middle"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a href="javascript:void(0);" class="dropdown-item edit-item-btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal<?php echo e($atk->id_atk); ?>"
                                                        data-nama="<?php echo e($atk->description); ?>">
                                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>Edit
                                                    </a>
                                                </li>
                                                <form action="<?php echo e(route('atk.destroy', ['id' => $atk->id_atk])); ?>"
                                                    method="POST" class="delete-form">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="button" class="dropdown-item edit-item-btn"
                                                        onclick="showConfirmation('<?php echo e($atk->id_atk); ?>', '<?php echo e($atk->description); ?>')">
                                                        <i class="fa fa-trash align-bottom me-2 text-muted"></i> Delete
                                                    </button>
                                                </form>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- end col -->
    </div>


    </div>

    <!-- Modal for Adding New atkistrator -->
    <div class="modal fade zoomIn" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header p-3 bg-soft-info">
                    <h5 class="modal-title" id="exampleModalLabel">Add ATK</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>
                <form action="<?php echo e(route('atk.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <div id="modal-id">
                                    <label for="choices-status-input" class="form-label">ID ATK</label>
                                    <input type="text" id="id" class="form-control" name="id" required />

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="choices-status-input" class="form-label">Description</label>
                                <input type="text" id="desc" class="form-control" name="desc" required />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modals for Editing Existing atkistrators -->
    <?php $__currentLoopData = $atkList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade zoomIn" id="editModal<?php echo e($atk->id_atk); ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0">
                    <div class="modal-header p-3 bg-soft-info">
                        <h5 class="modal-title" id="exampleModalLabel">Edit ATK</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="close-edit-modal"></button>
                    </div>
                    <form action="<?php echo e(route('atk.update', ['id' => $atk->id_atk])); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <div id="modal-id">
                                        <label for="choices-status-input" class="form-label">ID ATK</label>
                                        <input type="text" class="form-control" name="id"
                                            value="<?php echo e($atk->id_atk); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="choices-status-input" class="form-label">Description</label>
                                    <input type="text" class="form-control" name="desc"
                                        value="<?php echo e($atk->description); ?>">
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
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <script src="<?php echo e(asset('assets/libs/choices.js/choices.js.min.js')); ?>"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
    <script>
        function showConfirmation(idAccess, atkName) {
            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete ${atkName}!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.querySelector(`form[action="<?php echo e(route('atk.destroy', ['id' => ':id_atk'])); ?>"]`
                        .replace(':id_atk', idAccess)).submit();
                }
            });
        }
    </script>
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

                $('#modal-id select[name="id_atk"]').val(nama);
                $('#modal-id select[name="access_type"]').val(accessType);
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\it\ticket\resources\views/facilities/atk.blade.php ENDPATH**/ ?>