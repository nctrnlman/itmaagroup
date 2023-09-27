

<?php $__env->startSection('title'); ?>
    Other Facilities
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('assets/libs/jsvectormap/jsvectormap.min.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link href="<?php echo e(asset('css/ckeditor.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <link href="<?php echo e(URL::asset('assets/libs/dropzone/dropzone.min.css')); ?>" rel="stylesheet">
    <style>
        .modal-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .note {
            font-size: 12px;
            margin-top: 20px;
            background-color: #f7f7f7;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .note-title {
            font-weight: bold;
            font-size: 15px;
            margin-bottom: 10px;
        }

        .note-item {
            margin-bottom: 5px;
            text-align: justify;
        }

        .highlight {
            font-weight: bold;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            GA Facilities
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Other Facilities
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-xxl-3 col-sm-6">
            <div class="card card-animate card-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="fw-medium text-muted mb-0">Total Tickets</p>
                            <h2 class="mt-4 ff-secondary fw-semibold">
                                <span class="counter-value"
                                    data-target="<?php if(session('user')['access_type'] === 'Admin' || session('user')['access_type'] === 'GA Other Facilities'): ?> <?php echo e($totalTickets); ?>

                            <?php else: ?>
                                <?php echo e($totalTickets); ?> <?php endif; ?>">
                                </span>
                            </h2>
                        </div>
                        <div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-info text-info rounded-circle fs-4">
                                    <i class="ri-ticket-2-line"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div> <!-- end card-->
        </div>
        <!--end col-->
        <div class="col-xxl-3 col-sm-6">
            <div class="card card-animate card-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="fw-medium text-muted mb-0">Pending Tickets</p>
                            <h2 class="mt-4 ff-secondary fw-semibold">
                                <span class="counter-value"
                                    data-target='<?php if(session('user')['access_type'] === 'Admin' || session('user')['access_type'] === 'GA Other Facilities'): ?> <?php echo e($pendingTickets); ?>

                            <?php else: ?>
                                <?php echo e($pendingTickets); ?> <?php endif; ?>'>

                                </span>
                            </h2>
                        </div>
                        <div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-info text-info rounded-circle fs-4">
                                    <i class="mdi mdi-timer-sand"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div>
        </div>
        <!--end col-->
        <div class="col-xxl-3 col-sm-6">
            <div class="card card-animate card-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="fw-medium text-muted mb-0">Process Tickets</p>
                            <h2 class="mt-4 ff-secondary fw-semibold">
                                <span class="counter-value"
                                    data-target='<?php if(session('user')['access_type'] === 'Admin' || session('user')['access_type'] === 'GA Other Facilities'): ?> <?php echo e($processTickets); ?>

                            <?php else: ?>
                                <?php echo e($processTickets); ?> <?php endif; ?>'>

                                </span>
                            </h2>
                        </div>
                        <div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-info text-info rounded-circle fs-4">
                                    <i class="ri-shopping-bag-line"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div>
        </div>
        <!--end col-->
        <div class="col-xxl-3 col-sm-6">
            <div class="card card-animate card-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="fw-medium text-muted mb-0">Closed Tickets</p>
                            <h2 class="mt-4 ff-secondary fw-semibold">
                                <span class="counter-value"
                                    data-target=' <?php if(session('user')['access_type'] === 'Admin' || session('user')['access_type'] === 'GA Other Facilities'): ?> <?php echo e($closedTickets); ?>

                            <?php else: ?>
                                <?php echo e($closedTickets); ?> <?php endif; ?>'>

                                </span>
                            </h2>
                        </div>
                        <div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-info text-info rounded-circle fs-4">
                                    <i class="ri-delete-bin-line"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->


    <div class="row overflow-auto ">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="card-title mb-0 flex-grow-1 flex">
                            <h5>Other facilities Request (Purchase Request)</h5>
                            <h6>For purchasing and replacing items, you are required to attach the approved material request
                                form.</h6>
                        </div>

                        <div class="flex-shrink-0">
                            <button class="btn btn-danger add-btn" data-bs-toggle="modal" data-bs-target="#showModal">
                                <i class="ri-add-line align-bottom me-1"></i> Create Ticketing
                            </button>
                        </div>

                    </div>

                </div>
                <div class="card-body">
                    <table id="exampleee" class="display table table-bordered dt-responsive" style="width:100%">
                        <?php
                        if (session('user')['access_type'] === 'Admin' || session('user')['access_type'] === 'GA Other Facilities') {
                            echo '
                                                <thead>
                                                <tr>
                                                <th>No.</th>
                                                <th>ID Ticket</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Request</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Type of service</th>
                                                <th>PIC</th>
                                                <th>Action</th>
                                                </tr>
                                                </thead>
                                                ';
                        } else {
                            echo '
                                                <thead>
                                                <tr>
                                                <th>No.</th>
                                                <th>ID Ticket</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Type of service</th>
                                                <th>PIC</th>
                                                <th>Action</th>
                                                </tr>
                                                </thead>
                                                ';
                        }
                        ?>
                        <tbody>
                            <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($ticket->id_ga_other_facilities); ?></td>
                                    <td><?php echo e(date('d F Y', strtotime($ticket->start_date))); ?></td>
                                    <td><?php echo e($ticket->end_date ? date('d F Y', strtotime($ticket->end_date)) : '-'); ?></td>
                                    <?php if(session('user')['access_type'] === 'Admin' || session('user')['access_type'] === 'GA Other Facilities'): ?>
                                        <td><?php echo e($ticket->nama); ?></td>
                                    <?php endif; ?>
                                    <td><?php echo str_replace(["\r\n", "\r", "\n"], ', ', Illuminate\Support\Str::limit(strip_tags($ticket->description), 60)); ?></td>
                                    <td><?php echo e($ticket->status); ?></td>
                                    <td><?php echo e($ticket->category); ?></td>
                                    <?php
                                        $userGA = $usersGA->firstWhere('idnik', $ticket->nik_pic);
                                    ?>
                                    <td><?php echo e($userGA ? $userGA->nama : '-'); ?></td>
                                    <td>
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill align-middle"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <?php if(session('user')['access_type'] === 'Admin' ||
                                                        (session('user')['access_type'] === 'GA Other Facilities' && $ticket->category === 'Other Facilities Request')): ?>
                                                    <li>
                                                        <a href="<?php echo e(route('other-facilities.detail', ['id_tiket' => $ticket->id_ga_other_facilities])); ?>"
                                                            class="dropdown-item edit-item-btn">
                                                            <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="dropdown-item edit-item-btn"
                                                            onclick="event.preventDefault(); showConfirmation('<?php echo e($ticket->id_ga_other_facilities); ?>');">
                                                            <i class="fa fa-trash align-bottom me-2 text-muted"></i> Delete
                                                        </a>
                                                        <form id="delete-form-<?php echo e($ticket->id_ga_other_facilities); ?>"
                                                            action="<?php echo e(route('other-facilities.delete', ['id_tiket' => $ticket->id_ga_other_facilities])); ?>"
                                                            method="POST" style="display: none;">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                        </form>
                                                    </li>
                                                <?php else: ?>
                                                    <li>
                                                        <a href="<?php echo e(route('other-facilities.detail', ['id_tiket' => $ticket->id_ga_other_facilities])); ?>"
                                                            class="dropdown-item view-item-btn">
                                                            <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View
                                                        </a>
                                                    </li>
                                                    <?php if($ticket->status == 'Pending'): ?>
                                                        <li>
                                                            <a href="#" class="dropdown-item edit-item-btn"
                                                                onclick="event.preventDefault(); showConfirmation('<?php echo e($ticket->id_ga_other_facilities); ?>');">
                                                                <i class="fa fa-trash align-bottom me-2 text-muted"></i>
                                                                Delete
                                                            </a>
                                                            <form id="delete-form-<?php echo e($ticket->id_other_facilities); ?>"
                                                                action="<?php echo e(route('other-facilities.delete', ['id_tiket' => $ticket->id_ga_other_facilities])); ?>"
                                                                method="POST" style="display: none;">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('DELETE'); ?>
                                                            </form>
                                                        </li>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>
    </div>

    <div class="modal fade zoomIn" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 1070px;">
            <div class="modal-content border-0">
                <div class="modal-header p-3 bg-soft-info">
                    <h5 class="modal-title" id="exampleModalLabel">Create Request GA Facilities - Other facilities Request
                        (Purchase Request)
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>
                <form action="<?php echo e(route('other-facilities.insert')); ?>" method="POST" id="myForm"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <div>
                                    <label for="desc" class="form-label">Description</label>
                                    <textarea class="form-control" id="ckeditor-classic" placeholder="Description your problem" rows="25"
                                        name="desc" required></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 ">
                                <div class="mb-3">
                                    <label for="lampiran1" class="form-label">Material Request Form (if any)</label>
                                    <input type="file" id="lampiran1" class="form-control" name="lampiran1"
                                        required />
                                </div>
                                <div>
                                    <label for="wa" class="form-label">No.Whatsapp</label>
                                    <input type="text" id="wa" class="form-control"
                                        placeholder="Insert your active number" name="wa" />
                                </div>
                                <?php if(session('user')['access_type'] === 'Admin' || session('user')['access_type'] === 'GA Other Facilities'): ?>
                                    <div class="mb-3 mt-2">
                                        <label for="choices-status-input" class="form-label">Request User</label>
                                        <select class="form-select" data-choices id="choices-status-input"
                                            name="request">
                                            <option value="">All Users</option>
                                            <?php $__currentLoopData = $allUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($user->idnik); ?>"><?php echo e($user->nama); ?> |
                                                    <?php echo e($user->idnik); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                <?php else: ?>
                                    <input type="hidden" name="request" value="<?php echo e(session('user')->idnik); ?>">
                                <?php endif; ?>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light"
                            onclick="submitForm(event)">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
    <script src="<?php echo e(URL::asset('assets/libs/@ckeditor/@ckeditor.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/libs/dropzone/dropzone.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/libs/flatpickr/flatpickr.min.js')); ?>"></script>
    <script src="assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
    <script>
        function showConfirmation(ticketId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to delete this item!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + ticketId).submit();
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
        });
    </script>
    <script>
        // Initialize Flatpickr
        flatpickr('#datepicker-deadline-input', {});

        // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#ckeditor-classic'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        function submitForm(event) {
            event.preventDefault();
            document.getElementById('myForm').submit();
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\it\ticket\resources\views/facilities/other-facilities.blade.php ENDPATH**/ ?>