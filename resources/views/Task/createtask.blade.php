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

                        <h4>PAP</h4>

                        <div class="mb-3">
                            <label class="form-label">Select PAP</label>
                            <select class="form-select" id="papselect" name="PAP">
                                <option value="">-- Choose PAP --</option>
                                @foreach($paps as $pap)
                                <option value="{{ $pap->id }}">{{ $pap->pap }}</option>
                                @endforeach
                                <option value="newpap">-- Add new PAP --</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Select Task(s)</label>
                            <select id="paptask" name="tasks[]" class="form-control" multiple>

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

                        <div class="mb-3">
                            <label class="form-label">Preparer</label>
                            <select class="form-select" name="preparer">
                                <option value="">-- Choose Personnel --</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Activity Date</label>
                                <input type="date" class="form-control" name="activitydate">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Due Date</label>
                                <input type="date" class="form-control" name="duedate">
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ================= REVIEWERS ================= -->
                <div class="card shadow rounded-4 mb-4">
                    <div class="card-body">
                        <h4>Reviewers</h4>

                        @for($i=1; $i<=5; $i++) <fieldset class="border rounded p-3 mb-3">
                            <legend class="w-auto px-2">Reviewer {{ $i }}</legend>

                            <div class="row g-2">
                                <div class="col-md-6">
                                    <select id="reviewer{{ $i }}" class="form-select" name="reviewer{{ $i }}">
                                        <option value="">-- Choose Reviewer --</option>
                                        @foreach($users as $user)
                                        @if(in_array($user->usertype, ['Reviewer','Supervisor']))
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <input type="date" id="date{{ $i }}" class="form-control" name="returneddate{{ $i }}">
                                </div>

                                <div class="col-md-2 d-flex align-items-center">
                                    <input type="checkbox" onclick="toggleReviewerFields({{ $i }})">
                                    <input type="hidden" id="st{{ $i }}" name="status{{ $i }}" value="Pending">
                                </div>
                            </div>
                            </fieldset>
                            @endfor

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
                    <label class="form-label">Select PAP</label>
                    <select class="form-select" id="papselect" name="PAP">
                        <option value="">-- Choose PAP --</option>
                        @foreach($paps as $pap)
                        <option value="{{ $pap->id }}">{{ $pap->pap }}</option>
                        @endforeach
                        <option value="newpap">-- Add new PAP --</option>
                    </select>
                    <br>
                    <input type="text" name="task" class="form-control" placeholder="Enter PAP" required>
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

        const papSelect = document.getElementById('papselect');
        const taskSelect = document.getElementById('paptask');

        const choices = new Choices(taskSelect, {
            removeItemButton: true
            , placeholderValue: 'Select task(s)'
            , shouldSort: false
        });

        const tasksByPap = @json($tasksByPap);

        /* PAP change */
        papSelect.addEventListener('change', () => {
            const papId = papSelect.value;

            if (papId === 'newpap') {
                papSelect.selectedIndex = 0;
                new bootstrap.Modal(document.getElementById('addPapModal')).show();
                return;
            }

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
        });

        taskSelect.addEventListener('change', () => {
            const papId = taskSelect.value;

            if (papId === 'newtask') {
                papSelect.selectedIndex = 0;
                new bootstrap.Modal(document.getElementById('addTaskpModal')).show();
                return;
            }
        });

        /* Reviewer toggle */
        window.toggleReviewerFields = (i) => {
            const r = document.getElementById('reviewer' + i);
            const d = document.getElementById('date' + i);
            const s = document.getElementById('st' + i);

            const disabled = !r.disabled;
            r.disabled = disabled;
            d.disabled = disabled;
            s.value = disabled ? 'Not Applicable' : 'Pending';
        };

    });

</script>
@endsection
