@extends('components.layout')

@section('content')

<a data-bs-toggle="modal" data-bs-target="#showModal" class="btn btn-success btn-label waves-effect waves-light rounded-pill mb-4">
    <i class="ri-add-fill label-icon align-middle rounded-pill fs-16 me-2"></i>
    Add Program
</a>


<div class="row">
    <div class="col-lg-12">
        <div class="card">



            <div class="card-body">
                <div class="listjs-table" id="customerList">
                    <div class="row g-4 mb-3">


                    </div>

                    <div class="table-responsive table-card mt-3 mb-1">
                        <table class="table align-middle table-nowrap table-sm" id="customerTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="d-none">ID</th>
                                    <th class="">Program/Sub-program/OBEX (FY: {{date('Y')}})</th>
                                    {{-- <th class="">Division</th> --}}

                                </tr>
                            </thead>
                            <tbody class="list form-check-all"> 
                                @foreach($program as $sectors)
                                <tr class="bg-info-subtle text-primary">


                                    <td class="d-none">{{$sectors->id}}</td>
                                    <td>
                                    <div class="d-flex align-items-center justify-content-between">
                                        {{$sectors->programname}}


                                        <div class="dropdown float-end">
                                            <a href="#" class="text-muted" data-bs-toggle="dropdown">
                                                <i class="ri-more-fill"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#divisionModal{{$sectors->id}}">Add Sub-program</a>
                                                    <a class="dropdown-item" href="#"
                                                        data-id="{{ $sectors->id }}"
                                                        data-secname="{{ $sectors->programname }}"
                                                       
                                                        data-bs-toggle="modal" data-bs-target="#showModal">
                                                    Edit Program
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <form action="{{ route('deleteprogram', $sectors->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Program?');">
                                                    @csrf 
                                                    <button type="submit" class="dropdown-item text-danger">Delete this Program</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                        </div>

                                    </td>
                                </tr>
                                        @foreach($subprogram as $division)
                                        @if($division->programID === $sectors->id)
                                <tr class="bg-primary-subtle fs-10">
                                    <td>

                                        <div class="d-flex align-items-center justify-content-between">
                                            
                                            <span class="fs-11 px-3">
                                               {{ $division->subprogramname }}
                                            </span>

                                           
                                            <div class="dropdown">
                                                <a href="#" class="text-muted" data-bs-toggle="dropdown">
                                                    <i class="ri-more-fill"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#subprogramModal{{$division->id}}">Add OBEX</a>
                                                        <a class="dropdown-item" href="#"
                                                            data-divid="{{ $division->id }}"
                                                            data-sectorid="{{ $division->programID }}"
                                                            data-divisionname="{{ $division->subprogramname }}"
                                                            
                                                            data-bs-toggle="modal" data-bs-target="#divisionModals">
                                                        Edit Sub-program
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                        <form action="{{ route('deletesubprogram', $division->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Sub-program?');">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item text-danger">Delete this Sub-program</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <br>
                                        

                                    </td>


                                </tr>
                                <tr>
                                    <td><span class="fs-11 px-3">MOOE</span></td>
                                </tr>
                                @foreach($mooe as $mooes)
                                        @if($mooes->subprogramID === $division->id && $mooes->type == 0)
                                <tr>
                                    <td>

                                        

                                        <div class="d-flex align-items-center justify-content-between">
                                            
                                            <span class="fs-11 px-5">
                                               {{ $mooes->mooeName }}
                                            </span>

                                           
                                            <div class="dropdown">
                                                <a href="#" class="text-muted" data-bs-toggle="dropdown">
                                                    <i class="ri-more-fill"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            data-obexid="{{ $mooes->mooeID }}"
                                                            data-subid="{{ $mooes->subprogramID }}"
                                                            data-obexname="{{ $mooes->mooeName }}"
                                                            
                                                            data-bs-toggle="modal" data-bs-target="#obexModals">
                                                        Edit OBEX
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                        <form action="{{ route('deleteobex', $mooes->mooeID) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this OBEX?');">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item text-danger">Delete this OBEX</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <br>
                                        

                                    </td>


                                </tr>
                                @endif
                                @endforeach

                                <tr>
                                    <td><span class="fs-11 px-3">CO</span></td>
                                </tr>
                                @foreach($mooe as $mooes)
                                        @if($mooes->subprogramID === $division->id && $mooes->type == 1)
                                <tr>
                                    <td>

                                        

                                        <div class="d-flex align-items-center justify-content-between">
                                            
                                            <span class="fs-11 px-5">
                                               {{ $mooes->mooeName }}
                                            </span>

                                           
                                            <div class="dropdown">
                                                <a href="#" class="text-muted" data-bs-toggle="dropdown">
                                                    <i class="ri-more-fill"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            data-obexid="{{ $mooes->mooeID }}"
                                                            data-subid="{{ $mooes->subprogramID }}"
                                                            data-obexname="{{ $mooes->mooeName }}"
                                                            
                                                            data-bs-toggle="modal" data-bs-target="#obexModals">
                                                        Edit OBEX
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                        <form action="{{ route('deleteobex', $mooes->mooeID) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this OBEX?');">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item text-danger">Delete this OBEX</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <br>
                                        

                                    </td>


                                </tr>
                                @endif
                                @endforeach
                                
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

<!-- add program -->
<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">PROGRAM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <form action="{{route('storeprogram')}}" method="POST" id="sectorform">
                @csrf
                <div class="modal-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="mb-3" id="modal-id" style="display: none;">
                        <label for="id-field" class="form-label">ID</label>
                        <input type="text" id="secid-field" name="id" class="form-control" placeholder="ID" readonly="">
                    </div>

                    <div class="mb-3">
                        <label for="customername-field" class="form-label">Name</label>
                        <input type="text" id="secname-field" name="secname" class="form-control" placeholder="Enter Name" required="">
                        <div class="invalid-feedback">Please enter a name.</div>
                    </div>

                    


                </div>
                <div class="modal-footer" style="display: block;">
                    <div class="hstack gap-2 justify-content-end">
                        {{-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> --}}
                        <button type="submit" class="btn btn-success">Save</button>
                        <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= add subprogram MODAL ================= -->
<div>
    @foreach($program as $sectors)
    <form action="{{ route('storesubprogram') }}" method="POST">
        @csrf
        <div class="modal fade" id="divisionModal{{$sectors->id}}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Add Sub-program to {{$sectors->programname}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text"  name="subid" value="{{$sectors->id}}" hidden>
                        <input type="text"  name="subname" class="form-control mb-2" placeholder="Enter Sub-program Name" required>
                       
                    </div>
                    <div class="modal-footer">

                        <button class="btn btn-success" name="action" value="division">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endforeach

<div>

<!-- ================= add obex MODAL ================= -->
<div>
    @foreach($subprogram as $sectors)
    <form action="{{ route('storeobex') }}" method="POST">
        @csrf
        <div class="modal fade" id="subprogramModal{{$sectors->id}}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Add OBEX to {{$sectors->subprogramname}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text"  name="obexID" value="{{$sectors->id}}" hidden>
                        <input type="text"  name="obexname" class="form-control mb-2" placeholder="Enter OBEX" required>
                        <br>
                        <input type="radio" name="type" value="0"> MOOE <br>
                        <input type="radio" name="type" value="1"> Capital Outlay
                       
                    </div>
                    <div class="modal-footer">

                        <button class="btn btn-success" name="action" value="division">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endforeach

<div>

<!-- ================= EDIT DIVISION MODAL ================= -->
    <form action="{{ route('storesubprogram') }}" method="POST">
        @csrf
        <div class="modal fade" id="divisionModals">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Edit Sub-program</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="divisionID-field" name="editsubid" hidden>
                        <input type="text" id="sectorID-field" name="editprogid" hidden>
                        <input type="text" id="divisionname-field" name="editsubname" class="form-control mb-2" placeholder="Enter Division Name" required>
                        
                    </div>
                    <div class="modal-footer">

                        <button class="btn btn-success" name="action" value="division">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- ================= EDIT OBEX MODAL ================= -->
    <form action="{{ route('storeobex') }}" method="POST">
        @csrf
        <div class="modal fade" id="obexModals">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Edit OBEX</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="obexID-field" name="editobexid" hidden>
                        <input type="text" id="subID-field" name="editsubid" hidden>
                        <input type="text" id="obexname-field" name="editobexname" class="form-control mb-2" placeholder="Enter Division Name" required>
                        
                    </div>
                    <div class="modal-footer">

                        <button class="btn btn-success" name="action" value="division">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {

            var userModal = document.getElementById("showModal");
            var divisionModal = document.getElementById("divisionModals");
            var obexModal = document.getElementById("obexModals")

            userModal.addEventListener("show.bs.modal", function(event) {

                var button = event.relatedTarget;

                document.getElementById("secid-field").value =
                    button.getAttribute("data-id");

                document.getElementById("secname-field").value =
                    button.getAttribute("data-secname");

           

              

                // Password intentionally left blank for security

            });
            divisionModal.addEventListener("show.bs.modal", function(event) {

                var button = event.relatedTarget;

                
                document.getElementById("divisionID-field").value =
                    button.getAttribute("data-divid");

                document.getElementById("sectorID-field").value =
                    button.getAttribute("data-sectorid");

                document.getElementById("divisionname-field").value =
                    button.getAttribute("data-divisionname");

               

            });

            obexModal.addEventListener("show.bs.modal", function(event) {

                var button = event.relatedTarget;

                
                document.getElementById("obexID-field").value =
                    button.getAttribute("data-obexid");

                document.getElementById("subID-field").value =
                    button.getAttribute("data-subid");

                document.getElementById("obexname-field").value =
                    button.getAttribute("data-obexname");

               

            });

        });

    </script>
    @endsection
