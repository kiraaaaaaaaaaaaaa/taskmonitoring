@extends('components.layout')

@section('content')



<div class="d-flex justify-content-center align-items-center mb-4">
    {{-- PREVIOUS --}}
    <a href="{{ route('task disposition', [
        'year' => $Month == 1 ? $Year - 1 : $Year,
        'month' => $Month == 1 ? 12 : $Month - 1
    ]) }}" class="btn btn-outline-primary me-2">
        ◀
    </a>

    {{-- LABEL --}}
    <span class="fw-bold fs-5">
        {{ \Carbon\Carbon::create($Year, $Month, 1)->format('F Y') }}
    </span>

    {{-- NEXT --}}
    <a href="{{ route('task disposition', [
        'year' => $Month == 12 ? $Year + 1 : $Year,
        'month' => $Month == 12 ? 1 : $Month + 1
    ]) }}" class="btn btn-outline-primary ms-2">
        ▶
    </a>
</div>


{{-- <a href="{{ route('new task') }}" id="assignTaskBtn" class="btn btn-success btn-label waves-effect waves-light rounded-pill mb-4">
<i class="ri-add-fill label-icon align-middle rounded-pill fs-16 me-2"></i>
Assign Task
</a> --}}

<a data-bs-toggle="modal" id="assignTaskBtn" data-bs-target="#addPapModal" class="btn btn-success btn-label waves-effect waves-light rounded-pill mb-4">
    <i class="ri-add-fill label-icon align-middle rounded-pill fs-16 me-2"></i>
    Add Activity
</a>

@if($newtask->isEmpty())
<div class="alert alert-info" role="alert">
    No PAPs found for {{ \Carbon\Carbon::create($Year, $Month, 1)->format('F Y') }}.
</div>

@else

<div class="row g-4">
    <div class="row g-4">
        @foreach ($tasks as $task)



        <div class="col-12 col-md-6 col-xl-4">
            <div class="card h-80">
                <div class="card-body p-0">
                    <div class="alert alert-primary border-0 rounded-top rounded-0 m-0 d-flex align-items-center" role="alert">

                    </div>
                    <div class="card tasks-box border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between mb-2">

                                <h6 class="fs-15 mb-3 text-truncate">
                                    {{ $task->pap }}
                                </h6>

                                <div class="dropdown">
                                    <a href="#" class="text-muted" data-bs-toggle="dropdown">
                                        <i class="ri-more-fill"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>


                                            <a class="dropdown-item" href="/Task/task/{{$task->first_activity}}/{{$task->PAP}}">
                                                <i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                View
                                            </a>
                                        </li>
                                    </ul>
                                </div>


                            </div>

                            {{-- @php
                            $percent = ((float)$task->average_progress * 100);

                            $progressClass = $percent >= 80
                            ? 'bg-success'
                            : ($percent >= 50 ? 'bg-warning' : 'bg-danger');
                            @endphp

                            <div class="mb-2">
                                <span class="text-info fw-semibold">{{ number_format($percent, 2) }}%</span> of 100%
                        </div> --}}

                        {{-- <div class="progress progress-sm">
                                <div class="progress-bar {{ $progressClass }}" role="progressbar" style="width: {{ $percent }}%" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div> --}}

            </div>
        </div>

    </div>
</div>
</div>

@endforeach
</div>

</div>

@endif



<div class="row g-4 ">
    <div class="row g-4 ">

        @foreach ($newtask as $task)

        <div class="col-12 col-md-6 col-xl-4">
            <div class="card h-80 ">
                <div class="card-body p-0 ">
                    <div class="alert alert-primary border-0 rounded-top rounded-0 m-0 d-flex align-items-center  ribbon-box" role="alert">
                        @if(\Carbon\Carbon::parse($task->fromdate)->isPast())
                        <div class="ribbon-two ribbon-two-success"><span style="font-size: 8px;">Activity Done</span></div>
                        @elseif(\Carbon\Carbon::parse($task->fromdate)->isToday())
                        <span class="text-warning">(Day of Activity)</span>
                        @else
                        <span class="text-muted">
                            ({{ \Carbon\Carbon::parse($task->fromdate)->diffForHumans() }})
                        </span>
                        @endif
                    </div>
                    <div class="card tasks-box border-0 ">
                        <div class="card-body ">
                            <div class="d-flex align-items-start justify-content-between mb-2">

                                <h6 class="fs-15 mb-3 text-truncate" style="padding-top: 5px;">

                                    {{ $task->pap }}
                                </h6>


                                <div class="dropdown">
                                    <a href="#" class="text-muted" data-bs-toggle="dropdown">
                                        <i class="ri-more-fill"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="/Task.createtask/{{ $task->newID }}" id="addTaskBtn">
                                                <i class="ri-add-fill align-bottom me-2 text-muted"></i>
                                                Add Task
                                            </a>

                                            <form action="/Task/pap/{{ $task->newID }}" method="POST" style="display: inline;">
                                                @csrf
                                                
                                                <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to remove this PAP?')">
                                                    <i class="ri-subtract-fill align-bottom me-2 text-muted"></i>
                                                    Remove PAP
                                                </button>
                                            </form>
                                            <a class="dropdown-item editPapLink" id="editPapLinkbtn" href="#" data-bs-toggle="modal" data-bs-target="#editPapModal" data-id="{{ $task->newID }}" data-papid="{{ $task->papID }}" data-pap="{{ $task->pap }}" data-location="{{ $task->location }}" data-datefrom="{{ $task->fromdate }}" data-dateend="{{$task->todate}}" data-description="{{ $task->description }}">
                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                Edit PAP
                                            </a>


                                            <div class="dropdown-divider" id="dropdownDivider"></div>

                                            <a class="dropdown-item" href="/Task/task/{{$task->fromdate}}/{{$task->newID}}">
                                                <i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                View
                                            </a>


                                        </li>
                                    </ul>
                                </div>


                            </div>
                            <p class="fs-11 mb-3 text-truncate">
                                {{ $task->location }} | {{ \Carbon\Carbon::parse($task->fromdate)->format('F d ') }} to {{ \Carbon\Carbon::parse($task->todate)->format(' d, Y') }}
                               


                            </p>





                        </div>
                    </div>

                </div>
            </div>
        </div>

        @endforeach
    </div>

</div>



<div>
    <!-- add pap modal -->
    <div class="modal fade" id="addPapModal" tabindex="-1" aria-labelledby="addPapModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPapModalLabel">New  Activity</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('savePAP') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="papName" class="form-label">PAP Name <span class="text-danger">*</span></label>
                            <select class="form-select" id="papName" name="pap" required>
                                <option value="" disabled selected>-- Select PAP --</option>
                                @foreach($papOptions as $option)
                                <option value="{{ $option->id }}">{{ $option->pap }}</option>
                                @endforeach
                                <option value="addpap" data-bs-toggle="modal" data-bs-target="#addPapModals" data-bs-dismiss="modal">--Add PAP--</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-body-tertiary"><i>(Optional)</i></span></label>
                            <input type="text" class="form-control" id="description" name="description">
                        </div>
                        <div class="mb-3">
                            <label for="indicativeDate" class="form-label">Indicative Date <span class="text-danger">*</span></label>
                            <div class="d-flex gap-2">
                                <div class="input-group">
                                    <label for="indicativeDate" class="input-group-text">From</label>
                                    <input type="date" class="form-control" id="indicativeDate" name="datefrom" required>
                                </div>
                                <div class="input-group">
                                    <label for="indicativeDateEnd" class="input-group-text">To</label>
                                    <input type="date" class="form-control" id="indicativeDateEnd" name="dateend" required>
                                </div>
                            </div>
                        </div>
                       

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Activity</button>
                        </div>
                </form>
            </div>
        </div>
    </div>



</div>

<form action="{{ route('createPAP') }}" method="POST">
    @csrf
    <div class="modal fade" id="addPapModals">
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

{{-- edit pap modal --}}

<div>
    <div class="modal fade" id="editPapModal" tabindex="-1" aria-labelledby="addPapModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPapModalLabel">Edit Activity</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('savePAP') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="papName" class="form-label">PAP Name</label>
                            <input type="hidden" id="editpapid" name="editpapid">
                            <input type="hidden" id="editpapids" name="editpapids">
                            <input type="text" class="form-control" id="editpapName" name="editpapName" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="editdescription" class="form-label">Description</label>
                            <input type="text" class="form-control" id="editdescription" name="editdescription">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Indicative Date</label>
                            <div class="d-flex gap-2">
                                <div class="input-group">
                                    <label for="editindicativeDate" class="input-group-text">From</label>
                                    <input type="date" class="form-control" id="editindicativeDate" name="editdatefrom">
                                </div>
                                <div class="input-group">
                                    <label for="editindicativeDateEnd" class="input-group-text">To</label>
                                    <input type="date" class="form-control" id="editindicativeDateEnd" name="editdateend">
                                </div>
                            </div>
                        </div>
                         
                        <div class="mb-3">

                            <div class="d-flex gap-2">
                                <div class="flex-grow-1">
                                    <label for="editlocation" class="form-label">Location</label>
                                    <input type="text" class="form-control" id="editlocation" name="editlocation">
                                </div>
                                
                            </div>
                        </div>


                        

                      
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Activity</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



</div>


@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userType = @json(Auth::user()-> usertype);
        const assignTaskBtn = document.getElementById('assignTaskBtn');
        const addTaskBtn = document.getElementById('addTaskBtn');
        const editPapLinkBtn = document.getElementById('editPapLinkbtn');
        const deletePapBtn = document.getElementById('deletepapbtn');
        const dropdownDivider = document.getElementById('dropdownDivider');
        if (userType === '2') {
            assignTaskBtn.style.display = 'none';
            addTaskBtn.style.display = 'none';
            editPapLinkBtn.style.display = 'none';
            deletePapBtn.style.display = 'none';
            dropdownDivider.style.display = 'none';
        }

        


        document.querySelectorAll('.editPapLink').forEach(link => {
            link.addEventListener('click', function() {


                const papId = this.getAttribute('data-id');
                const papName = this.getAttribute('data-pap');
                const location = this.getAttribute('data-location');
                const dateFrom = this.getAttribute('data-datefrom');
                const dateEnd = this.getAttribute('data-dateend');
                const description = this.getAttribute('data-description');
                const focalPerson = this.getAttribute('data-focal');



                document.getElementById('editpapid').value = papId;
                document.getElementById('editpapName').value = papName;
                document.getElementById('editlocation').value = location;
                document.getElementById('editindicativeDate').value = dateFrom;
                document.getElementById('editindicativeDateEnd').value = dateEnd;
                document.getElementById('editdescription').value = description;
                
            });
        });

        document.getElementById("papName").addEventListener("change", function(){

        if(this.value === "addpap"){

                let modal = new bootstrap.Modal(document.getElementById("addPapModals"));
                modal.show();

                this.value = ""; // reset select

            }

        });

                             

   

    });

</script>
