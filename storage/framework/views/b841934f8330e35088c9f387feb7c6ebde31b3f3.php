

<?php $__env->startSection('title'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('assets/libs/jsvectormap/jsvectormap.min.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

    <!-- CSS DataTables Buttons -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

    <!-- CSS JSZip (diperlukan oleh DataTables Buttons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js">

    <!-- CSS DataTables Select (diperlukan oleh DataTables Buttons) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Dashboard
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Employee
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg profile-setting-img">
            <img src="<?php echo e(URL::asset('assets/images/profile-bg.jpg')); ?>" class="profile-wid-img" alt="">
            <div class="overlay-content">
                <div class="text-end p-3">
                    <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                        <input id="profile-foreground-img-file-input" type="file"
                            class="profile-foreground-img-file-input">
                        <label for="profile-foreground-img-file-input" class="profile-photo-edit btn btn-light">
                            <i class="ri-image-edit-line align-bottom me-1"></i> Change Cover
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xxl-3 ">
            <div class="card mt-n5">
                <div class="card-body p-4">
                    <div class="text-center mb-3">
                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                            <img src="<?php echo e($employee->file_foto == null ? asset('uploads/uploads/default.jpg') : asset('uploads/uploads/' . $employee->file_foto)); ?>"
                                class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                <form method="POST"
                                    action="<?php echo e(route('employee.photoProfile', ['idnik' => $employee->idnik])); ?>"
                                    enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <input type="text" value="<?php echo e($employee->idnik); ?>" name="idnik" hidden>
                                    <input id="profile-img-file-input" type="file" name="file_foto"
                                        class="profile-img-file-input">
                                    <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                        <span class="avatar-title rounded-circle bg-light text-body">
                                            <i class="ri-camera-fill"></i>
                                        </span>
                                    </label>
                            </div>

                        </div>

                        <h5 class="fs-16 mb-1"><?php echo e($employee->nama); ?></h5>
                        <p class="text-muted mb-0"><?php echo e($employee->divisi); ?> / <?php echo e($employee->position); ?></p>

                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success" name="Update_User">Update Foto</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-9">
            <div class="card mt-xxl-n5">
                <div class="card-header">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                <i class="fas fa-home"></i> Personal Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                <i class="far fa-user"></i> Change Password
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#dokumen" role="tab">
                                <i class="far fa-envelope"></i> Dokumen
                            </a>
                        </li>

                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                            <form action="<?php echo e(route('employee.update', ['idnik' => $employee->idnik])); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="firstnameInput" class="form-label"> Name</label>
                                            <input hidden type="text" name="idnik" value="<?php echo e($employee->idnik); ?>">
                                            <input type="text" class="form-control" id="firstnameInput"
                                                placeholder="Enter your firstname" name="nama"
                                                value="<?php echo e($employee->nama); ?>">

                                        </div>
                                    </div>

                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="company" class="form-label">Company</label>
                                            <input type="text" class="form-control" id="text"
                                                placeholder="Enter your Company" name="company"
                                                value="<?php echo e($employee->company); ?>">
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="phonenumberInput" class="form-label">Lokasi</label>
                                            <input type="text" class="form-control" id="phonenumberInput"
                                                placeholder="Enter your phone number" name="lokasi"
                                                value="<?php echo e($employee->lokasi); ?>">
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <!--end col-->

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="divisi" class="form-label">Divisi</label>
                                            <input type="text" class="form-control" id="divisi"
                                                placeholder="Enter your phone divisi" name="divisi"
                                                value="<?php echo e($employee->divisi); ?>">
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <!--end col-->

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="department" class="form-label">Department</label>
                                            <input type="text" class="form-control" id="department"
                                                placeholder="Enter your department" name="department"
                                                value="<?php echo e($employee->departement); ?>">
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="section" class="form-label">Section</label>
                                            <input type="text" class="form-control" id="section"
                                                placeholder="Enter your section" name="section"
                                                value="<?php echo e($employee->section); ?>">
                                        </div>
                                    </div>

                                    <!--end col-->

                                    <!--end col-->

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="section" class="form-label">position</label>
                                            <input type="text" class="form-control" id="position"
                                                placeholder="Enter your position" name="position"
                                                value="<?php echo e($employee->position); ?>">
                                        </div>
                                    </div>

                                    <!--end col-->

                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="text" class="form-label">Clasifikasi</label>
                                            <input type="clasifikasi" class="form-control" id="clasifikasi"
                                                placeholder="Enter your clasifikasi" name="clasifikasi"
                                                value="<?php echo e($employee->clasifikasi); ?>">
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="atasan" class="form-label">Atasan</label>
                                            <input type="text" class="form-control" id="atasan"
                                                placeholder="Enter your atasan" name="atasan"
                                                value="<?php echo e($employee->atasan); ?>">
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="domisili" class="form-label">Domisili</label>
                                            <input type="text" class="form-control" id="domisili"
                                                placeholder="Enter your domisili" name="poh"
                                                value="<?php echo e($employee->poh); ?>">
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="roster" class="form-label">Roster</label>
                                            <input type="text" class="form-control" id="roster"
                                                placeholder="Enter your roster" name="roster"
                                                value="<?php echo e($employee->roster); ?>">
                                        </div>
                                    </div>

                                    <!--end col-->

                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="date" class="form-label">Date</label>
                                            <input type="date" class="form-control" id="date"
                                                placeholder="Enter your doh" name="doh"
                                                value="<?php echo e($employee->doh); ?>">
                                        </div>
                                    </div>


                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="company" class="form-label">Status</label>

                                            <select class="form-select mb-3" aria-label="Default select example"
                                                name="status">
                                                <option value="status"><?php echo e($employee->status); ?></option>
                                                <option value="Aktif">Aktif</option>
                                                <option value="Non Aktif">Non Aktif</option>
                                            </select>

                                        </div>


                                    </div>

                                    <!--end col-->




                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="submit" class="btn btn-primary"
                                                name="update">Updates</button>
                                            
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </form>
                        </div>
                        <!--end tab-pane-->
                        <div class="tab-pane" id="changePassword" role="tabpanel">
                            <form action="<?php echo e(route('changePassword', ['idnik' => $employee->idnik])); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="row g-2">
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="email" class="form-label">Email</label>
                                            <input hidden type="text" name="idnik" value="<?php echo e($employee->idnik); ?>">
                                            <input type="text" class="form-control" id="email" readonly
                                                name="username" value="<?php echo e($employee->username); ?>">
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <div class="col-lg-4">
                                        <div>
                                            <label for="confirmpasswordInput" class="form-label">Password Baru</label>
                                            <input type="password" class="form-control" id="confirmpasswordInput"
                                                placeholder="Confirm password" name="password"
                                                value="<?php echo e($employee->password); ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div>
                                            <label for="role login" class="form-label">Role Login</label>

                                            <select class="form-select mb-3" aria-label="Default select example"
                                                name="role">
                                                <option value="<?php echo e($employee->role); ?>"><?php echo e($employee->role); ?></option>
                                                <option value="user">user</option>
                                                <option value="admin">admin</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--end col-->


                                    <div class="col-lg-12">
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-success"
                                                name="update-admin">Update</button>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </form>

                        </div>

                        <div class="tab-pane" id="dokumen" role="tabpanel">
                            <div class="d-flex align-items-center mb-4">
                                <h5 class="card-title flex-grow-1 mb-0">Documents</h5>
                                <div class="flex-shrink-0">
                                    <button class="btn btn-danger add-btn" data-bs-toggle="modal"
                                        data-bs-target="#AddDok"><i class="ri-add-line align-bottom me-1"></i> Upload
                                        Dokumen</button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-borderless align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th scope="col">File Name</th>
                                                    <th scope="col">Size</th>
                                                    <th scope="col">Tipe File</th>
                                                    <th scope="col">Tanggal Upload</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm">
                                                                <div
                                                                    class="avatar-title bg-soft-danger text-danger rounded fs-20">
                                                                    <i class="ri-image-2-fill"></i>
                                                                </div>
                                                            </div>
                                                            <div class="ms-3 flex-grow-1">
                                                                <h6 class="fs-15 mb-0">
                                                                    <a href="file/dokumen-user/"></a>
                                                                </h6>
                                                            </div>
                                                        </div>

                                                    <td></td>


                                                    <td>


                                                    </td>
                                                    <td></td>


                                                    <td>
                                                        <div class="dropdown">
                                                            <a href="javascript:void(0);" class="btn btn-light btn-icon"
                                                                id="dropdownMenuLink7" data-bs-toggle="dropdown"
                                                                aria-expanded="true">
                                                                <i class="ri-equalizer-fill"></i>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end"
                                                                aria-labelledby="dropdownMenuLink7">

                                                                <li><a class="dropdown-item" href="file/dokumen-user/"><i
                                                                            class="ri-download-2-fill me-2 align-middle"></i>Download</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" data-bs-toggle="modal"
                                                                        data-bs-target=""><i
                                                                            class="ri-delete-bin-5-line me-2 align-middle"></i>Delete</a>


                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

            <!--end col-->



            <div class="modal fade zoomIn" id="AddDok" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered ">

                    <div class="modal-content border-0">
                        <div class="modal-header p-3 bg-soft-info">
                            <h5 class="modal-title" id="exampleModalLabel">Add Form SOP</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                id="close-modal"></button>
                        </div>
                        <form action="function/insert_dokumen.php" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="row g-3">



                                    <div class="col-lg-12">
                                        <label for="date-field" class="form-label">URL File Form SOP</label>
                                        <input type="text" class="form-control" name="idnik" value="" hidden>
                                        <input type="file" class="form-control" name="file_dok" required />
                                    </div>


                                </div>

                            </div>
                            <div class="modal-footer">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success" name="masukan" id="add-btn">Add
                                        Form SOP</button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="modal fade zoomIn" id="delete   " tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                id="btn-close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mt-2 text-center">
                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                    colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px">
                                </lord-icon>
                                <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                    <h4>Are you Sure ?</h4>
                                    <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this Records <br>
                                        <b></b> ?</p>
                                </div>
                            </div>
                            <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                                <a style="cursor: pointer;"
                                    onclick="location.href='function/delete_dokumen.php?aksi=delete&id=&uid=    ?>'"
                                    class="btn w-sm btn-danger">Yes, Delete It!</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php $__env->stopSection(); ?>

        <?php $__env->startSection('script'); ?>
            <script src="assets/js/pages/profile-setting.init.js"></script>
        <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\eip-it\resources\views/edit-profile.blade.php ENDPATH**/ ?>