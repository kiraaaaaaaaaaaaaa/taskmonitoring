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

    .pap-row {
        background-color: rgba(45, 106, 79, 0.06) !important;
        border-left: 4px solid var(--bs-dark-green);
        font-weight: 600;
    }

    .task-row {
        transition: background-color 0.2s ease;
    }

    .task-row:hover {
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

<!-- Header & Action Bar -->
<div class="row mb-4 align-items-center">
    <div class="col-sm-6">
        <h3 class="fw-bold mb-1" style="color: var(--bs-dark-green);">PAP Management</h3>
        <p class="text-muted text-sm mb-0">Organize Programs, Activities, Projects (PAP) and associated tasks efficiently.</p>
    </div>
    <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
        <button data-bs-toggle="modal" data-bs-target="#addPapModal" class="btn btn-theme-accent btn-label waves-effect waves-light rounded-pill shadow-sm">
            <i class="ri-add-fill align-middle rounded-pill fs-16 me-2"></i> Add PAP
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
                                    <th>PAP / Task Hierarchy</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach($paps as $pap)
                                <!-- PAP Row -->
                                <tr class="pap-row">
                                    <td class="d-none">{{$pap->id}}</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-between py-1">
                                           <span class="fs-15 d-flex align-items-center">
    <i class="ri-arrow-down-s-line me-2 toggle-icon"
       style="cursor:pointer"
       data-pap="{{ $pap->id }}"></i>

    <i class="ri-folder-shield-2-line me-2"></i>
    {{ $pap->pap }}
</span>
                                            <div class="dropdown">
                                                <a href="#" class="text-muted px-2 py-1" data-bs-toggle="dropdown">
                                                    <i class="ri-more-fill fs-16"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                                    <li>
                                                        <a class="dropdown-item py-2" href="#" data-bs-toggle="modal" data-bs-target="#papModal{{$pap->id}}">
                                                            <i class="ri-add-line me-2 text-success"></i> Add Task
                                                        </a>
                                                        <a class="dropdown-item py-2" href="#" data-bs-toggle="modal" data-bs-target="#editpap{{$pap->id}}">
                                                            <i class="ri-pencil-line me-2 text-warning"></i> Edit PAP
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                        <form action="/papmangement/pap/{{$pap->id}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this PAP?');">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item py-2 text-danger">
                                                                <i class="ri-delete-bin-line me-2"></i> Delete PAP
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Associated Tasks -->
                                @foreach($paptasks as $tasksss)
                                   @if($tasksss->papID == $pap->id)
                                <tr class="task-row task-group-{{$tasksss->papID}}">
                                    <td class="d-none">{{$tasksss->id}}</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-between ps-4 py-1">
                                            <span class="text-muted fs-13 ps-3 border-start border-2">
                                                <i class="ri-arrow-turn-down-right me-2 text-secondary"></i>{{ $tasksss->tasks }}
                                            </span>
                                            <div class="dropdown">
                                                <a href="#" class="text-muted px-2 py-1" data-bs-toggle="dropdown">
                                                    <i class="ri-more-fill fs-16"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                                    <li>
                                                        <a class="dropdown-item py-2" href="#" data-bs-toggle="modal" data-bs-target="#edittasks{{$tasksss->id}}">
                                                            <i class="ri-pencil-line me-2 text-warning"></i> Edit Task
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                        <form action="/papmangement/task/{{$tasksss->id}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item py-2 text-danger">
                                                                <i class="ri-delete-bin-line me-2"></i> Delete Task
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

<!-- ================= ADD TASK MODALS ================= -->
<div>
    @foreach($paps as $pap)
    <form action="{{ route('createPAP') }}" method="POST">
        @csrf
        <div class="modal fade" id="papModal{{$pap->id}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header modal-header-custom p-4">
                        <h5 class="modal-title fw-bold">Add Task to: {{$pap->pap}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <input type="text" name="PAP" value="{{$pap->id}}" hidden>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Task Description <span class="text-danger">*</span></label>
                            <input type="text" name="task" class="form-control shadow-none" placeholder="Enter Task Details" required>
                        </div>
                    </div>
                    <div class="modal-footer bg-light px-4 py-3">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-theme-primary rounded-pill px-4" name="action" value="task">Save Task</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endforeach
</div>

<!-- ================= NEW PAP MODAL ================= -->
<div class="modal fade" id="addPapModal" tabindex="-1" aria-labelledby="addPapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-header-custom p-4">
                <h5 class="modal-title fw-bold" id="addPapModalLabel">Create New PAP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('createPAP') }}">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="PAPname" class="form-label fw-semibold">PAP Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control shadow-none" id="PAPname" name="PAPname" placeholder="Enter PAP Name" required>
                    </div>
                   
                    <div class="mb-3" style="display: none;">
                        <select class="form-select" id="sectorselect" name="sectorselect">
                            <option value="" disabled selected>-- Select Sector --</option>
                            <option value="{{ Auth::user()->sectorID ?? '' }}"></option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="divisionSelect" class="form-label fw-semibold">Assign Division <span class="text-danger">*</span></label>
                            <select class="form-select shadow-none" id="divisionSelect" name="divisionSelect" required>
                                <option value="" disabled selected>-- Select Division --</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="funds" class="form-label fw-semibold">Fund Source <span class="text-danger">*</span></label>
                            <select class="form-select shadow-none" id="funds" name="funds" required>
                             <option value="" disabled selected>-- Select Source of Fund --</option>
                                @foreach($fund as $funds)
                                <option value="{{ $funds->id }}">{{ $funds->fundName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="focalSelect" class="form-label fw-semibold">Assign Focal <span class="text-danger">*</span></label>
                            <select class="form-select shadow-none" id="focalSelect" name="focalSelect" required>
                                <option value="" disabled selected>-- Select Focal --</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="oosSelect" class="form-label fw-semibold">Output/Outcome Supported <span class="text-danger">*</span></label>
                            <select class="form-select shadow-none" id="oosSelect" name="oosSelect" required>
                                <option value="" disabled selected>-- Select Output/Outcome --</option>
                                @foreach($oos as $user)
                                <option value="{{ $user->oosID }}">{{ $user->oosName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-theme-accent rounded-pill px-4" name="action" value="pap">Save Activity</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= EDIT PAP MODAL ================= -->
@foreach($paps as $pap)
<form action="{{ route('createPAP') }}" method="POST">
    @csrf
    <div class="modal fade" id="editpap{{$pap->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-custom p-4">
                    <h5 class="modal-title fw-bold">Edit PAP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="text" name="PAP" value="{{$pap->id}}" hidden>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">PAP Name <span class="text-danger">*</span></label>
                        <input type="text" name="task" class="form-control shadow-none" value="{{$pap->pap}}" required>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-theme-primary rounded-pill px-4" name="action" value="editpap">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endforeach

<!-- ================= EDIT TASK MODALS ================= -->
@foreach($paptasks as $pap)
<form action="{{ route('createPAP') }}" method="POST">
    @csrf
    <div class="modal fade" id="edittasks{{$pap->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-custom p-4">
                    <h5 class="modal-title fw-bold">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="text" name="PAP" value="{{$pap->id}}" hidden>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Task Description <span class="text-danger">*</span></label>
                        <input type="text" name="task" class="form-control shadow-none" value="{{$pap->tasks}}" required>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-theme-primary rounded-pill px-4" name="action" value="edittask">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endforeach

<!-- JavaScript Framework Handling -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inputsector = document.getElementById('sectorselect');
        const inputdivision = document.getElementById('divisionSelect');
        const sector = {!! json_encode($sector) !!};
        const division = {!! json_encode($division) !!};

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

        if (inputsector && !inputsector.value) {
            inputsector.selectedIndex = 1; 
        }

        if(inputsector) {
            inputsector.dispatchEvent(new Event('change'));
        }

        
    });
    document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".toggle-icon").forEach(icon => {

        icon.addEventListener("click", function () {

            const papId = this.dataset.pap;

            const tasks = document.querySelectorAll(".task-group-" + papId);

            tasks.forEach(task => {
                task.classList.toggle("d-none");
            });

            if (this.classList.contains("ri-arrow-down-s-line")) {
                this.classList.remove("ri-arrow-down-s-line");
                this.classList.add("ri-arrow-right-s-line");
            } else {
                this.classList.remove("ri-arrow-right-s-line");
                this.classList.add("ri-arrow-down-s-line");
            }

        });

    });

});
</script>

@endsection