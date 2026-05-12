@extends('components.layout')

@section('content')



<form action="{{ route('updatetask') }}" method="POST" id="updateTaskForm">
@csrf
<a href="javascript:history.back()"
   class="btn btn-secondary btn-label waves-effect waves-light rounded-pill mb-4">
    <i class="ri-arrow-left-s-line label-icon align-middle rounded-pill fs-16 me-2"></i>
    Back
</a>
    </div>
    <div class="row justify-content-center">
        <div class=" col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4 p-md-5 ">
                
                       
                    <input class="form-control" name="id" value="{{$fromtask->id}}" hidden>
                   
                    <div class="mb-3">
                        <label for="employeeName" class="form-label">PAP</label>
                        <input type="text" class="form-control" value="{{$fromtask->pap}}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="employeeUrl" class="form-label">Task</label>
                        <input type="text" class="form-control" value="{{$fromtask->tasks}}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="StartleaveDate" class="form-label">Assigned Personnel</label>
                        <input type="text" class="form-control" value="{{$fromtask->Assigned}}" readonly>
                    </div>
                
                    <div class="mb-3">
                        <label for="EndleaveDate" class="form-label">Indicative Date</label>
                        <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($fromtask->papdate)->format('F d') }} to {{ \Carbon\Carbon::parse($fromtask->papdateend)->format('d, Y') }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="EndleaveDate" class="form-label">Target Date of Accomplishment</label>
                        <input type="date" class="form-control" value="{{$fromtask->duedate}}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="VertimeassageInput" class="form-label">Notes</label>
                        <textarea class="form-control" id="note" name="note" rows="3" >{{$fromtask->note}}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="VertimeassageInput" class="form-label">Link</label>
                        <input type="url" id="filelink" name="link" class="form-control" value="{{$fromtask->link}}">
                    </div>
                    

                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label fw-bold">Reviewer</label>
                            <input value="{{$fromtask->rv1}}" class="form-control" onkeydown="return false " />
                        </div>
                        <div class="col">
                            <label class="form-label fw-bold">Status</label>
                            <select class="form-control" name="status1">
                                <option  value="{{$fromtask->status1}}">{{$fromtask->status1}}</option>
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                                <option value="Not Applicable">Not Applicable</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">

                            <input value="{{$fromtask->rv2}}" id="r2" class="form-control" onkeydown="return false " />
                        </div>
                        <div class="col">

                            <select class="form-control" id="s2" name="status2">
                                <option  value="{{$fromtask->status2}}">{{$fromtask->status2}}</option>
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                                <option value="Not Applicable">Not Applicable</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">

                            <input value="{{$fromtask->rv3}}" id="r3" class="form-control" onkeydown="return false " />
                        </div>
                        <div class="col">

                            <select class="form-control" id="s3" name="status3">
                              <option  value="{{$fromtask->status3}}">{{$fromtask->status3}}</option>
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                                <option value="Not Applicable">Not Applicable</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">

                            <input value="{{$fromtask->rv4}}" id="r4" class="form-control" onkeydown="return false " />
                        </div>
                        <div class="col">

                             <select class="form-control" id="s4" name="status4">
                                <option  value="{{$fromtask->status4}}">{{$fromtask->status4}}</option>
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                                <option value="Not Applicable">Not Applicable</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">

                            <input value="{{$fromtask->rv5}}" id="r5" class="form-control" onkeydown="return false " />
                        </div>
                        <div class="col">

                             <select class="form-control" id="s5" name="status5">
                               <option  value="{{$fromtask->status5}}">{{$fromtask->status5}}</option>
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                                <option value="Not Applicable">Not Applicable</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
                <button class="btn btn-primary float-end rounded-pill" type="submit">
                    <i class="ri-save-line label-icon align-middle rounded-pill fs-16 me-2"></i> Save  
                </button>
        </div>

        <div class="col-md-3 col-lg-3">
            <div class="card shadow-lg border-0 rounded-4 ">
                <div class="card-header bg-transparent  fw-bold py-2 px-3 rounded-10">
                    Obligation Details
                </div>
                <div class="card-body p-4 p-md-3 card-header">

                    
                        <label for="employeeName" class="form-label">Allocated from</label>
                        
                        <br>
                        <label class="form-label fs-11">Program</label>
                        <select class="form-control"name="program" id="program">
                            <option value="{{$fromtask->program_id}}">{{$fromtask->programname}}</option>
                            @foreach($program as $programsoption)
                                <option value="{{$programsoption->id}}">{{$programsoption->programname}}</option>
                            @endforeach
                            
                        </select>
                        <label class="form-label fs-11">Subprogram</label>
                        <select class="form-control"name="subprogram" id="subprogram">
                           <option value="{{$fromtask->subprogram_id}}">{{$fromtask->subprogramname}}</option>
                        </select>
                        <label  class="form-label fs-11">OBEX</label>
                        <select class="form-control"name="mooe" id="mooe">
                           <option value="{{$fromtask->mooeID}}">{{$fromtask->mooeName}}</option>
                        </select>
                    </div>

                   <hr class="border-3 border-dark my-4">
                        
                     <div class="card-body p-4 p-md-3 card-header">
                   
                    <div class="mb-2">
                        <label for="employeeName" class="form-label">Obligated amount</label>
                        <div class="input-group">
                        <label class="input-group-text">₱ </label>
                        <input type="number" class="form-control text-end" name="budget" value="{{$fromtask->obligatedbudget}}">
                        </div>
                    </div>
                    

                </div>
            </div>
  
        </div>

   


    </div>


</form>

<script>
    const pairs = [
        { r: "r2", s: "s2", status: @json($fromtask->status2) },
        { r: "r3", s: "s3", status: @json($fromtask->status3) },
        { r: "r4", s: "s4", status: @json($fromtask->status4) },
        { r: "r5", s: "s5", status: @json($fromtask->status5) },
    ];

    pairs.forEach(item => {
        const r = document.getElementById(item.r);
        const s = document.getElementById(item.s);
        const status = (item.status ?? "").trim();

        if (!r || !s) return;

        if (status === "Not Applicable" || r.value === "Not Applicable" || r.value === "") {
            r.style.display = "none";
            s.style.display = "none";
        }
    });


document.addEventListener('DOMContentLoaded', () => {

   

    const inputprogram = document.getElementById('program');
    const inputsubprogram = document.getElementById('subprogram');
    const inputmooe = document.getElementById('mooe');

    const program = {!! json_encode($program) !!};
    const subprogram = {!! json_encode($subprogram) !!};
    const mooe = {!! json_encode($mooe) !!};


    inputprogram.addEventListener('change', function () {

        const programID = this.value;

        inputsubprogram.innerHTML = '<option value="">--Select Subprogram--</option>';

        subprogram.forEach(sub => {

            if(sub.programID == programID){

                let option = document.createElement('option');
                option.value = sub.id;
                option.textContent = sub.subprogramname;

                inputsubprogram.appendChild(option);

            }

        });

        inputmooe.innerHTML = '<option value="">--Select OBEX--</option>';

    });


    inputsubprogram.addEventListener('change', function () {

        const subprogramID = this.value;

        inputmooe.innerHTML = '<option value="">--Select OBEX--</option>';

        mooe.forEach(ob => {

            if(ob.subprogramID == subprogramID){

                let option = document.createElement('option');
                option.value = ob.mooeID;
                option.textContent = ob.mooeName;

                inputmooe.appendChild(option);

            }

        });

    });

});
</script>




@endsection
