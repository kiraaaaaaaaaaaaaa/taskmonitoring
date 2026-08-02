@extends('components.layout')

@section('content')

<style>
    /* Modern Theme Customizations: Dark Green, Golden Yellow, and White */
    :root {
        --bs-dark-green: #0a3622;
        --bs-medium-green: #114c31;
        --bs-accent-green: #196f47;
        --bs-golden-yellow: #d4af37;
        --bs-golden-yellow-light: #fef9e7;
        --bs-golden-yellow-border: #f3e5ab;
    }

    body {
        background-color: #f7f9fa;
    }

    /* Card & Container Styling */
    .card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1.5rem rgba(10, 54, 34, 0.05);
        background: #ffffff;
    }

    .form-label {
        font-weight: 600;
        color: var(--bs-dark-green);
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control, .form-select {
        border-radius: 0.50rem;
        border: 1px solid #ced4da;
        padding: 0.65rem 0.9rem;
    
        font-size: 0.925rem;

        transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--bs-accent-green);
        box-shadow: 0 0 0 0.25rem rgba(25, 111, 71, 0.15);
   
    }

    .form-control[readonly] {
        background-color: #f8f9fa;
        color: #495057;
    }

    /* Reviewer Item Box Styling */
    .reviewer-fieldset {
        background: #fbfcfd;
        border: 1px solid #edf2f7 !important;
        border-radius: 0.75rem !important;
        padding: 1.25rem !important;
        margin-bottom: 1rem;
        transition: all 0.2s ease;
    }

    .reviewer-fieldset:hover {
        border-color: var(--bs-golden-yellow-border) !important;
        box-shadow: 0 0.25rem 0.75rem rgba(10, 54, 34, 0.03);
    }

    /* Custom Buttons */
    .btn-dark-green {
        background-color: var(--bs-dark-green);
        color: #ffffff;
        border: none;
        transition: all 0.2s ease;
    }

    .btn-dark-green:hover {
        background-color: var(--bs-accent-green);
        color: #ffffff;
    }

    .btn-outline-dark-green {
        border-color: var(--bs-dark-green);
        color: var(--bs-dark-green);
    }

    .btn-outline-dark-green:hover {
        background-color: var(--bs-dark-green);
        color: #ffffff;
    }

    .btn-golden-yellow {
        background-color: var(--bs-golden-yellow);
        color: var(--bs-dark-green);
        font-weight: 600;
        border: none;
    }

    .btn-golden-yellow:hover {
        background-color: #c59f2c;
        color: var(--bs-dark-green);
    }

    /* Modal styling */
    .modal-content {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 1rem 3rem rgba(0,0,0,0.1);
    }

    .modal-header {
        background-color: var(--bs-dark-green);
        color: #ffffff;
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    .choices__inner {
    background-color: #ffffff !important;
    border: 1px solid #ced4da !important;
    border-radius: 0.5rem !important;
    min-height: 44px;
    padding: .45rem .75rem !important;
}

.choices__list--dropdown,
.choices__list[aria-expanded] {
    background: #ffffff !important;
    border: 1px solid #ced4da !important;
}

.choices__input {
    background: #ffffff !important;
}

.choices__item {
    color: #212529;
}

</style>

<div class="d-flex justify-content-between align-items-center mb-4">
            <a href="javascript:history.back()" class="btn btn-outline-dark-green rounded-pill px-3 shadow-sm">
                <i class="ri-arrow-left-s-line me-2"></i> Back
            </a>
           
        </div>

<div class="container py-4">
    <form action="{{ route('store') }}" method="POST">
        @csrf

        <!-- Back Button & Page Header Action -->
        

        <div class="row justify-content-center">
            <div class="col-lg-9">

                <!-- ================= PAP & TASK DETAILS CARD ================= -->
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-body p-4 p-md-5">
                        
                        <h4 class="fw-bold mb-4" style="color: var(--bs-dark-green);">
                            <i class="ri-file-list-3-line me-2"></i> Task & PAP Configuration
                        </h4>

                        <div class="mb-3">
                            <label class="form-label">Program, Activity, Project (PAP)</label>
                            <input id="papID" name="paps" value="{{ $newpap->papID}}" hidden>
                            <input id="papID_sub" name="PAP" value="{{ $newpap->id}}" hidden>
                            <input type="text" id="pap" name="pap" class="form-control bg-light" value="{{ $newpap->pap ?? '' }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Select Task(s)</label>
                            <select id="paptask" name="tasks[]" class="form-control" multiple>
                                <option value="newtask">-- Add new Task --</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Assigned Personnel</label>
                            <select class="form-select" name="assigned">
                                <option value="">-- Choose Personnel --</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <input type="date" class="form-control" name="activitydate" value="{{ $newpap->fromdate}}" hidden>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Target Date of Completion</label>
                                <input type="date" class="form-control" name="duedate">
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ================= REVIEWERS CARD ================= -->
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-body p-4 p-md-5">
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold mb-0" style="color: var(--bs-dark-green);">
                                <i class="ri-shield-check-line me-2"></i> Reviewer(s) Assignment
                            </h4>
                            <button type="button" class="btn btn-sm btn-golden-yellow rounded-pill px-3 shadow-sm" id="addReviewerBtn">
                                <i class="ri-add-line me-1"></i> Add Reviewer
                            </button>
                        </div>

                        <div id="reviewersContainer">
                            @php
                                $reviewerCount = 1; // Set the maximum initial number of reviewer
                            @endphp
                            @for($i=1; $i<=$reviewerCount; $i++) 
                            <fieldset class="reviewer-fieldset border rounded p-3 mb-3">
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-5">
                                        <label class="form-label text-muted fs-11 mb-1">Reviewer {{ $i }}</label>
                                        <select id="reviewer{{ $i }}" class="form-select" name="reviewer{{ $i }}">
                                            <option value="">-- Choose Reviewer --</option>
                                            @foreach($users as $user)
                                            @if(in_array($user->usertype, ['3','4','5']))
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label text-muted fs-11 mb-1">Target Return Date</label>
                                        <input type="date" id="date{{ $i }}" class="form-control" name="returneddate{{ $i }}">
                                    </div>

                                    <div class="col-md-3 d-flex align-items-center pt-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="switch{{ $i }}" onclick="toggleReviewerFields({{ $i }})">
                                            <label class="form-check-label fs-12 text-muted fw-bold ms-1" for="switch{{ $i }}">Not Applicable</label>
                                        </div>
                                        <input type="hidden" id="st{{ $i }}" name="status{{ $i }}" value="Pending">
                                    </div>
                                </div>
                            </fieldset>
                            @endfor
                        </div>

                    </div>
                </div>

                <div class="d-flex justify-content-end mb-5">
                    <button type="submit" class="btn btn-dark-green rounded-pill px-5 py-2 shadow-sm">
                        <i class="ri-save-line me-2"></i> Save Record
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>

<!-- ================= PAP MODAL ================= -->
<form action="{{ route('createPAP') }}" method="POST">
    @csrf
    <div class="modal fade" id="addPapModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">New PAP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <label class="form-label">PAP Name</label>
                    <input type="text" name="pap" class="form-control" placeholder="Enter PAP" required>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-dark-green rounded-pill px-4" name="action" value="pap">Save PAP</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- ================= TASK MODAL ================= -->
<form action="{{ route('createPAP') }}" method="POST">
    @csrf
    <div class="modal fade" id="addTaskpModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">New Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" id="modalPapID" name="PAP" value="{{ $newpap->papID}}">
                    <label class="form-label">Task Description</label>
                    <input type="text" name="task" class="form-control" placeholder="Enter Task" required>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-dark-green rounded-pill px-4" name="action" value="task">Save Task</button>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    const papInput = document.getElementById('papID');
    const taskSelect = document.getElementById('paptask');
    const addReviewerBtn = document.getElementById('addReviewerBtn');

    // Choices.js initialization
    const choices = new Choices(taskSelect, {
        removeItemButton: true,
        placeholderValue: 'Select task(s)',
        shouldSort: false
    });

    const tasksByPap = {!! json_encode($tasksByPap) !!};

    function populateTasks(papId) {
        choices.clearChoices();

        if (!tasksByPap[papId]) return;

        choices.setChoices(
            [
                ...tasksByPap[papId].map(task => ({
                    value: task.id,
                    label: task.tasks
                })),
                {
                    value: 'newtask',
                    label: '-- Add New Task --'
                }
            ],
            'value',
            'label',
            true
        );

        choices.removeActiveItems();
    }

    populateTasks(papInput.value);

    taskSelect.addEventListener('change', () => {
        const selectedValues = choices.getValue(true);

        if (selectedValues.includes('newtask')) {
            choices.removeActiveItems();
            new bootstrap.Modal(document.getElementById('addTaskpModal')).show();
        }
    });

    // Reviewer toggle handler
    window.toggleReviewerFields = (i) => {
        const r = document.getElementById('reviewer' + i);
        const d = document.getElementById('date' + i);
        const s = document.getElementById('st' + i);
        const switchEl = document.getElementById('switch' + i);

        const disabled = switchEl.checked;
        r.disabled = disabled;
        d.disabled = disabled;
        s.value = disabled ? 'Not Applicable' : 'Pending';
        
        if(disabled) {
            r.value = "";
            d.value = "";
        }
    };

    const reviewersContainer = document.getElementById('reviewersContainer');
    let reviewerCount = document.querySelectorAll('select[id^="reviewer"]').length;

    addReviewerBtn.addEventListener('click', () => {
        
        if (reviewerCount > 5) {
            alert('Maximum of 5 reviewers allowed.');
            reviewerCount--;
            return;
        }
        reviewerCount++;
        const fieldset = document.createElement('fieldset');
        fieldset.classList.add('reviewer-fieldset', 'border', 'rounded', 'p-3', 'mb-3');
        fieldset.innerHTML = `
            <div class="row g-3 align-items-center">
                <div class="col-md-5">
                    <label class="form-label text-muted fs-11 mb-1">Reviewer ${reviewerCount}</label>
                    <select id="reviewer${reviewerCount}" class="form-select" name="reviewer${reviewerCount}">
                        <option value="">-- Choose Reviewer --</option>
                        @foreach($users as $user)
                            @if(in_array($user->usertype, ['3','4','5']))
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label text-muted fs-11 mb-1">Target Return Date</label>
                    <input type="date" id="date${reviewerCount}" class="form-control" name="returneddate${reviewerCount}">
                </div>

                <div class="col-md-3 d-flex align-items-center justify-content-between pt-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="switch${reviewerCount}" onclick="toggleReviewerFields(${reviewerCount})">
                        <label class="form-check-label fs-12 text-muted fw-bold ms-1" for="switch${reviewerCount}">N/A</label>
                    </div>
                    <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-2 py-1 removeReviewerBtn" title="Remove Reviewer">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </div>
            </div>
            <input type="hidden" id="st${reviewerCount}" name="status${reviewerCount}" value="Pending">
        `;

        reviewersContainer.appendChild(fieldset);
        

        fieldset.querySelector('.removeReviewerBtn').addEventListener('click', () => {
            fieldset.remove();
            reviewerCount--;
        });
    });

});
</script>
@endsection