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

    /* Cards and Table Modernization */
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

    .sector-row {
        background-color: rgba(45, 106, 79, 0.08) !important;
        border-left: 4px solid var(--bs-dark-green);
    }

    .division-row {
        transition: background-color 0.2s ease;
    }

    .division-row:hover {
        background-color: rgba(255, 183, 3, 0.08);
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

<!-- Page Header & Action Bar -->
<div class="row mb-4 align-items-center">
    <div class="col-sm-6">
        <h3 class="fw-bold mb-1" style="color: var(--bs-dark-green);">Sector & Division Management</h3>
        <p class="text-muted text-sm mb-0">Organize organization sectors and their corresponding divisions effectively.</p>
    </div>
    <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
        <button data-bs-toggle="modal" data-bs-target="#showModal" class="btn btn-theme-accent btn-label waves-effect waves-light rounded-pill shadow-sm">
            <i class="ri-add-fill align-middle rounded-pill fs-16 me-2"></i> Add Sector
        </button>
    </div>
</div>

<!-- Main Table Layout -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body p-4">
                <div class="listjs-table" id="customerList">
                    <div class="table-responsive table-card mt-2 mb-1">
                        <table class="table align-middle table-nowrap table-custom" id="customerTable">
                            <thead>
                                <tr>
                                    <th class="d-none">ID</th>
                                    <th>Sector & Division Structure</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach($sector as $sectors)
                                <!-- Sector Row -->
                                <tr class="sector-row">
                                    <td class="d-none">{{$sectors->id}}</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-between py-1">
                                            <span class="fw-bold fs-15" style="color: var(--bs-dark-green);">
                                                <i class="ri-building-line me-2"></i>{{$sectors->sector_long_name}} <span class="badge bg-success-subtle text-success fs-12 ms-1">({{$sectors->sector_short_name}})</span>
                                            </span>
                                            <div class="dropdown float-end">
                                                <a href="#" class="text-muted px-2 py-1" data-bs-toggle="dropdown">
                                                    <i class="ri-more-fill fs-16"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                                    <li>
                                                        <a class="dropdown-item py-2" href="#" data-bs-toggle="modal" data-bs-target="#divisionModal{{$sectors->id}}">
                                                            <i class="ri-add-line me-2 text-success"></i> Add Division
                                                        </a>
                                                        <a class="dropdown-item py-2" href="#"
                                                            data-id="{{ $sectors->id }}"
                                                            data-secname="{{ $sectors->sector_long_name }}"
                                                            data-secshortname="{{ $sectors->sector_short_name }}"
                                                            data-bs-toggle="modal" data-bs-target="#showModal">
                                                            <i class="ri-pencil-line me-2 text-warning"></i> Edit Sector
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                        <form action="{{ route('deletesector', $sectors->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Sector?');">
                                                            @csrf 
                                                            <button type="submit" class="dropdown-item py-2 text-danger">
                                                                <i class="ri-delete-bin-line me-2"></i> Delete Sector
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Divisions List under Sector -->
                                @foreach($divisions as $division)
                                    @if($division->sectorID === $sectors->id)
                                    <tr class="division-row">
                                        <td class="d-none"></td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-between ps-4 py-1">
                                                <span class="fs-13 text-muted ps-3 border-start border-2">
                                                    <i class="ri-arrow-turn-down-right me-2 text-secondary"></i>{{ $division->division_name }} <span class="badge bg-light text-dark fs-11">({{ $division->division_short_name }})</span>
                                                </span>
                                                <div class="dropdown">
                                                    <a href="#" class="text-muted px-2 py-1" data-bs-toggle="dropdown">
                                                        <i class="ri-more-fill fs-16"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                                        <li>
                                                            <a class="dropdown-item py-2" href="#"
                                                                data-divid="{{ $division->id }}"
                                                                data-sectorid="{{ $division->sectorID }}"
                                                                data-divisionname="{{ $division->division_name }}"
                                                                data-divisionshortname="{{ $division->division_short_name }}"
                                                                data-bs-toggle="modal" data-bs-target="#divisionModals">
                                                                <i class="ri-pencil-line me-2 text-warning"></i> Edit Division
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <form action="{{ route('deletdivision', $division->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Division?');">
                                                                @csrf
                                                                <button type="submit" class="dropdown-item py-2 text-danger">
                                                                    <i class="ri-delete-bin-line me-2"></i> Delete Division
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div><!-- end row -->

<!-- ================= NEW/EDIT SECTOR MODAL ================= -->
<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-header-custom p-4">
                <h5 class="modal-title fw-bold" id="exampleModalLabel">Sector Configuration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <form action="{{route('storesector')}}" method="POST" id="sectorform">
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
                        <label for="secid-field" class="form-label fw-semibold">ID</label>
                        <input type="text" id="secid-field" name="id" class="form-control" placeholder="ID" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="secname-field" class="form-label fw-semibold">Sector Name <span class="text-danger">*</span></label>
                        <input type="text" id="secname-field" name="secname" class="form-control shadow-none" placeholder="Enter Sector Name" required>
                        <div class="invalid-feedback">Please enter a name.</div>
                    </div>

                    <div class="mb-3">
                        <label for="secshortname-field" class="form-label fw-semibold">Sector Short Name <span class="text-danger">*</span></label>
                        <input type="text" id="secshortname-field" name="secshortname" class="form-control shadow-none" placeholder="ex. OMIN" required>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-theme-primary rounded-pill px-4">Save Sector</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= ADD DIVISION MODALS ================= -->
<div>
    @foreach($sector as $sectors)
    <form action="{{ route('storedivision') }}" method="POST">
        @csrf
        <div class="modal fade" id="divisionModal{{$sectors->id}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header modal-header-custom p-4">
                        <h5 class="modal-title fw-bold">Add Division to {{$sectors->sector_long_name}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <input type="text" name="sectorID" value="{{$sectors->id}}" hidden>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Division Name <span class="text-danger">*</span></label>
                            <input type="text" name="division_name" class="form-control shadow-none mb-2" placeholder="Enter Division Name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Division Short Name <span class="text-danger">*</span></label>
                            <input type="text" name="division_short_name" class="form-control shadow-none" placeholder="Enter Division Short Name" required>
                        </div>
                    </div>
                    <div class="modal-footer bg-light px-4 py-3">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-theme-primary rounded-pill px-4" name="action" value="division">Save Division</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endforeach
</div>

<!-- ================= EDIT DIVISION MODAL ================= -->
<div>
    <form action="{{ route('storedivision') }}" method="POST">
        @csrf
        <div class="modal fade" id="divisionModals" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header modal-header-custom p-4">
                        <h5 class="modal-title fw-bold">Edit Division</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <input type="text" id="divisionID-field" name="divID" hidden>
                        <input type="text" id="sectorID-field" name="sectorID" hidden>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Division Name <span class="text-danger">*</span></label>
                            <input type="text" id="divisionname-field" name="division_names" class="form-control shadow-none mb-2" placeholder="Enter Division Name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Division Short Name <span class="text-danger">*</span></label>
                            <input type="text" id="divisionshortname-field" name="division_short_names" class="form-control shadow-none" placeholder="Enter Division Short Name" required>
                        </div>
                    </div>
                    <div class="modal-footer bg-light px-4 py-3">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-theme-primary rounded-pill px-4" name="action" value="division">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal Control Scripts -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var userModal = document.getElementById("showModal");
        var divisionModal = document.getElementById("divisionModals");

        if(userModal) {
            userModal.addEventListener("show.bs.modal", function(event) {
                var button = event.relatedTarget;
                if(!button) return;

                document.getElementById("secid-field").value = button.getAttribute("data-id") || '';
                document.getElementById("secname-field").value = button.getAttribute("data-secname") || '';
                document.getElementById("secshortname-field").value = button.getAttribute("data-secshortname") || '';
            });
        }

        if(divisionModal) {
            divisionModal.addEventListener("show.bs.modal", function(event) {
                var button = event.relatedTarget;
                if(!button) return;
                
                document.getElementById("divisionID-field").value = button.getAttribute("data-divid") || '';
                document.getElementById("sectorID-field").value = button.getAttribute("data-sectorid") || '';
                document.getElementById("divisionname-field").value = button.getAttribute("data-divisionname") || '';
                document.getElementById("divisionshortname-field").value = button.getAttribute("data-divisionshortname") || '';
            });
        }
    });
</script>
@endsection