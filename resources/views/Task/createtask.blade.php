@extends('components.layout')

@section('content')

<form action="{{ route('store') }}" method="POST">
    @csrf

    <a href="javascript:history.back()" class="btn btn-secondary rounded-pill mb-4">
        <i class="ri-arrow-left-s-line me-2"></i> Back
    </a>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <!-- ================= PAP ================= -->
                <div class="card shadow rounded-4 mb-4">
                    <div class="card-body">

                   

                        <div class="mb-3">
                            <input  id="papID" value="{{ $newpap->papID}}" name="papID" hidden>
                            <input  id="papID" name="PAP" value="{{ $newpap->id}}" hidden>
                            <input type="text" id="pap" name="pap" class="form-control" value="{{ $newpap->pap ?? '' }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Select Task(s)</label>
                            <select id="paptask" name="tasks[]" class="form-control" multiple>
                            <option value="newtask">-- Add new Task --</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Assigned to</label>
                            <select class="form-select" name="assigned">
                                <option value="">-- Choose Personnel --</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- <div class="mb-3">
                            <label class="form-label">Preparer</label>
                            <select class="form-select" name="preparer">
                                <option value="">-- Choose Personnel --</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div> --}}

                        <div class="row">
                           
                                <input type="date" class="form-control" name="activitydate" value="{{ $newpap->fromdate}}" hidden>
                            
                            <div class="col-md-6 mb-3">
                                <label>Target Date of Completion</label>
                                <input type="date" class="form-control" name="duedate">
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ================= REVIEWERS ================= -->
                <div class="card shadow rounded-4 mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4>Reviewer(s)</h4>
                        <button type="button" class="btn btn-sm btn-success rounded-pill mb-3" id="addReviewerBtn">
                            <i class="ri-add-line me-2"></i> Add Reviewer
                        </button>
                        </div>

                        <div id="reviewersContainer">
                        @php
                            $reviewerCount = 1; // Set the maximum number of reviewer
                        @endphp
                        @for($i=01; $i<=$reviewerCount; $i++) 
                        
                        
                        <fieldset class="border rounded p-3 mb-3">
                            

                            <div class="row g-2">
                                <div class="col-md-6">
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
                                    <input type="date" id="date{{ $i }}" class="form-control" name="returneddate{{ $i }}">
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <label class="ms-2 form-label fs-10 px-1 mb-0">Not Applicable</label>
                                    <div class="col-md-2 d-flex align-items-center">
                                 
                                        <input type="checkbox" onclick="toggleReviewerFields({{ $i }})">
                                   
                                        <input type="hidden" id="st{{ $i }}" name="status{{ $i }}" value="Pending">
                                    </div>
                                </div>
                            </div>
                            </fieldset>
                            @endfor
                            </div>

                    </div>
                </div>

                <button class="btn btn-primary float-end rounded-pill">
                    <i class="ri-save-line me-2"></i> Save
                </button>

            </div>
        </div>
    </div>
</form>

<!-- ================= PAP MODAL ================= -->
<form action="{{ route('createPAP') }}" method="POST">
    @csrf
    <div class="modal fade" id="addPapModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>New PAP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="pap" class="form-control" placeholder="Enter PAP" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" name="action" value="pap">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form action="{{ route('createPAP') }}" method="POST">
    @csrf
    <div class="modal fade" id="addTaskpModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>New Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="papID" name="PAP" value="{{ $newpap->papID}}">
                    <br>
                    <input type="text" name="task" class="form-control" placeholder="Enter Task" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" name="action" value="task">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    // Hidden PAP input
    const papInput = document.getElementById('papID');
    const taskSelect = document.getElementById('paptask');
    const addreviewer = document.getElementById('addReviewerBtn');

    // Choices.js
    const choices = new Choices(taskSelect, {
        removeItemButton: true,
        placeholderValue: 'Select task(s)',
        shouldSort: false
    });

    // Tasks by PAP (make sure this exists in your controller)
    const tasksByPap = {!! json_encode($tasksByPap) !!};

    // Populate tasks based on PAP
    function populateTasks(papId) {
        choices.clearChoices();

        if (!tasksByPap[papId]) return;

        choices.setChoices(
                [
                    ...tasksByPap[papId].map(task => ({
                        value: task.id
                        , label: task.tasks
                    }))
                    , {
                        value: 'newtask'
                        , label: '-- Add New Task --'
                    } // extra option
                ]
                , 'value'
                , 'label'
                , true
            );

        choices.removeActiveItems();
    }

    // Initial load
    populateTasks(papInput.value);

    // Task change event
    taskSelect.addEventListener('change', () => {
        const selectedValues = choices.getValue(true); // safer for multiple

        if (selectedValues.includes('newtask')) {
            choices.removeActiveItems();
            new bootstrap.Modal(document.getElementById('addTaskpModal')).show();
        }
    });

    // Reviewer toggle
    window.toggleReviewerFields = (i) => {
        const r = document.getElementById('reviewer' + i);
        const d = document.getElementById('date' + i);
        const s = document.getElementById('st' + i);

        const disabled = !r.disabled;
        r.disabled = disabled;
        d.disabled = disabled;
        s.value = disabled ? 'Not Applicable' : 'Pending';
    };



    const reviewersContainer = document.getElementById('reviewersContainer');
    let reviewerCount = document.querySelectorAll('[id^="reviewer"]').length;

    addReviewerBtn.addEventListener('click', () => {
        reviewerCount++;
        if (reviewerCount > 6) {
            alert('Maximum of 5 reviewers allowed.');
            reviewerCount--;
            return;
        }

        const fieldset = document.createElement('fieldset');
        fieldset.classList.add('border', 'rounded', 'p-3', 'mb-3');
        fieldset.innerHTML = `
            <div class="row g-2 align-items-center">
                <div class="col-md-5">
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
                    <input type="date" id="date${reviewerCount}" class="form-control" name="returneddate${reviewerCount}">
                </div>

                <div class="col-md-3 d-flex align-items-center">
                    <button type="button" class="btn btn-danger btn-sm removeReviewerBtn">Remove</button>
                </div>
            </div>
        `;

        reviewersContainer.appendChild(fieldset);

        // Remove functionality
        fieldset.querySelector('.removeReviewerBtn').addEventListener('click', () => {
            fieldset.remove();
            reviewerCount--;
        });
    });



});
</script>
@endsection