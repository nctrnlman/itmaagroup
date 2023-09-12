
<?php $__env->startSection('title'); ?>
    Project
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('assets/libs/dropzone/dropzone.min.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Project
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Create Project
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <div>
        <form action="<?php echo e(route('projects.create')); ?>" method="POST" id="createForm" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="project-title-input">Project Title</label>
                                <input type="text" class="form-control" id="project-title-input" name="title"
                                    placeholder="Enter project title">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Project Description</label>
                                <textarea class="form-control" name="description"id="ckeditor-classic" rows="5"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3 mb-lg-0">
                                        <label for="choices-status-input" class="form-label">Status</label>
                                        <select class="form-select" data-choices id="choices-status-input" name="status">
                                            <option value="">Enter status</option>
                                            <option value="Open">Open</option>
                                            <option value="On Progress">On Progress</option>
                                            <option value="Closed">Closed</option>
                                            <option value="Rejected">Canceled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div>
                                        <label for="datepicker-deadline-input" class="form-label">Start Date</label>
                                        <input type="text" class="form-control" id="datepicker-deadline-input"
                                            name="start_date" placeholder="Enter due date" data-provider="flatpickr">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div>
                                        <label for="datepicker-deadline-input" class="form-label">Due Date</label>
                                        <input type="text" class="form-control" id="datepicker-deadline-input"
                                            name="due_date" placeholder="Enter due date" data-provider="flatpickr">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3    ">
                                <div class="col-lg-4">
                                    <div>
                                        <label for="choices-status-input" class="form-label">Categories</label>
                                        <select class="form-select" data-choices id="choices-status-input"
                                            name="categories">
                                            <option value="">Enter categories</option>
                                            <option value="Hardware">Hardware</option>
                                            <option value="Network">Network</option>
                                            <option value="Printer & Scanner">Printer & Scanner</option>
                                            <option value="Software">Software</option>
                                            <option value="Programming">Programming</option>
                                            <option value="Infrastruktur">Infrastruktur</option>
                                            <option value="CCTV">CCTV</option>
                                            <option value="Server">Server</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div>
                                        <label class="form-label">Cost</label>
                                        <input type="text" class="form-control" id="priceInput" name="cost">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div>
                                        <label for="file" class="form-label">Attached file</label>
                                        <input type="file" id="file" class="form-control" name="file" />
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->


                    <!-- end card -->
                    <!-- end card -->

                    <!-- Isi form input lainnya -->

                </div>
                <!-- end col -->
                <div class="col-lg-4">
                    <!-- end card body -->


                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Members</h5>
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="avatar-group" id="teamMembers">
                                    <!-- Existing members -->
                                    
                                </div>
                                <input type="hidden" name="memberIds[]" id="memberIds" value="">
                                <button type="button" class="btn btn-success mt-3" data-bs-toggle="modal"
                                    data-bs-target="#inviteMembersModal">Invite Members</button>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>


                    <div class="text-end mb-4" form="createForm">
                        <a href="<?php echo e(route('projects.show')); ?>" class="btn btn-danger w-sm">Cancel</a>
                        <button type="submit" class="btn btn-success w-sm">Create</button>
                    </div>
                    <!-- end card -->
                </div>

                <!-- end col -->
            </div>

            <!-- end row -->
        </form>
    </div>

    <!-- HTML Modal -->
    <div class="modal fade" id="inviteMembersModal" tabindex="-1" aria-labelledby="inviteMembersModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-3 ps-4 bg-soft-success">
                    <h5 class="modal-title" id="inviteMembersModalLabel">Members</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Bagian HTML -->
                    <div class="search-box mb-3">
                        <input type="text" class="form-control bg-light border-light search-input"
                            for="choices-member-input" placeholder="Search here...">
                        <i class="ri-search-line search-icon"></i>
                    </div>

                    <div class="mx-n4 px-4" data-simplebar style="max-height: 225px;">
                        <div class="vstack gap-3" data-choices id="choices-member-input">
                            <!-- List of all members -->
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="d-flex align-items-center member-item" data-name="<?php echo e($user->nama); ?>">
                                    <div class="avatar-xs flex-shrink-0 me-3">
                                        <?php if($user->file_foto): ?>
                                            <img src="<?php echo e(asset('uploads/uploads/' . $user->file_foto)); ?>" alt=""
                                                class="img-fluid rounded-circle">
                                        <?php else: ?>
                                            <img src="<?php echo e(asset('uploads/uploads/default.jpg')); ?>" alt=""
                                                class="img-fluid rounded-circle">
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="fs-13 mb-0"><a href="#" class="text-body d-block"
                                                data-idnik="<?php echo e($user->idnik); ?>"><?php echo e($user->nama); ?></a></h5>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <button type="button" class="btn btn-light btn-sm add-button">Add</button>
                                    </div>
                                </div>
                                <input type="hidden" name="idnik[]" value="<?php echo e($user->idnik); ?>">
                                <!-- end member item -->
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <!-- end list -->
                    </div>
                </div>
            </div>
            <!-- end modal-content -->
        </div>
        <!-- modal-dialog -->
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('assets/libs/@ckeditor/@ckeditor.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/libs/dropzone/dropzone.min.js')); ?>"></script>
    <script src="assets/js/pages/project-create.init.js"></script>
    <script src="<?php echo e(asset('assets/libs/choices.js/choices.js.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi format Rupiah pada input harga
            var cleave = new Cleave('#priceInput', {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand',
                prefix: 'Rp ',
            });

            // Set nilai default pada input harga
            var priceInput = document.querySelector('#priceInput');
            priceInput.value = 'Rp 0';

            // Fungsi untuk menghapus format Rupiah sebelum mengirim data ke backend
            function removeRupiahFormat(value) {
                return value.replace(/[^\d]/g, ''); // Menghapus semua karakter non-digit
            }

            // Menambahkan event listener pada saat form submit
            var form = document.querySelector('#createForm');
            form.addEventListener('submit', function(event) {
                var costInput = document.querySelector('#priceInput');
                costInput.value = removeRupiahFormat(costInput
                    .value); // Menghapus format Rupiah sebelum submit
            });
        });
    </script>
    <script>
        var sessionIdnik = <?php echo json_encode(session('user')->idnik); ?>;
    </script>
    <script>
        // Get the modal and teamMembers container
        var inviteModal = document.getElementById('inviteMembersModal');
        var teamMembersContainer = document.getElementById('teamMembers');

        // Get all the "Add" button elements in the modal
        var addButtons = inviteModal.getElementsByClassName('add-button');

        // Array to store the member IDs
        var memberIds = [];



        function getSessionIdnik() {
            return sessionIdnik;
        }

        // Function to update the hidden input value with the memberIds array
        function updateMemberIdsInput() {
            var memberIdsInput = document.getElementById('memberIds');
            memberIdsInput.value = memberIds.join(',');

            if (memberIds.length > 0) {
                teamMembersContainer.innerHTML = '<h1>No member selected</h1>';
            } else {
                teamMembersContainer.innerHTML = ''; // Clear the container
            }
        }

        // Automatically add the session idnik to the memberIds array on page load
        memberIds.push(getSessionIdnik());

        // Add click event listener to each "Add" button
        for (var i = 0; i < addButtons.length; i++) {
            addButtons[i].addEventListener('click', function() {
                // Check if the user is already a team member
                var userName = this.parentNode.parentNode.querySelector('.fs-13 a').innerText;
                var userIdnik = this.parentNode.parentNode.querySelector('.fs-13 a').getAttribute('data-idnik');
                var existingMembers = teamMembersContainer.getElementsByClassName('avatar-group-item');
                var isExistingMember = false;

                for (var j = 0; j < existingMembers.length; j++) {
                    var memberName = existingMembers[j].getAttribute('title');
                    if (memberName === userName) {
                        isExistingMember = true;
                        break;
                    }
                }

                // If the user is not already a team member, add them
                if (!isExistingMember) {
                    // Get the user's avatar image source and name
                    var avatarSrc = this.parentNode.parentNode.querySelector('.avatar-xs img').getAttribute('src');

                    // Create a new member item
                    var memberItem = document.createElement('a');
                    memberItem.classList.add('avatar-group-item');
                    memberItem.setAttribute('data-bs-toggle', 'tooltip');
                    memberItem.setAttribute('data-bs-trigger', 'hover');
                    memberItem.setAttribute('data-bs-placement', 'top');
                    memberItem.setAttribute('title', userName);

                    // Create the avatar image
                    var avatarImage = document.createElement('div');
                    avatarImage.classList.add('avatar-xs');

                    // Set the avatar image source
                    var avatarImgElement = document.createElement('img');
                    avatarImgElement.setAttribute('src', avatarSrc);
                    avatarImgElement.setAttribute('alt', '');
                    avatarImgElement.classList.add('rounded-circle', 'img-fluid');

                    // Append the avatar image to the member item
                    avatarImage.appendChild(avatarImgElement);
                    memberItem.appendChild(avatarImage);

                    // Create the "Remove" button
                    var removeButton = document.createElement('button');
                    removeButton.type = 'button';
                    removeButton.classList.add('btn', 'btn-light', 'btn-sm', 'remove-button');
                    removeButton.textContent = 'Remove';

                    // Add click event listener to the "Remove" button
                    removeButton.addEventListener('click', function() {
                        teamMembersContainer.removeChild(memberItem); // Remove the member item
                        memberIds = memberIds.filter(id => id !==
                            userIdnik); // Remove the member's IDNIK from the array
                        updateMemberIdsInput(); // Update the hidden input value
                    });

                    // Append the "Remove" button to the member item
                    memberItem.appendChild(removeButton);

                    // Append the member item to the teamMembers container
                    teamMembersContainer.appendChild(memberItem);

                    // Add the member's IDNIK to the memberIds array
                    memberIds.push(userIdnik);

                    // Update the hidden input value with the memberIds array
                    updateMemberIdsInput();
                }

                // Close the modal
                var modal = bootstrap.Modal.getInstance(inviteModal);
                modal.hide();
            });
        }

        // Function to update the hidden input value with the memberIds array
        function updateMemberIdsInput() {
            var memberIdsInput = document.getElementById('memberIds');
            memberIdsInput.value = memberIds.join(',');

        }
    </script>
    <script>
        var searchInput = document.querySelector('.search-box .search-input');
        var memberContainer = document.querySelector('.vstack[data-choices]');

        searchInput.addEventListener('input', function() {
            var searchValue = this.value.trim().toLowerCase();
            var memberItems = memberContainer.querySelectorAll('.member-item');

            var matchingItems = [];
            var nonMatchingItems = [];

            memberItems.forEach(function(memberItem) {
                var memberNameElement = memberItem.querySelector('a');
                var memberName = memberNameElement ? memberNameElement.innerText.toLowerCase() : '';
                var dataName = memberItem.getAttribute('data-name').toLowerCase();

                if (memberName.includes(searchValue) || dataName.includes(searchValue)) {
                    matchingItems.push(memberItem);
                } else {
                    nonMatchingItems.push(memberItem);
                }
            });

            // Clear the existing items in the member container
            memberContainer.innerHTML = '';

            // Append matching items first
            matchingItems.forEach(function(item) {
                memberContainer.appendChild(item);
            });

            // Append non-matching items next
            nonMatchingItems.forEach(function(item) {
                memberContainer.appendChild(item);
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var projectSelectElement = document.querySelector('#choices-member-input');
            var projectChoices = new Choices(projectSelectElement, {
                searchEnabled: true,
            });
        });
    </script>
    <script src="<?php echo e(asset('assets/libs/flatpickr/flatpickr.min.js')); ?>"></script>
    <script>
        // Initialize Flatpickr
        flatpickr('#datepicker-deadline-input', {
            // Add any Flatpickr options if needed
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ptma5063/public_html/eip.maagroup.co.id/ticket/resources/views/project/index.blade.php ENDPATH**/ ?>