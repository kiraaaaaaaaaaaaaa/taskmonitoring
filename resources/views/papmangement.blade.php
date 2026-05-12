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







@endsection
