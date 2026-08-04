@extends('components.layout')

@section('content')

<!-- Custom Modern Styling for Dark Green, Golden Yellow & White Theme -->
<style>
    :root {
        --bs-dark-green: #1b4332;
        --bs-medium-green: #2d6a4f;
        --bs-light-green-bg: #f4f7f5;
        --bs-golden-yellow: #ffb703;
        --bs-golden-yellow-hover: #e0a102;
    }

    body {
        background-color: var(--bs-light-green-bg);
    }

    /* Theme Buttons */
    .btn-theme-primary {
        background-color: var(--bs-dark-green);
        color: #ffffff;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-theme-primary:hover, .btn-theme-primary:focus {
        background-color: var(--bs-medium-green);
        color: #ffffff;
    }

    .btn-theme-accent {
        background-color: var(--bs-golden-yellow);
        color: #1b4332;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-theme-accent:hover, .btn-theme-accent:focus {
        background-color: var(--bs-golden-yellow-hover);
        color: #1b4332;
    }

    /* Card and Table Modernization */
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(27, 67, 50, 0.05);
    }

    .table-custom thead th {
        background-color: var(--bs-dark-green);
        color: #ffffff;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        border: none;
        padding: 14px 16px;
    }

    .table-custom tbody tr {
        transition: background-color 0.2s ease;
    }

    .table-custom tbody tr:hover {
        background-color: rgba(255, 183, 3, 0.08);
    }

    /* Badges & Pagination */
    .badge-custom-success {
        background-color: rgba(45, 106, 79, 0.12) !important;
        color: var(--bs-medium-green) !important;
        font-weight: 600;
    }

    .pagination .page-item .page-link {
        color: var(--bs-dark-green);
        border-radius: 6px;
        margin: 0 3px;
        border: 1px solid #dee2e6;
    }

    .pagination .page-item.active .page-link {
        background-color: var(--bs-dark-green);
        border-color: var(--bs-dark-green);
        color: #ffffff;
    }

    /* Modal Styling */
    .modal-content {
        border: none;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .modal-header-custom {
        background-color: var(--bs-dark-green);
        color: #ffffff;
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
    }
    
    .modal-header-custom .btn-close {
        filter: brightness(0) invert(1);
    }
</style>

<!-- Page Header / Action Bar -->
<div class="row mb-4 align-items-center">
    <div class="col-sm-6">
        <h3 class="fw-bold mb-1" style="color: var(--bs-dark-green);">User Management</h3>
        <p class="text-muted text-sm mb-0">Manage system users, divisions, and role assignments seamlessly.</p>
    </div>
    <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
        <button data-bs-toggle="modal" data-bs-target="#showModal" class="btn btn-theme-accent btn-label waves-effect waves-light rounded-pill shadow-sm">
            <i class="ri-add-fill align-middle rounded-pill fs-16 me-2"></i>
            Create New User
        </button>
    </div>
</div>

<!-- Main Content Card -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body p-4">
                <div class="listjs-table" id="customerList">
                    
                    <!-- Search / Filter placeholder area can go here if needed -->

                    <div class="table-responsive mt-2 mb-3">
                        <table class="table align-middle table-nowrap table-custom" id="customerTable">
                            <thead>
                                <tr>
                                    <th class="d-none">ID</th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Email</th>
                                    <th>User Type</th>
                                    <th>Division</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach($user as $users)
                                <tr>
                                    <td class="d-none">{{$users->id}}</td>
                                    <td class="customer_name fw-semibold text-dark">{{$users->name}}</td>
                                    <td class="email text-muted">{{$users->position}}</td>
                                    <td class="phone text-muted">{{$users->email}}</td>
                                    <td class="status">
                                        <span class="badge badge-custom-success text-uppercase px-2.5 py-1.5 rounded-pill">
                                            {{$users->position}}
                                        </span>
                                    </td>
                                    <td class="division">
                                        <span class="fw-medium">{{$users->division_name}}</span> 
                                        <span class="text-muted fs-12">({{$users->division_short_name}})</span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <button class="btn btn-sm btn-outline-success edit-item-btn px-3 rounded-pill" data-bs-toggle="modal" data-bs-target="#showModal" data-id="{{ $users->id }}" data-name="{{ $users->name }}" data-position="{{ $users->position }}" data-email="{{ $users->email }}" data-utype="{{ $users->usertype }}" data-division="{{ $users->divisionID }}" data-sector="{{$users->sectorID}}">
                                                <i class="ri-pencil-line align-bottom me-1"></i> Edit
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <!-- Pagination Container -->
                        <nav class="mt-4">
                            <ul class="pagination justify-content-center" id="pagination"></ul>
                        </nav>
                    </div>

                </div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div><!-- end row -->

<!-- User Modal (Create / Edit) -->
<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-header-custom p-4">
                <h5 class="modal-title fw-bold" id="exampleModalLabel">User Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            
            <form action="{{route('storeuser')}}" method="POST" id="userform">
                @csrf
                <div class="modal-body p-4">
                    @if ($errors->any())
                    <div class="alert alert-danger rounded-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="mb-3" id="modal-id" style="display: none;">
                        <label for="id-field" class="form-label fw-semibold">ID</label>
                        <input type="text" id="id-field" name="id" class="form-control" placeholder="ID" readonly>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name-field" class="form-label fw-semibold">Name</label>
                            <input type="text" id="name-field" name="name" class="form-control shadow-none" placeholder="Enter Full Name" required>
                            <div class="invalid-feedback">Please enter a name.</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="position-field" class="form-label fw-semibold">Position</label>
                            <input type="text" id="position-field" name="position" class="form-control shadow-none" placeholder="Enter Position" required>
                            <div class="invalid-feedback">Please enter a position.</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email-field" class="form-label fw-semibold">Email Address</label>
                        <input type="email" id="email-field" name="email" class="form-control shadow-none" placeholder="Enter Email Address" required>
                        <div class="invalid-feedback">Please enter an email.</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sector-field" class="form-label fw-semibold">Sector</label>
                            <select class="form-select shadow-none" name="sector" id="sector-field">
                                <option selected value="">--Choose Sector--</option>
                                @foreach($sector as $sect)
                                <option value="{{$sect->id}}">{{$sect->sector_long_name}} ({{$sect->sector_short_name}})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="divi-field" class="form-label fw-semibold">Division</label>
                            <select class="form-select shadow-none" name="division" id="divi-field">
                                @foreach($divisions as $sect)
                                <option value="{{$sect->id}}">{{$sect->division_name}} ({{$sect->division_short_name}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="utype" class="form-label fw-semibold">User Type</label>
                            <select class="form-select shadow-none" name="usertype" id="utype">
                                <option selected value="">--Choose User Type--</option>
                                @foreach($utypes as $utype)
                                <option value="{{$utype->id}}">{{$utype->position}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password-field" class="form-label fw-semibold">Password</label>
                            <input type="password" id="password-field" name="password" class="form-control shadow-none" placeholder="Enter Password">
                            <div class="invalid-feedback">Please enter a password.</div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-theme-primary rounded-pill px-4">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- New User Type Modal -->
<div class="modal fade" id="newTypeModal" tabindex="-1" aria-labelledby="newTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title fw-bold" id="newTypeModalLabel">Add New User Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="newTypeForm" method="POST" action="{{ route('newusertype') }}">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="newUserType" class="form-label fw-semibold">User Type Name</label>
                        <input type="text" class="form-control shadow-none" id="newUserType" name="newUserType" placeholder="Enter new user type" required>
                        <div class="invalid-feedback">Please enter a user type name.</div>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-theme-accent rounded-pill px-4">Add User Type</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const rowsPerPage = 10;
        const table = document.getElementById("customerTable");
        const rows = table.querySelectorAll("tbody tr");
        const pagination = document.getElementById("pagination");

        let currentPage = 1;
        const totalPages = Math.ceil(rows.length / rowsPerPage);

        function displayRows(page) {
            rows.forEach((row, index) => {
                row.style.display = (index >= (page - 1) * rowsPerPage && index < page * rowsPerPage) ? "" : "none";
            });
        }

        function setupPagination() {
            pagination.innerHTML = "";
            for (let i = 1; i <= totalPages; i++) {
                const li = document.createElement("li");
                li.className = "page-item";
                if (i === currentPage) {
                    li.classList.add("active");
                }
                const a = document.createElement("a");
                a.className = "page-link";
                a.href = "#";
                a.innerText = i;

                a.addEventListener("click", function(e) {
                    e.preventDefault();
                    currentPage = i;
                    displayRows(currentPage);
                    setupPagination();
                });

                li.appendChild(a);
                pagination.appendChild(li);
            }
        }

        if(totalPages > 0) {
            displayRows(currentPage);
            setupPagination();
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var userModal = document.getElementById("showModal");

        userModal.addEventListener("show.bs.modal", function(event) {
            var button = event.relatedTarget;
            if (!button) return;

            document.getElementById("id-field").value = button.getAttribute("data-id") || '';
            document.getElementById("name-field").value = button.getAttribute("data-name") || '';
            document.getElementById("position-field").value = button.getAttribute("data-position") || '';
            document.getElementById("email-field").value = button.getAttribute("data-email") || '';
            document.getElementById("utype").value = button.getAttribute("data-utype") || '';
            document.getElementById("divi-field").value = button.getAttribute("data-division") || '';
            document.getElementById("sector-field").value = button.getAttribute("data-sector") || '';
        });

        const inputsector = document.getElementById('sector-field');
        const inputdivision = document.getElementById('divi-field');
        const division = {!! json_encode($divisions) !!};

        inputsector.addEventListener('change', function () {
            const programID = this.value;
            inputdivision.innerHTML = '<option value="">--Select Division--</option>';

            division.forEach(div => {
                if(div.sectorID == programID){
                    let option = document.createElement('option');
                    option.value = div.id;
                    option.textContent = div.division_name + " (" + div.division_short_name + ")";
                    inputdivision.appendChild(option);
                }
            });
        });

        document.getElementById('utype').addEventListener('change', function() {
            if (this.value === 'newtype') {
                var newTypeModal = new bootstrap.Modal(document.getElementById('newTypeModal'));
                newTypeModal.show();
            }
        });
    });
</script>
@endsection