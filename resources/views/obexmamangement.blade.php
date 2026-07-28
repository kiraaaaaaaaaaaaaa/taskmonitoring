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

    .program-row {
        background-color: rgba(45, 106, 79, 0.08) !important;
        border-left: 4px solid var(--bs-dark-green);
    }

    .subprogram-row {
        background-color: rgba(255, 183, 3, 0.04) !important;
    }

    .tree-row {
        transition: background-color 0.2s ease;
    }

    .tree-row:hover {
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
        <h3 class="fw-bold mb-1" style="color: var(--bs-dark-green);">Program Management</h3>
        <p class="text-muted text-sm mb-0">Organize Programs, Sub-programs, and OBEX entries (FY: {{date('Y')}}).</p>
    </div>
    <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
        <button data-bs-toggle="modal" data-bs-target="#showModal" class="btn btn-theme-accent btn-label waves-effect waves-light rounded-pill shadow-sm">
            <i class="ri-add-fill align-middle rounded-pill fs-16 me-2"></i> Add Program
        </button>
    </div>
</div>

<!-- Main Layout Card -->
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
                                    <th>Program / Sub-program / OBEX Structure</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all"> 
                                @foreach($program as $sectors)
                                <!-- Program Row -->
                                <tr class="program-row">
                                    <td class="d-none">{{$sectors->id}}</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-between py-1">
                                            <span class="fw-bold fs-15" style="color: var(--bs-dark-green);">
                                                <i class="ri-folder-settings-line me-2"></i>{{$sectors->programname}}
                                            </span>
                                            <div class="dropdown float-end">
                                                <a href="#" class="text-muted px-2 py-1" data-bs-toggle="dropdown">
                                                    <i class="ri-more-fill fs-16"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                                    <li>
                                                        <a class="dropdown-item py-2" href="#" data-bs-toggle="modal" data-bs-target="#divisionModal{{$sectors->id}}">
                                                            <i class="ri-add-line me-2 text-success"></i> Add Sub-program
                                                        </a>
                                                        <a class="dropdown-item py-2" href="#"
                                                            data-id="{{ $sectors->id }}"
                                                            data-secname="{{ $sectors->programname }}"
                                                            data-bs-toggle="modal" data-bs-target="#showModal">
                                                            <i class="ri-pencil-line me-2 text-warning"></i> Edit Program
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                        <form action="{{ route('deleteprogram', $sectors->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Program?');">
                                                            @csrf 
                                                            <button type="submit" class="dropdown-item py-2 text-danger">
                                                                <i class="ri-delete-bin-line me-2"></i> Delete Program
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Sub-programs Loop -->
                                @foreach($subprogram as $division)
                                    @if($division->programID === $sectors->id)
                                    <tr class="subprogram-row tree-row">
                                        <td>
                                            <div class="d-flex align-items-center justify-content-between ps-3 py-1">
                                                <span class="fs-13 fw-semibold text-secondary ps-2 border-start border-2 border-warning">
                                                    <i class="ri-git-branch-line me-2"></i>{{ $division->subprogramname }}
                                                </span>
                                                <div class="dropdown">
                                                    <a href="#" class="text-muted px-2 py-1" data-bs-toggle="dropdown">
                                                        <i class="ri-more-fill fs-16"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                                        <li>
                                                            <a class="dropdown-item py-2" href="#" data-bs-toggle="modal" data-bs-target="#subprogramModal{{$division->id}}">
                                                                <i class="ri-add-line me-2 text-success"></i> Add OBEX
                                                            </a>
                                                            <a class="dropdown-item py-2" href="#"
                                                                data-divid="{{ $division->id }}"
                                                                data-sectorid="{{ $division->programID }}"
                                                                data-divisionname="{{ $division->subprogramname }}"
                                                                data-bs-toggle="modal" data-bs-target="#divisionModals">
                                                                <i class="ri-pencil-line me-2 text-warning"></i> Edit Sub-program
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <form action="{{ route('deletesubprogram', $division->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Sub-program?');">
                                                                @csrf
                                                                <button type="submit" class="dropdown-item py-2 text-danger">
                                                                    <i class="ri-delete-bin-line me-2"></i> Delete Sub-program
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- MOOE Header & List -->
                                    <tr class="table-light">
                                        <td><span class="fs-11 fw-bold text-muted ps-5 text-uppercase tracking-wide">MOOE</span></td>
                                    </tr>
                                    @foreach($mooe as $mooes)
                                        @if($mooes->subprogramID === $division->id && $mooes->type == 0)
                                        <tr class="tree-row">
                                            <td>
                                                <div class="d-flex align-items-center justify-content-between ps-5 py-1">
                                                    <span class="fs-12 text-muted ps-3">
                                                        <i class="ri-arrow-turn-down-right me-2 text-muted"></i>{{ $mooes->mooeName }}
                                                    </span>
                                                    <div class="dropdown">
                                                        <a href="#" class="text-muted px-2 py-1" data-bs-toggle="dropdown">
                                                            <i class="ri-more-fill fs-16"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                                            <li>
                                                                <a class="dropdown-item py-2" href="#"
                                                                    data-obexid="{{ $mooes->mooeID }}"
                                                                    data-subid="{{ $mooes->subprogramID }}"
                                                                    data-obexname="{{ $mooes->mooeName }}"
                                                                    data-bs-toggle="modal" data-bs-target="#obexModals">
                                                                    <i class="ri-pencil-line me-2 text-warning"></i> Edit OBEX
                                                                </a>
                                                                <div class="dropdown-divider"></div>
                                                                <form action="{{ route('deleteobex', $mooes->mooeID) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this OBEX?');">
                                                                    @csrf
                                                                    <button type="submit" class="dropdown-item py-2 text-danger">
                                                                        <i class="ri-delete-bin-line me-2"></i> Delete OBEX
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

                                    <!-- Capital Outlay (CO) Header & List -->
                                    <tr class="table-light">
                                        <td><span class="fs-11 fw-bold text-muted ps-5 text-uppercase tracking-wide">Capital Outlay (CO)</span></td>
                                    </tr>
                                    @foreach($mooe as $mooes)
                                        @if($mooes->subprogramID === $division->id && $mooes->type == 1)
                                        <tr class="tree-row">
                                            <td>
                                                <div class="d-flex align-items-center justify-content-between ps-5 py-1">
                                                    <span class="fs-12 text-muted ps-3">
                                                        <i class="ri-arrow-turn-down-right me-2 text-muted"></i>{{ $mooes->mooeName }}
                                                    </span>
                                                    <div class="dropdown">
                                                        <a href="#" class="text-muted px-2 py-1" data-bs-toggle="dropdown">
                                                            <i class="ri-more-fill fs-16"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                                            <li>
                                                                <a class="dropdown-item py-2" href="#"
                                                                    data-obexid="{{ $mooes->mooeID }}"
                                                                    data-subid="{{ $mooes->subprogramID }}"
                                                                    data-obexname="{{ $mooes->mooeName }}"
                                                                    data-bs-toggle="modal" data-bs-target="#obexModals">
                                                                    <i class="ri-pencil-line me-2 text-warning"></i> Edit OBEX
                                                                </a>
                                                                <div class="dropdown-divider"></div>
                                                                <form action="{{ route('deleteobex', $mooes->mooeID) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this OBEX?');">
                                                                    @csrf
                                                                    <button type="submit" class="dropdown-item py-2 text-danger">
                                                                        <i class="ri-delete-bin-line me-2"></i> Delete OBEX
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

<!-- Add/Edit Program Modal -->
<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-header-custom p-4">
                <h5 class="modal-title fw-bold" id="exampleModalLabel">Program Configuration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <form action="{{route('storeprogram')}}" method="POST" id="sectorform">
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
                        <label for="secname-field" class="form-label fw-semibold">Program Name <span class="text-danger">*</span></label>
                        <input type="text" id="secname-field" name="secname" class="form-control shadow-none" placeholder="Enter Program Name" required>
                        <div class="invalid-feedback">Please enter a name.</div>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-theme-primary rounded-pill px-4">Save Program</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Sub-program Modals -->
<div>
    @foreach($program as $sectors)
    <form action="{{ route('storesubprogram') }}" method="POST">
        @csrf
        <div class="modal fade" id="divisionModal{{$sectors->id}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header modal-header-custom p-4">
                        <h5 class="modal-title fw-bold">Add Sub-program to {{$sectors->programname}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <input type="text" name="subid" value="{{$sectors->id}}" hidden>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Sub-program Name <span class="text-danger">*</span></label>
                            <input type="text" name="subname" class="form-control shadow-none" placeholder="Enter Sub-program Name" required>
                        </div>
                    </div>
                    <div class="modal-footer bg-light px-4 py-3">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-theme-primary rounded-pill px-4" name="action" value="division">Save Sub-program</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endforeach
</div>

<!-- Add OBEX Modals -->
<div>
    @foreach($subprogram as $sectors)
    <form action="{{ route('storeobex') }}" method="POST">
        @csrf
        <div class="modal fade" id="subprogramModal{{$sectors->id}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header modal-header-custom p-4">
                        <h5 class="modal-title fw-bold">Add OBEX to {{$sectors->subprogramname}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <input type="text" name="obexID" value="{{$sectors->id}}" hidden>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">OBEX Name <span class="text-danger">*</span></label>
                            <input type="text" name="obexname" class="form-control shadow-none" placeholder="Enter OBEX Name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold d-block">Fund Type <span class="text-danger">*</span></label>
                            <div class="form-check form-check-inline mt-1">
                                <input class="form-check-input" type="radio" name="type" id="mooe_{{$sectors->id}}" value="0" required>
                                <label class="form-check-label" for="mooe_{{$sectors->id}}">MOOE</label>
                            </div>
                            <div class="form-check form-check-inline mt-1">
                                <input class="form-check-input" type="radio" name="type" id="co_{{$sectors->id}}" value="1">
                                <label class="form-check-label" for="co_{{$sectors->id}}">Capital Outlay</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light px-4 py-3">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-theme-primary rounded-pill px-4" name="action" value="division">Save OBEX</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endforeach
</div>

<!-- Edit Sub-program Modal -->
<div>
    <form action="{{ route('storesubprogram') }}" method="POST">
        @csrf
        <div class="modal fade" id="divisionModals" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header modal-header-custom p-4">
                        <h5 class="modal-title fw-bold">Edit Sub-program</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <input type="text" id="divisionID-field" name="editsubid" hidden>
                        <input type="text" id="sectorID-field" name="editprogid" hidden>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Sub-program Name <span class="text-danger">*</span></label>
                            <input type="text" id="divisionname-field" name="editsubname" class="form-control shadow-none" placeholder="Enter Sub-program Name" required>
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

<!-- Edit OBEX Modal -->
<div>
    <form action="{{ route('storeobex') }}" method="POST">
        @csrf
        <div class="modal fade" id="obexModals" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header modal-header-custom p-4">
                        <h5 class="modal-title fw-bold">Edit OBEX</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <input type="text" id="obexID-field" name="editobexid" hidden>
                        <input type="text" id="subID-field" name="editsubid" hidden>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">OBEX Name <span class="text-danger">*</span></label>
                            <input type="text" id="obexname-field" name="editobexname" class="form-control shadow-none" placeholder="Enter OBEX Name" required>
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

<!-- Modal Controller JavaScript -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var userModal = document.getElementById("showModal");
        var divisionModal = document.getElementById("divisionModals");
        var obexModal = document.getElementById("obexModals");

        if(userModal) {
            userModal.addEventListener("show.bs.modal", function(event) {
                var button = event.relatedTarget;
                if(!button) return;
                document.getElementById("secid-field").value = button.getAttribute("data-id") || '';
                document.getElementById("secname-field").value = button.getAttribute("data-secname") || '';
            });
        }

        if(divisionModal) {
            divisionModal.addEventListener("show.bs.modal", function(event) {
                var button = event.relatedTarget;
                if(!button) return;
                document.getElementById("divisionID-field").value = button.getAttribute("data-divid") || '';
                document.getElementById("sectorID-field").value = button.getAttribute("data-sectorid") || '';
                document.getElementById("divisionname-field").value = button.getAttribute("data-divisionname") || '';
            });
        }

        if(obexModal) {
            obexModal.addEventListener("show.bs.modal", function(event) {
                var button = event.relatedTarget;
                if(!button) return;
                document.getElementById("obexID-field").value = button.getAttribute("data-obexid") || '';
                document.getElementById("subID-field").value = button.getAttribute("data-subid") || '';
                document.getElementById("obexname-field").value = button.getAttribute("data-obexname") || '';
            });
        }
    });
</script>
@endsection