@extends('layouts.master')
@section('title')
    Project
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ckeditor.css') }}" rel="stylesheet">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Project
        @endslot
        @slot('title')
            Edit Project
        @endslot
    @endcomponent

    <form action="{{ route('projects.update', ['id' => $project->id_project]) }}" method="POST" id="createForm"
        enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="project-title-input">Project Title</label>
                            <input type="text" class="form-control" id="project-title-input" name="title"
                                placeholder="Enter project title" value="{{ $project->title ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Project Description</label>
                            <textarea class="form-control" name="description" id="ckeditor-classic" rows="5">{{ $project->description ?? '' }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-3 mb-lg-0">
                                    <label for="choices-status-input" class="form-label">Status</label>
                                    <select class="form-select" data-choices id="choices-status-input" name="status">
                                        <option value="Open" {{ $project->status === 'Open' ? 'selected' : '' }}>Open
                                        </option>
                                        <option value="On Progress"
                                            {{ $project->status === 'On Progress' ? 'selected' : '' }}>On Progress</option>
                                        <option value="Closed" {{ $project->status === 'Closed' ? 'selected' : '' }}>Closed
                                        </option>
                                        <option value="Rejected" {{ $project->status === 'Rejected' ? 'selected' : '' }}>
                                            Canceled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div>
                                    <label for="datepicker-deadline-input" class="form-label">Start Date</label>
                                    <input type="text" class="form-control" id="datepicker-deadline-input"
                                        name="start_date" placeholder="Enter due date" data-provider="flatpickr"
                                        value="{{ $project->start_date ?? '' }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div>
                                    <label for="datepicker-deadline-input" class="form-label">Due Date</label>
                                    <input type="text" class="form-control" id="datepicker-deadline-input"
                                        name="due_date" placeholder="Enter due date" data-provider="flatpickr"
                                        value="{{ $project->due_date ?? '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-4">
                                <div>
                                    <label for="choices-status-input" class="form-label">Categories</label>
                                    <select class="form-select" data-choices id="choices-status-input" name="categories">
                                        <option value="">Enter categories</option>
                                        <option
                                            value="Hardware"{{ $project->categories === 'Hardware' ? ' selected' : '' }}>
                                            Hardware</option>
                                        <option value="Network"{{ $project->categories === 'Network' ? ' selected' : '' }}>
                                            Network</option>
                                        <option
                                            value="Printer & Scanner"{{ $project->categories === 'Printer & Scanner' ? ' selected' : '' }}>
                                            Printer & Scanner</option>
                                        <option
                                            value="Software"{{ $project->categories === 'Software' ? ' selected' : '' }}>
                                            Software</option>
                                        <option
                                            value="Programming"{{ $project->categories === 'Programming' ? ' selected' : '' }}>
                                            Programming</option>
                                        <option
                                            value="Infrastruktur"{{ $project->categories === 'Infrastruktur' ? ' selected' : '' }}>
                                            Infrastruktur</option>
                                        <option value="CCTV"{{ $project->categories === 'CCTV' ? ' selected' : '' }}>CCTV
                                        </option>
                                        <option value="Server"{{ $project->categories === 'Server' ? ' selected' : '' }}>
                                            Server</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div>
                                    <label class="form-label">Cost</label>
                                    <input type="text" class="form-control" id="priceInput" name="cost"
                                        value="{{ $project->cost ?: '' }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div>
                                    <label for="file" class="form-label">Attached file</label>
                                    <input type="file" id="file" class="form-control" name="file" />
                                    @if ($project->file)
                                        <p class="mt-2">File saat ini: {{ $project->file }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Isi form input lainnya -->

            </div>
            <!-- end col -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Members</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <div class="avatar-group" id="teamMembers">
                                @foreach ($selectedUsers as $user)
                                    <a href="javascript:void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                                        data-bs-trigger="hover" data-bs-placement="top" data-name="{{ $user->nama }}">
                                        <div class="avatar-xxs">
                                            <img src="{{ $user->file_foto ? asset('uploads/uploads/' . $user->file_foto) : asset('uploads/uploads/default.jpg') }}"
                                                alt="" class="rounded-circle img-fluid">
                                        </div>
                                        <input type="hidden" name="selectedMembers[]" value="{{ $user->idnik }}">
                                        <button type="button" class="btn btn-light btn-sm remove-button">Remove</button>
                                    </a>
                                @endforeach
                            </div>
                            <input type="hidden" name="memberIds[]" id="memberIds" value="">
                            <button type="button" class="btn btn-success mt-3" data-bs-toggle="modal"
                                data-bs-target="#inviteMembersModal">Invite Members</button>
                        </div>
                    </div>
                </div>

                <div class="text-end mb-4" form="createForm">
                    <a href="{{ route('projects.show') }}" class="btn btn-danger w-sm">Cancel</a>
                    <button type="submit" class="btn btn-success w-sm" id="createForm">Update</button>
                </div>
            </div>

            <!-- end col -->
        </div>
        <!-- end row -->
    </form>

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
                            @foreach ($users as $user)
                                <div class="d-flex align-items-center member-item" data-name="{{ $user->nama }}">
                                    <div class="avatar-xs flex-shrink-0 me-3">
                                        @if ($user->file_foto)
                                            <img src="{{ asset('uploads/uploads/' . $user->file_foto) }}" alt=""
                                                class="img-fluid rounded-circle">
                                        @else
                                            <img src="{{ asset('uploads/uploads/default.jpg') }}" alt=""
                                                class="img-fluid rounded-circle">
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="fs-13 mb-0"><a href="#" class="text-body d-block"
                                                data-idnik="{{ $user->idnik }}">{{ $user->nama }}</a></h5>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <button type="button" class="btn btn-light btn-sm add-button">Add</button>
                                    </div>
                                </div>
                                <input type="hidden" name="idnik[]" value="{{ $user->idnik }}">
                                <!-- end member item -->
                            @endforeach
                        </div>
                        <!-- end list -->
                    </div>
                </div>
            </div>

            <!-- end modal-content -->
        </div>
        <!-- modal-dialog -->
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/@ckeditor/@ckeditor.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/libs/choices.js/choices.js.min.js') }}"></script>
    <script src="assets/js/pages/project-create.init.js"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi format Rupiah pada input harga
            var cleave = new Cleave('#priceInput', {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand',
                prefix: 'Rp ',
            });

            // Set nilai input cost jika nilai $project->cost ada
            var costInput = document.querySelector('#priceInput');
            costInput.value = '{{ $project->cost ? 'Rp ' . number_format($project->cost, 0, ',', '.') : '' }}';

            // Fungsi untuk menghapus format Rupiah dan tanda baca, hanya menyisakan integer
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
        // Initialize Flatpickr
        flatpickr('#datepicker-deadline-input', {
            // Add any Flatpickr options if needed
        });

        ClassicEditor
            .create(document.querySelector('#ckeditor-classic'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });

        // Handle form submission
        document.getElementById('createForm').addEventListener('click', function() {
            document.getElementById('create').submit();
        });

        document.getElementById('createFormButton').addEventListener('click', function() {
            document.getElementById('createForm').submit();
        });
    </script>
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


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the teamMembers container
            var teamMembersContainer = document.getElementById('teamMembers');

            // Get all the "Remove" button elements in the container
            var removeButtons = teamMembersContainer.getElementsByClassName('remove-button');

            // Add click event listener to each "Remove" button
            for (var i = 0; i < removeButtons.length; i++) {
                removeButtons[i].addEventListener('click', function() {
                    // Get the parent element of the remove button (i.e., the member item)
                    var memberItem = this.parentNode;

                    // Remove the member item from the teamMembers container
                    memberItem.parentNode.removeChild(memberItem);

                    // Remove the title attribute from the member item
                    memberItem.removeAttribute('title');

                    // Update the hidden input value with the updated memberIds array
                    updateMemberIds();
                });
            }

            // Add click event listener to the "Add" button in the inviteMembersModal
            var addButtons = document.getElementsByClassName('add-button');
            var selectedMembersInput = document.getElementById('selectedMembers');

            for (var i = 0; i < addButtons.length; i++) {
                addButtons[i].addEventListener('click', function() {
                    // Get the relevant data from the member item
                    var memberIdnik = this.parentNode.parentNode.querySelector('.fs-13 a').getAttribute(
                        'data-idnik');
                    var memberName = this.parentNode.parentNode.getAttribute('data-name');

                    // Check if the member is already invited
                    var existingMembers = teamMembersContainer.getElementsByClassName('avatar-group-item');
                    var isExistingMember = false;

                    for (var j = 0; j < existingMembers.length; j++) {
                        var existingMemberInput = existingMembers[j].querySelector(
                            'input[name="selectedMembers[]"]');
                        if (existingMemberInput.value === memberIdnik) {
                            isExistingMember = true;
                            break;
                        }
                    }

                    // If the member is not already invited, add them
                    if (!isExistingMember) {
                        // Create a new member item
                        var newMemberItem = document.createElement('a');
                        newMemberItem.classList.add('avatar-group-item');
                        newMemberItem.setAttribute('data-bs-toggle', 'tooltip');
                        newMemberItem.setAttribute('data-bs-trigger', 'hover');
                        newMemberItem.setAttribute('data-bs-placement', 'top');
                        newMemberItem.setAttribute('title', memberName);

                        // Create the avatar image
                        var avatarImage = document.createElement('div');
                        avatarImage.classList.add('avatar-xxs');
                        var avatarImgElement = document.createElement('img');
                        avatarImgElement.setAttribute('src', '{{ asset('uploads/uploads/default.jpg') }}');
                        avatarImgElement.setAttribute('alt', '');
                        avatarImgElement.classList.add('rounded-circle', 'img-fluid');
                        avatarImage.appendChild(avatarImgElement);

                        // Create the hidden input for selectedMembers
                        var selectedMemberInput = document.createElement('input');
                        selectedMemberInput.setAttribute('type', 'hidden');
                        selectedMemberInput.setAttribute('name', 'selectedMembers[]');
                        selectedMemberInput.setAttribute('value', memberIdnik);

                        // Create the "Remove" button
                        var removeButton = document.createElement('button');
                        removeButton.setAttribute('type', 'button');
                        removeButton.classList.add('btn', 'btn-light', 'btn-sm', 'remove-button');
                        removeButton.textContent = 'Remove';

                        // Add click event listener to the "Remove" button
                        removeButton.addEventListener('click', function() {
                            // Remove the new member item from the teamMembers container
                            this.parentNode.parentNode.removeChild(this.parentNode);

                            // Remove the title attribute from the member item
                            this.parentNode.removeAttribute('title');

                            // Update the hidden input value with the updated memberIds array
                            updateMemberIds();
                        });

                        // Append the elements to the new member item
                        newMemberItem.appendChild(avatarImage);
                        newMemberItem.appendChild(selectedMemberInput);
                        newMemberItem.appendChild(removeButton);

                        // Append the new member item to the teamMembers container
                        teamMembersContainer.appendChild(newMemberItem);

                        // Hide the member name from the options in the inviteMembersModal
                        var inviteModal = document.getElementById('inviteMembersModal');
                        var options = inviteModal.querySelectorAll('.member-item');
                        for (var k = 0; k < options.length; k++) {
                            if (options[k].getAttribute('data-name') === memberName) {
                                options[k].style.display = 'none';
                            }
                        }

                        // Hide the member name from the choices in the choices-member-input
                        var choicesContainer = document.getElementById('choices-member-input');
                        var choicesOptions = choicesContainer.getElementsByClassName('member-item');
                        for (var l = 0; l < choicesOptions.length; l++) {
                            if (choicesOptions[l].getAttribute('data-name') === memberName) {
                                choicesOptions[l].style.display = 'none';
                            }
                        }

                        // Update the hidden input value with the updated memberIds array
                        updateMemberIds();
                    }
                });
            }

            // Function to update the hidden input value with the updated memberIds array
            function updateMemberIds() {
                // Get all the hidden input elements for selected members
                var selectedMembersInputs = teamMembersContainer.querySelectorAll(
                    'input[name="selectedMembers[]"]');

                // Get the memberIds array from the inputs
                var memberIds = Array.from(selectedMembersInputs).map(function(input) {
                    return input.value;
                });

                // Update the hidden input value with the memberIds array
                selectedMembersInput.value = memberIds.join(',');
            }
        });

        // Set the titles for existing selected members on page load
        document.addEventListener('DOMContentLoaded', function() {
            var teamMembersContainer = document.getElementById('teamMembers');
            var memberItems = teamMembersContainer.getElementsByClassName('avatar-group-item');

            for (var i = 0; i < memberItems.length; i++) {
                var memberName = memberItems[i].getAttribute('data-name');
                memberItems[i].setAttribute('title', memberName);
            }
        });
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
@endsection
