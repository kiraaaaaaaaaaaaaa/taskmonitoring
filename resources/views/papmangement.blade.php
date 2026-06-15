@extends('components.layout')

@section('content')


<div class="d-flex justify-content-between align-items-center mb-4">

    <a data-bs-toggle="modal" data-bs-target="#addPapModal" class="btn btn-success btn-label waves-effect waves-light rounded-pill mb-4">
        <i class="ri-add-fill label-icon align-middle rounded-pill fs-16 me-2"></i> Add PAP
    </a>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="card">

            <div class="card-body">
                <div class="listjs-table" id="customerList">
 
                    <div class="table-responsive table-card mt-3 mb-1">
                        <table class="table align-middle table-nowrap table-sm" id="customerTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="d-none">ID</th>
                                    <th class="">PAP/Task</th>
                                    {{-- <th class="">Division</th> --}}

                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                               @foreach($paps as $pap)
                              
                                <tr>
                                    <td class="d-none">{{$pap->id}}</td>
                                    <td class="bg-info-subtle">

                                        <div class="d-flex align-items-center justify-content-between">
                                            
                                            <span class="text-primary">
                                               {{ $pap->pap }}
                                            </span>

                                           
                                            <div class="dropdown">
                                                <a href="#" class="text-muted " data-bs-toggle="dropdown">
                                                    <i class="ri-more-fill"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#papModal{{$pap->id}}">Add Task</a>
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editpap{{$pap->id}}">Edit Task</a>
                                                        <div class="dropdown-divider"></div>
                                                        <form action="/papmangement/pap/{{$pap->id}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this PAP?');">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item text-danger">Delete this PAP</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                                @foreach($paptasks as $tasksss)
                                   @if($tasksss->papID == $pap->id)
                                <tr>
                                    <td class="d-none">{{$tasksss->id}}</td>
                                   
                                    <td>
                                        <div class="d-flex align-items-center justify-content-between">
                                            
                                            <span class=" px-5 fs-11">
                                               {{ $tasksss->tasks }}
                                            </span>

                                           
                                            <div class="dropdown">
                                                <a href="#" class="text-muted" data-bs-toggle="dropdown">
                                                    <i class="ri-more-fill"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edittasks{{$tasksss->id}}" >
                                                           
                                                        Edit Task
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                        <form action="/papmangement/task/{{$tasksss->id}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this tasks?');">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item text-danger">Delete this Tasks</button>
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
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end col -->
</div>

<!-- ================= add tasks ================= -->
<div>
    @foreach($paps as $pap)
    <form action="{{ route('createPAP') }}" method="POST">
        @csrf
        <div class="modal fade" id="papModal{{$pap->id}}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Add Task to {{$pap->pap}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="PAP" value="{{$pap->id}}" hidden>
                        <input type="text" name="task" class="form-control" placeholder="Enter Task" required>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" name="action" value="task">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endforeach
</div>





<!-- ================= NEW PAP MODAL ================= -->
<div>
    <!-- add pap modal -->
    <div class="modal fade" id="addPapModal" tabindex="-1" aria-labelledby="addPapModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPapModalLabel">New  PAP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('createPAP') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="papName" class="form-label">PAP Name <span class="text-danger">*</span></label>
                            <div class="flex-grow-1">
                                    
                                    <input type="text" class="form-control d-flex" id="PAPname" name="PAPname" required>
                                </div>
                        </div>
                       
                        
                        <div class="mb-3">
                           
                            <div class="flex-grow-1">
                                
                                <select class="form-select" id="sectorselect" name="sectorselect" hidden>
                                    <option value="" disabled selected>-- Select Sector --</option>
                                    <option value="{{ Auth::user()->sectorID }}"></option>
                                    
                                </select>

                            </div>
                            <div class="flex-grow-1">
                                <label for="divisionSelect" class="form-label">Assign Division <span class="text-danger">*</span></label>
                                <select class="form-select" id="divisionSelect" name="divisionSelect" required>
                                    <option value="" disabled selected>-- Select Division --</option>
                                    
                                </select>
                            </div>
                            
                        </div>

                        <div class="mb-3">
                            <div class="d-flex gap-2">
                                
                                <div class="flex-grow-1">
                                    <label for="funds" class="form-label">Fund Source <span class="text-danger">*</span></label>

                                    <select class="form-select" id="funds" name="funds" required>
                                     <option value="" disabled selected>-- Select Source of Fund --</option>
                                        @foreach($fund as $funds)
                                        <option value="{{ $funds->id }}">{{ $funds->fundName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="focal" class="form-label">Assign Focal <span class="text-danger">*</span></label>
                            <select class="form-select" id="focalSelect" name="focalSelect" required>
                                <option value="" disabled selected>-- Select Focal --</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="oosSelect" class="form-label">Output/Outcome Supported <span class="text-danger">*</span></label>
                            <select class="form-select" id="oosSelect" name="oosSelect" required>
                                <option value="" disabled selected>-- Select Output/Outcome --</option>
                                @foreach($oos as $user)
                                <option value="{{ $user->oosID }}">{{ $user->oosName }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="action" value="pap">Save Activity</button>
                        </div>
                </form>
            </div>
        </div>
    </div>



</div> 

<!-- ================= edit PAP ================= -->
 @foreach($paps as $pap)
<form action="{{ route('createPAP') }}" method="POST">
    @csrf
    <div class="modal fade" id="editpap{{$pap->id}}">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit PAP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <input type="text" name="PAP" value="{{$pap->id}}" hidden>
                        <input type="text" name="task" class="form-control" value="{{$pap->pap}}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" name="action" value="editpap">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endforeach

<!-- ==========================Edit tasks ====================== -->
@foreach($paptasks as $pap)
<form action="{{ route('createPAP') }}" method="POST">
    @csrf
    <div class="modal fade" id="edittasks{{$pap->id}}">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit PAP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <input type="text" name="PAP" value="{{$pap->id}}" hidden>
                        <input type="text" name="task" class="form-control" value="{{$pap->tasks}}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" name="action" value="edittask">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endforeach

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inputsector = document.getElementById('sectorselect');
    const inputdivision= document.getElementById('divisionSelect');
    const sector = {!! json_encode($sector) !!};
    const division = {!! json_encode($division) !!};

        inputsector.addEventListener('change', function () {

        const programID = this.value;

        inputdivision.innerHTML = '<option value="">--Select Division--</option>';

        division.forEach(div => {

            if(div.sectorID == programID){

                let option = document.createElement('option');
                option.value = div.id;
                option.textContent = div.division_name + "("+div.division_short_name+")";

                inputdivision.appendChild(option);

            }

        });

    });

    
         if (!inputsector.value) {
        inputsector.selectedIndex = 1; // selects first real option
    }

    inputsector.dispatchEvent(new Event('change'));

   
    });
</script>





@endsection
