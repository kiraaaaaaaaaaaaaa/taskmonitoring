@extends('components.layout')

@section('content')

<a data-bs-toggle="modal" data-bs-target="#showModal" class="btn btn-success btn-label waves-effect waves-light rounded-pill mb-4">
    <i class="ri-add-fill label-icon align-middle rounded-pill fs-16 me-2"></i>
    Add Sector
</a>


<div class="row">
    <div class="col-lg-12">
        <div class="card">



            <div class="card-body">
                <div class="listjs-table" id="customerList">
                    <div class="row g-4 mb-3">


                    </div>

                    <div class="table-responsive table-card mt-3 mb-1">
                        <table class="table align-middle table-nowrap" id="customerTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="d-none">ID</th>
                                    <th class="">Sector</th>
                                    <th class="">Division</th>

                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach($sector as $sectors)
                                <tr>


                                    <td class="d-none">{{$sectors->id}}</td>
                                    <td>
                                    <div class="d-flex align-items-center justify-content-between">
                                        {{$sectors->sector_long_name}} ({{$sectors->sector_short_name}})


                                        <div class="dropdown float-end">
                                            <a href="#" class="text-muted" data-bs-toggle="dropdown">
                                                <i class="ri-more-fill"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#divisionModal{{$sectors->id}}">Add Division</a>
                                                    <a class="dropdown-item" href="#"
                                                        data-id="{{ $sectors->id }}"
                                                        data-secname="{{ $sectors->sector_long_name }}"
                                                        data-secshortname="{{ $sectors->sector_short_name }}"
                                                        data-bs-toggle="modal" data-bs-target="#showModal">
                                                    Edit Sector
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <form action="{{ route('deletesector', $sectors->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Sector?');">
                                                    @csrf 
                                                    <button type="submit" class="dropdown-item text-danger">Delete this Sector</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                        </div>

                                    </td>
                                    <td>

                                        @foreach($divisions as $division)
                                        @if($division->sectorID === $sectors->id)

                                        <div class="d-flex align-items-center justify-content-between">
                                            
                                            <span class="text-primary">
                                                {{ $division->division_name }} ({{ $division->division_short_name }})
                                            </span>

                                           
                                            <div class="dropdown">
                                                <a href="#" class="text-muted" data-bs-toggle="dropdown">
                                                    <i class="ri-more-fill"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            data-divid="{{ $division->id }}"
                                                            data-sectorid="{{ $division->sectorID }}"
                                                            data-divisionname="{{ $division->division_name }}"
                                                            data-divisionshortname="{{ $division->division_short_name }}"
                                                            data-bs-toggle="modal" data-bs-target="#divisionModals">
                                                        Edit Division
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                        <form action="{{ route('deletdivision', $division->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Division?');">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item text-danger">Delete this Division</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <br>
                                        @endif

                                        @endforeach

                                    </td>


                                </tr>
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


<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">New Sector</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <form action="{{route('storesector')}}" method="POST" id="sectorform">
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
                        <label for="customername-field" class="form-label">Sector Name</label>
                        <input type="text" id="secname-field" name="secname" class="form-control" placeholder="Enter Name" required="">
                        <div class="invalid-feedback">Please enter a name.</div>
                    </div>

                    <div class="mb-3">
                        <label for="phone-field" class="form-label">Sector Short Name</label>
                        <input type="text" id="secshortname-field" name="secshortname" class="form-control" placeholder="ex. OMIN" required="">

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

<!-- ================= DIVISION MODAL ================= -->
<div>
    @foreach($sector as $sectors)
    <form action="{{ route('storedivision') }}" method="POST">
        @csrf
        <div class="modal fade" id="divisionModal{{$sectors->id}}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Add Division to {{$sectors->sector_long_name}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text"  name="sectorID" value="{{$sectors->id}}" hidden>
                        <input type="text"  name="division_name" class="form-control mb-2" placeholder="Enter Division Name" required>
                        <input type="text"  name="division_short_name" class="form-control" placeholder="Enter Division Short Name" required>
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
    <form action="{{ route('storedivision') }}" method="POST">
        @csrf
        <div class="modal fade" id="divisionModals">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Edit Division</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="divisionID-field" name="divID" hidden>
                        <input type="text" id="sectorID-field" name="sectorID" hidden>
                        <input type="text" id="divisionname-field" name="division_names" class="form-control mb-2" placeholder="Enter Division Name" required>
                        <input type="text" id="divisionshortname-field" name="division_short_names" class="form-control" placeholder="Enter Division Short Name" required>
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

            userModal.addEventListener("show.bs.modal", function(event) {

                var button = event.relatedTarget;

                document.getElementById("secid-field").value =
                    button.getAttribute("data-id");

                document.getElementById("secname-field").value =
                    button.getAttribute("data-secname");

                document.getElementById("secshortname-field").value =
                    button.getAttribute("data-secshortname");

              

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

                document.getElementById("divisionshortname-field").value =
                    button.getAttribute("data-divisionshortname");

            });

        });

    </script>
    @endsection
