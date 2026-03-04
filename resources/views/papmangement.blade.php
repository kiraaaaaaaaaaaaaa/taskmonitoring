@extends('components.layout')

@section('content')


<div class="d-flex justify-content-between align-items-center mb-4">

    <a data-bs-toggle="modal" data-bs-target="#addPapModal" class="btn btn-success rounded-pill">
        <i class="ri-add-fill me-2"></i> Add PAP
    </a>
</div>

<div class="d-flex flex-wrap gap-3">

    @foreach($paps as $pap)

    <div class="card flex-fill" style="min-width: 280px; max-width: 100%;">

        <div class="card-body p-0 d-flex flex-column">

            <!-- Header -->
            <div class="alert alert-primary border-0 rounded-top m-0">
                <h5 class="mb-0 text-truncate">
                    {{$pap->pap}}
                    <button type="button" class="btn btn-sm float-end dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#papModal{{$pap->id}}">Add Task</a>
                        {{-- <a class="dropdown-item" href="#">Edit Task</a> --}}
                        <div class="dropdown-divider"></div>
                        <form action="/papmangement/{{$pap->id}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this PAP?');">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">Delete this PAP</button>
                        </form>
                    </div>
                </h5>
                

                    
                

            </div>

            <!-- Content Area -->
            <div class="flex-grow-1 overflow-auto p-3">
            
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2">

                        @foreach($tasksByPap as $papID => $tasks)
                        @if($papID == $pap->id)
                        @foreach($tasks as $task)
                        <span class="badge bg-secondary">{{ $task['tasks'] }}</span>
                        @endforeach
                        @endif
                        @endforeach



                    </div>
                </div>

            </div>

        </div>
    </div>

    @endforeach

</div>

<!-- ================= PAP MODAL ================= -->
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







@endsection
