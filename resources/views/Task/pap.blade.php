@extends('components.layout')

@section('content')

<style>
    /* Theme Color Customizations: Dark Green, Golden Yellow, and White */
    :root {
        --bs-dark-green: #0b3c29;
        --bs-medium-green: #134e38;
        --bs-accent-green: #1f7a55;
        --bs-golden-yellow: #d4af37;
        --bs-golden-yellow-light: #fef9e7;
    }

    body {
        background-color: #f8f9fa;
    }

    /* Modern Card Layouts */
    .card-activity {
        border: none;
        border-radius: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 0.5rem 1.25rem rgba(11, 60, 41, 0.04);
        background: #ffffff;
        overflow: hidden;
    }

    .card-activity:hover {
        transform: translateY(-4px);
        box-shadow: 0 0.75rem 2rem rgba(11, 60, 41, 0.08);
        
    }

    /* Month Navigation Header Styling */
    .month-nav-container {
        background: #ffffff;
        border-radius: 50rem;
        padding: 0.5rem 1.5rem;
        box-shadow: 0 0.25rem 0.75rem rgba(11, 60, 41, 0.04);
        display: inline-flex;
        align-items: center;
    }

    .btn-month-nav {
        background-color: var(--bs-golden-yellow-light);
        color: var(--bs-dark-green);
        border: 1px solid rgba(212, 175, 55, 0.3);
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .btn-month-nav:hover {
        background-color: var(--bs-golden-yellow);
        color: #ffffff;
    }

    /* Custom Buttons matching Dark Green & Golden Yellow */
    .btn-dark-green {
        background-color: var(--bs-dark-green);
        color: #ffffff;
        border: none;
        transition: background-color 0.2s ease;
    }

    .btn-dark-green:hover {
        background-color: var(--bs-medium-green);
        color: #ffffff;
    }

    .btn-golden {
        background-color: var(--bs-golden-yellow);
        color: #ffffff;
        border: none;
    }

    .btn-golden:hover {
        background-color: #b8972b;
        color: #ffffff;
    }

    /* Ribbons and Badges */
    .activity-badge-done {
        background-color: #e8f5e9;
        color: #2e7d32;
        border: 1px solid rgba(46, 125, 50, 0.2);
    }

    .activity-badge-today {
        background-color: var(--bs-golden-yellow-light);
        color: #8c7310;
        border: 1px solid rgba(212, 175, 55, 0.3);
    }

    /* Modal styling polish */
    .modal-content {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.15);
    }
     .pap-hero-card {
        background: #ffffff;
    color: var(--bs-dark-green);
    border: none;
    border-left: 10px solid var(--bs-dark-green);
    border-radius: 1rem;
    box-shadow: 0 0.5rem 1.5rem rgba(10, 54, 34, 0.1);
    }
    .task-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1.25rem rgba(10, 54, 34, 0.08);
        border-color: var(--bs-golden-yellow);
    }
</style>

<!-- Month Navigation Header -->
<div class="d-flex justify-content-center align-items-center mb-4">
    <div class="month-nav-container">
        {{-- PREVIOUS --}}
        <a href="{{ route('task disposition', [
            'year' => $Month == 1 ? $Year - 1 : $Year,
            'month' => $Month == 1 ? 12 : $Month - 1
        ]) }}" class="btn btn-month-nav me-3 shadow-none text-decoration-none">
            <i class="ri-arrow-left-s-line fs-18"></i>
        </a>

        {{-- LABEL --}}
        <span class="fw-bold fs-5 text-dark px-3 font-monospace">
            {{ \Carbon\Carbon::create($Year, $Month, 1)->format('F Y') }}
        </span>

        {{-- NEXT --}}
        <a href="{{ route('task disposition', [
            'year' => $Month == 12 ? $Year + 1 : $Year,
            'month' => $Month == 12 ? 1 : $Month + 1
        ]) }}" class="btn btn-month-nav ms-3 shadow-none text-decoration-none">
            <i class="ri-arrow-right-s-line fs-18"></i>
        </a>
    </div>
</div>

<!-- Add Activity Action Button -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Activity Schedule</h4>
        
    </div>
    <a data-bs-toggle="modal" id="assignTaskBtn" data-bs-target="#addPapModal" class="btn btn-dark-green btn-label rounded-pill px-4 py-2 shadow-sm">
        <i class="ri-add-line align-middle rounded-pill fs-16 me-2"></i>
        Add Activity
    </a>
</div>

@if($newtask->isEmpty())
<div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white">
    <div class="avatar-lg mx-auto mb-3 bg-light rounded-circle d-flex align-items-center justify-content-center text-muted fs-24">
        <i class="ri-calendar-line"></i>
    </div>
    <h5 class="fw-bold text-dark">No Activities Found</h5>
    <p class="text-muted fs-13 mb-0">No PAPs are scheduled for {{ \Carbon\Carbon::create($Year, $Month, 1)->format('F Y') }}.</p>
</div>
@else

<div class="row g-4 " >
    @foreach ($newtask as $task)
    <div class="col-12s col-md-6 col-xl-4  ">
        <div class="card card-activity task-card h-100 pap-hero-card">
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div>
                    <!-- Status Banner / Ribbon Header -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                       <!-- @if(\Carbon\Carbon::parse($task->fromdate)->isPast())
                            <span class="badge activity-badge-done px-2.5 py-1.5 rounded-pill fs-11 fw-medium">
                                <i class="ri-checkbox-circle-line me-1"></i> Activity Done
                            </span>
                        @elseif(\Carbon\Carbon::parse($task->fromdate)->isToday())
                            <span class="badge activity-badge-today px-2.5 py-1.5 rounded-pill fs-11 fw-medium">
                                <i class="ri-time-line me-1"></i> Day of Activity
                            </span>
                        @else
                            <span class="badge bg-light text-muted border px-2.5 py-1.5 rounded-pill fs-11">
                                <i class="ri-calendar-event-line me-1"></i> {{ \Carbon\Carbon::parse($task->fromdate)->diffForHumans() }}
                            </span>
                        @endif -->
                        <div></div>

                        <div class="dropdown">
                            <a href="#" class="btn btn-icon btn-sm btn-ghost-secondary rounded-circle shadow-none" data-bs-toggle="dropdown">
                                <i class="ri-more-2-fill fs-16"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 py-2">
                                <li>
                                    <a class="dropdown-item addTaskBtn py-2 text-dark" href="/Task.createtask/{{ $task->newID }}" id="addTaskBtn">
                                        <i class="ri-add-circle-line align-bottom me-2 text-success"></i> Add Task
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2 editPapLinkbtn text-dark editPapLink" id="editPapLinkbtn" href="#" data-bs-toggle="modal" data-bs-target="#editPapModal" data-id="{{ $task->newID }}" data-googlecalendareventID="{{ $task->googlecalendareventID }}" data-papid="{{ $task->papID }}" data-pap="{{ $task->pap }}" data-location="{{ $task->location }}" data-datefrom="{{ $task->fromdate }}" data-dateend="{{$task->todate}}" data-description="{{ $task->description }}">
                                        <i class="ri-pencil-line align-bottom me-2 text-warning"></i> Edit PAP
                                    </a>
                                </li>
                                <li class="removePapBtn">
                                    <form action="/Task/pap/{{ $task->newID }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-danger" onclick="return confirm('Are you sure you want to remove this PAP?')">
                                            <i class="ri-subtract-line align-bottom me-2"></i> Remove PAP
                                        </button>
                                    </form>
                                </li>
                                <li><hr class="dropdown-divider my-1" id="dropdownDivider"></li>
                                <li>
                                    <a class="dropdown-item py-2 text-dark" href="/Task/task/{{$task->fromdate}}/{{$task->newID}}">
                                        <i class="ri-eye-line align-bottom me-2 text-primary"></i> View Details
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- PAP Name -->
                    <h5 class="fw-bold text-dark mb-2 text-truncate" title="{{ $task->pap }}">
                        {{ $task->pap }}
                    </h5>

                    <!-- Description If Available -->
                    @if(!empty($task->description))
                    <p class="text-muted fs-12 mb-3 text-clamp-2">
                        {{ $task->description }}
                    </p>
                    @endif
                </div>

                <!-- Footer Meta Details -->
                <div class="pt-3 border-top mt-3 d-flex align-items-center justify-content-between text-muted fs-12">
                    <div class="d-flex align-items-center gap-1 text-truncate">
                        <i class="ri-map-pin-line text-success"></i> 
                        <span class="text-truncate" style="max-width: 140px;" title="{{ $task->location }}">{{ $task->location ?: 'Location TBD' }}</span>
                    </div>
                    <div class="text-nowrap font-monospace text-dark fw-medium">
                        <i class="ri-calendar-2-line text-warning me-1"></i>
                        {{ \Carbon\Carbon::parse($task->fromdate)->format('M d') }} - {{ \Carbon\Carbon::parse($task->todate)->format('M d, Y') }}
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endforeach
</div>

@endif

<!-- Add Activity Modal -->
<div class="modal fade" id="addPapModal" tabindex="-1" aria-labelledby="addPapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark" id="addPapModalLabel">New Activity Milestone</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('savePAP') }}">
                @csrf
                <div class="modal-body pt-3">
                    <div class="mb-3">
                        <label for="papName" class="form-label fw-semibold fs-13">PAP Name <span class="text-danger">*</span></label>
                        <select class="form-select rounded-3 py-2" id="papName" name="pap" required>
                            <option value="" disabled selected>-- Select PAP --</option>
                            @foreach($papOptions as $option)
                            <option value="{{ $option->id }}">{{ $option->pap }}</option>
                            @endforeach
                            <option value="addpap" data-bs-toggle="modal" data-bs-target="#addPapModals" data-bs-dismiss="modal">-- Add New PAP --</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold fs-13">Description <span class="text-muted fw-normal">(Optional)</span></label>
                        <input type="text" class="form-control rounded-3 py-2" id="description" name="description" placeholder="Brief activity details">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-13">Indicative Date Range <span class="text-danger">*</span></label>
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 fs-12">From</span>
                                    <input type="date" class="form-control rounded-end py-2" id="indicativeDate" name="datefrom" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 fs-12">To</span>
                                    <input type="date" class="form-control rounded-end py-2" id="indicativeDateEnd" name="dateend" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label fw-semibold fs-13">Location</label>
                        <input type="text" class="form-control rounded-3 py-2" id="location" name="location" placeholder="Venue or location">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark-green rounded-pill px-4">Save Activity</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Inline Quick-Add PAP Modal -->
<form action="{{ route('createPAP') }}" method="POST">
    @csrf
    <div class="modal fade" id="addPapModals" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-dark">Add New PAP</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-3">
                    <label class="form-label fw-semibold fs-13">PAP Title <span class="text-danger">*</span></label>
                    <input type="text" name="pap" class="form-control rounded-3 py-2" placeholder="Enter PAP title" required>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-dark-green rounded-pill px-4" name="action" value="pap">Save PAP</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Edit Activity Modal -->
<div class="modal fade" id="editPapModal" tabindex="-1" aria-labelledby="editPapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark" id="editPapModalLabel">Edit Activity Milestone</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('savePAP') }}">
                @csrf
                <div class="modal-body pt-3">
                    <input type="hidden" id="editpapid" name="editpapid">
                    <input type="hidden" id="googlecalendareventID" name="googlecalendareventID">

                    <div class="mb-3">
                        <label for="editpapName" class="form-label fw-semibold fs-13">PAP Name</label>
                        <input type="text" class="form-control rounded-3 py-2 bg-light text-muted" id="editpapName" name="editpapName" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="editdescription" class="form-label fw-semibold fs-13">Description</label>
                        <input type="text" class="form-control rounded-3 py-2" id="editdescription" name="editdescription" placeholder="Description details">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-13">Indicative Date Range</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 fs-12">From</span>
                                    <input type="date" class="form-control rounded-end py-2" id="editindicativeDate" name="editdatefrom">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 fs-12">To</span>
                                    <input type="date" class="form-control rounded-end py-2" id="editindicativeDateEnd" name="editdateend">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="editlocation" class="form-label fw-semibold fs-13">Location</label>
                        <input type="text" class="form-control rounded-3 py-2" id="editlocation" name="editlocation" placeholder="Venue or location">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark-green rounded-pill px-4">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        const userType = @json(Auth::user()->usertype);

    if (userType === '2') {

        document.querySelectorAll('.assignTaskBtn').forEach(el => {
            el.style.display = 'none';
        });

        document.querySelectorAll('.addTaskBtn').forEach(el => {
            el.style.display = 'none';
        });

        document.querySelectorAll('.editPapLink').forEach(el => {
            el.style.display = 'none';
        });

        document.querySelectorAll('.deletePapBtn').forEach(el => {
            el.style.display = 'none';
        });

        document.querySelectorAll('.dropdownDivider').forEach(el => {
            el.style.display = 'none';
        });

        document.querySelectorAll('.removePapBtn').forEach(el => {
            el.style.display = 'none';
        });

    }

        document.querySelectorAll('.editPapLink').forEach(link => {
            link.addEventListener('click', function() {
                const papId = this.getAttribute('data-id');
                const papName = this.getAttribute('data-pap');
                const location = this.getAttribute('data-location');
                const dateFrom = this.getAttribute('data-datefrom');
                const dateEnd = this.getAttribute('data-dateend');
                const description = this.getAttribute('data-description');
                const googlecalendareventID = this.getAttribute('data-googlecalendareventID');

                document.getElementById('editpapid').value = papId;
                document.getElementById('editpapName').value = papName;
                document.getElementById('editlocation').value = location;
                document.getElementById('editindicativeDate').value = dateFrom;
                document.getElementById('editindicativeDateEnd').value = dateEnd;
                document.getElementById('editdescription').value = description;
                document.getElementById('googlecalendareventID').value = googlecalendareventID;
            });
        });

        const papNameSelect = document.getElementById("papName");
        if(papNameSelect) {
            papNameSelect.addEventListener("change", function(){
                if(this.value === "addpap"){
                    let modal = new bootstrap.Modal(document.getElementById("addPapModals"));
                    modal.show();
                    this.value = ""; 
                }
            });
        }
    });
</script>