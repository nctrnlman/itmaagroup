

<?php $__env->startSection('title'); ?>
    Other Facilities
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('assets/libs/jsvectormap/jsvectormap.min.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0@/css/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="<?php echo e(asset('css/ckeditor.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('assets/libs/dropzone/dropzone.min.css')); ?>" rel="stylesheet">
    <!-- ... -->
    <?php
        use App\Helpers\Helper;
    ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Other Facilities
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Detail Ticketing
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <form action="<?php echo e(route('other-facilities.update', ['id_tiket' => $ticket->id_ga_other_facilities])); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
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
                                                    <img src="<?php echo e(URL::asset('assets/images/logo_MAAA.png')); ?>"
                                                        alt="" width="65px" />
                                                </div>
                                            </div>
                                        </div>
                                        <!--end col-->

                                        <div class="col-md">
                                            <h4 class="fw-semibold pb-2">#<?php echo e($ticket->id_ga_other_facilities); ?> - Other
                                                facilities Request (Purchase Request)
                                            </h4>
                                            <div class="hstack gap-3 flex-wrap">
                                                <div class="text-muted"><i class="ri-building-line align-bottom me-1"></i>
                                                    MAA GROUP</div>
                                                <div class="vr"></div>
                                                <?php if(session('user')['access_type'] === 'Admin' ||
                                                        (session('user')['access_type'] === 'GA Other Facilities' && $ticket->category === 'Other Facilities Request')): ?>
                                                    <div class="text-muted">Status : <span class="fw-medium"></span></div>
                                                    <div>
                                                        <select class="form-select" data-choices id="choices-status-input"
                                                            name="status">
                                                            <option value="">Default</option>
                                                            <?php $__currentLoopData = ['Pending', 'Process', 'Closed', 'Rejected']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($option); ?>"
                                                                    <?php echo e($ticket->status == $option ? 'selected' : ''); ?>>
                                                                    <?php echo e($option); ?>

                                                                </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>

                                                    </div>
                                                    <div class="vr"></div>
                                                    <div class="text-muted">Assigned To : <span class="fw-medium"> </span>
                                                    </div>
                                                    <div>
                                                        <select class="form-select" name="nik_pic" data-choices
                                                            id="choices-status-input">
                                                            <option value="">No Set</option>
                                                            <?php $__currentLoopData = $usersGA; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userGA): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($userGA->idnik); ?>"
                                                                    <?php echo e($ticket->nik_pic == $userGA->idnik ? 'selected' : ''); ?>>
                                                                    <?php echo e($userGA->nama); ?>

                                                                </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                        </select>
                                                    </div>
                                                    <div class="">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="text-muted">Status : <span class="fw-medium">
                                                            <?php echo e($ticket->status ?: '-'); ?></span></div>
                                                    <div class="vr"></div>
                                                    <div class="text-muted">Request type : <span class="fw-medium">
                                                            <?php echo e($ticket->category ?: '-'); ?></span></div>
                                                    <div class="vr"></div>
                                                    <div class="text-muted">Assigned To : <span class="fw-medium">
                                                            <?php $__currentLoopData = $usersGA; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userGA): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if($userGA->idnik == $ticket->nik_pic): ?>
                                                                    <?php echo e($userGA->nama ?: '-'); ?>

                                                                <?php break; ?>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </span></div>

                                            <?php endif; ?>
</form>
</div>
</div>
<!--end col-->
</div>
<!--end row-->
</div>
<!--end col-->
<div class="col-md-auto mt-md-0 mt-4">
    <div class="hstack gap-1 flex-wrap">

        <button type="button" class="btn py-0 fs-16 text-body" id="settingDropdown" data-bs-toggle="dropdown">
            <i class="ri-share-line"></i>
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
        <div class="card" style="background-color: #b30000">
            <div class="card-body p-4" style="color: white">
                <h6 class="fw-semibold text-uppercase mb-3 fs-5" style="color: white">Ticket Description</h6>
                <p style="color: white"><?php echo $ticket->description; ?></p>


            </div>


            <div class="card-body p-4">
                <h5 class="card-title mb-4" style="color: white">Feedback</h5>

                <?php if($comments->isEmpty()): ?>
                    <div data-simplebar style="height: 300px; " class="px-3 mx-n3">
                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0">
                                <img src="<?php echo e(URL::asset('assets/images/users/avatar-9.jpg')); ?>" alt=""
                                    class="avatar-xs rounded-circle" />
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="fs-13" style="color: white">General Affair PIC <small
                                        style="color: white"><?php echo e(date('d M Y - h:iA', strtotime('2023-12-27 05:47AM'))); ?></small>
                                </h5>
                                <p style="color: white">I got a message from you guys that they have a problem. Can you
                                    state their
                                    problems?</p>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div data-simplebar style="max-height: 300px; overflow-y: auto;" class="px-3 mx-n3">
                        <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="d-flex mb-4">
                                <div class="flex-shrink-0">
                                    <img src="<?php echo e($comment->file_foto == null || '' ? asset('uploads/uploads/default.jpg') : asset('uploads/uploads/' . $comment->file_foto)); ?>"
                                        alt="" class="avatar-xs rounded-circle" />
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="fs-13" style="color: white"><?php echo e($comment['nama']); ?> <small
                                            style="color: white"><?php echo e(date('d M Y - h:iA', strtotime($comment['datetime']))); ?></small>
                                    </h5>
                                    <p style="color: white"><?php echo e($comment['keterangan_komen']); ?></p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
                <?php if($ticket->status == 'Closed'): ?>
                    <div class="alert alert-warning" role="alert">
                        Feedback cannot be added as the ticket is already closed.
                    </div>
                <?php else: ?>
                    <form action="<?php echo e(route('other-facilities.komentar')); ?>" method="POST" class="mt-3">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id_tiket" value="<?php echo e($ticket->id_ga_other_facilities); ?>">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <label for="keterangan_komen" class="form-label" style="color: white">Leave a
                                    Feedback</label>
                                <textarea class="form-control bg-light border-light" name="keterangan_komen" rows="3" placeholder="Type Here"></textarea>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn" style="background-color: white">Post
                                    Feedback</button>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>

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
                                <td>#<?php echo e($ticket->id_ga_other_facilities ?: ''); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-medium">Client</td>
                                <td><?php echo e($ticket->nama ?: '-'); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-medium">Email</td>
                                <td><?php echo e($ticket->username ?: '-'); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-medium">No.Hp</td>
                                <td><?php echo e($ticket->whatsapp ?: '-'); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-medium">Division</td>
                                <td><?php echo e($ticket->divisi ?: '-'); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-medium">Office Location</td>
                                <td><?php echo e($ticket->lokasi ?: '-'); ?></td>
                            </tr>

                            <tr>
                                <td class="fw-medium">Start Date</td>
                                <td><?php echo e(date('Y-m-d', strtotime($ticket->start_date))); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-medium">End Date</td>
                                <td><?php echo e($ticket->end_date ? date('Y-m-d', strtotime($ticket->end_date)) : '-'); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!--end card-body-->
        </div>
        <!--end card-->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title fw-semibold mb-0">Files Attachment</h6>
            </div>
            <div class="card-body">
                <?php if($ticket->file || $ticket->lampiran2): ?>
                    <?php $__currentLoopData = [$ticket->file, $ticket->lampiran2]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lampiran): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($lampiran): ?>
                            <div class="d-flex align-items-center border border-dashed p-2 rounded mt-2">
                                <div class="flex-shrink-0 avatar-sm">
                                    <?php
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
                                    ?>

                                    <div class="avatar-title bg-light rounded">
                                        <i class="<?php echo e($iconClass); ?> fs-20"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">
                                        <a href="<?php echo e(asset('storage/gaBuilding/' . $lampiran)); ?>"
                                            id="materialRequestLink">Material Request Form</a>
                                    </h6>
                                    <small class="text-muted">
                                        <?php echo e(Helper::formatSizeUnits(filesize(storage_path('app/public/gaOther/' . $lampiran)))); ?>

                                    </small>
                                </div>
                                <div class="hstack gap-3 fs-16">
                                    <a href="<?php echo e(route('download', ['folder' => 'gaOther', 'filename' => $lampiran])); ?>"
                                        class="text-muted">
                                        <i class="fa fa-download"></i>
                                    </a>
                                </div>

                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="alert alert-info mt-3" role="alert">
                        <i class="fa fa-info-circle me-2"></i>
                        No files uploaded.
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php if(session('user')['access_type'] !== 'Admin' || session('user')['access_type'] !== 'GA Other Facilities'): ?>
            <div class="col-lg-12">
                <div class="hstack gap-2 justify-content-end">
                    <a href="<?php echo e(route('other-facilities.index')); ?>" class="btn btn-soft-success">Cancel</a>
                </div>
            </div>
        <?php endif; ?>
        <!--end col-->
    </div>
</div>






<!--end row-->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('assets/js/pages/ticketdetail.init.js')); ?>"></script>
<script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
<script src="assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>
<script src="<?php echo e(URL::asset('assets/libs/@ckeditor/@ckeditor.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/libs/choices.js/choices.js.min.js')); ?>"></script>
<script src="assets/js/app.min.js"></script>
<script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
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
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var viewFileButtons = document.querySelectorAll(".view-file");
        var fileModal = document.getElementById("fileModal");
        var fileContent = document.getElementById("fileContent");
        var materialRequestLink = document.getElementById("materialRequestLink");

        viewFileButtons.forEach(function(button) {
            button.addEventListener("click", function(event) {
                event.preventDefault();
                var fileUrl = button.getAttribute("data-file-url");
                var extension = fileUrl.split('.').pop().toLowerCase();

                if (extension === 'pdf') {
                    // Jika berkas adalah PDF, gunakan tag iframe untuk menampilkannya
                    fileContent.innerHTML = '<iframe src="' + fileUrl +
                        '" style="width: 100%; height: 500px;"></iframe>';
                } else if (['png', 'jpg', 'jpeg'].includes(extension)) {
                    // Jika berkas adalah gambar, gunakan tag img untuk menampilkannya
                    fileContent.innerHTML = '<img src="' + fileUrl +
                        '" alt="Gambar" style="max-width: 100%; max-height: 500px;">';
                } else {
                    // Jika tipe berkas tidak dikenali, tampilkan pesan error
                    fileContent.innerHTML =
                        '<p class="text-danger">Tipe berkas tidak didukung.</p>';
                }

                // Tampilkan modal
                $(fileModal).modal("show");
            });
        });

        // Hapus event listener untuk teks "Material Request Form"
        materialRequestLink.removeEventListener("click", function(event) {
            // Tambahkan tindakan yang ingin Anda lakukan ketika teks diklik di sini
            alert("Teks 'Material Request Form' diklik.");
            event.preventDefault();
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\it\ticket\resources\views/facilities/other-facilities-detail.blade.php ENDPATH**/ ?>