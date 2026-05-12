@extends('components.layout')

@section('content')



<form action="">

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
                        <label for="EndleaveDate" class="form-label">Activity Date</label>
                        <input type="date" class="form-control" value="{{$fromtask->activitydate}}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="EndleaveDate" class="form-label">Due Date</label>
                        <input type="date" class="form-control" value="{{$fromtask->duedate}}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="VertimeassageInput" class="form-label">Notes</label>
                        <textarea class="form-control" id="note" rows="3" placeholder="Enter your message"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="EndleaveDate" class="form-label">File link</label>
                         <div class="input-group">
                            <input type="text" class="form-control" id="fileLink" value="{{$fromtask->link}}">
                            
                            <a href="{{ $fromtask->link }}"
   class="btn btn-info ri-link"
   target="_blank">
</a>
                        
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label fw-bold">Reviewer</label>
                            <input value="{{$fromtask->rv1}}" class="form-control" onkeydown="return false " />
                        </div>
                        <div class="col">
                            <label class="form-label fw-bold">Status</label>
                            <input value="{{$fromtask->status1}}" class="form-control" onkeydown="return false " />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">

                            <input value="{{$fromtask->rv2}}" id="r2" class="form-control" onkeydown="return false " />
                        </div>
                        <div class="col">

                            <input value="{{$fromtask->status2}}" id="s2" class="form-control" onkeydown="return false " />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">

                            <input value="{{$fromtask->rv3}}" id="r3" class="form-control" onkeydown="return false " />
                        </div>
                        <div class="col">

                            <input value="{{$fromtask->status3}}" id="s3" class="form-control" onkeydown="return false " />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">

                            <input value="{{$fromtask->rv4}}" id="r4" class="form-control" onkeydown="return false " />
                        </div>
                        <div class="col">

                            <input value="{{$fromtask->status4}}" id="s4" class="form-control" onkeydown="return false " />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">

                            <input value="{{$fromtask->rv5}}" id="r5" class="form-control" onkeydown="return false " />
                        </div>
                        <div class="col">

                            <input value="{{$fromtask->status5}}" id="s5" class="form-control" onkeydown="return false " />
                        </div>
                    </div>

                </div>
            </div>
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
                        <input  class="form-control " value="{{$fromtask->programname}}" readonly>

                        <label class="form-label fs-11">Subprogram</label>
                        <input  class="form-control " value="{{$fromtask->subprogramname}}" readonly>

                        <label  class="form-label fs-11">OBEX</label>
                        <input class="form-control " value="{{$fromtask->mooeName}}" readonly>
                    </div>

                   <hr class="border-3 border-dark my-4">
                        
                     <div class="card-body p-4 p-md-3 card-header">
                   
                    <div class="mb-2">
                        <label for="employeeName" class="form-label">Obligated amount</label>
                        <div class="input-group">
                        <label class="input-group-text">₱ </label>
                        <input class="form-control text-end" value="{{number_format($fromtask->obligatedbudget,2)}}" readonly>
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

   

</script>

@endsection
