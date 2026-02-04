@extends('components.layout')

@section('content')

<a data-bs-toggle="modal" data-bs-target="#showModal" class="btn btn-success btn-label waves-effect waves-light rounded-pill mb-4">
    <i class="ri-add-fill label-icon align-middle rounded-pill fs-16 me-2"></i>
    Create New User
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
                                    <th class="">Name</th>
                                    <th class="">Position</th>
                                    <th class="">Email</th>
                                    <th class="">User Type</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach($user as $users)
                                <tr>


                                    <td class="d-none">{{$users->id}}</td>
                                    <td class="customer_name">{{$users->name}}</td>
                                    <td class="email">{{$users->position}}</td>
                                    <td class="phone">{{$users->email}}</td>
                                    <td class="status"><span class="badge bg-success-subtle text-success text-uppercase">{{$users->usertype}}</span></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <div class="edit">
                                                <button class="btn btn-sm btn-success edit-item-btn" data-bs-toggle="modal" data-bs-target="#showModal" data-id="{{ $users->id }}" data-name="{{ $users->name }}" data-position="{{ $users->position }}" data-email="{{ $users->email }}" data-utype="{{ $users->usertype }}">Edit</button>
                                            </div>
                                        </div>
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
                <h5 class="modal-title" id="exampleModalLabel">New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <form action="{{route('storeuser')}}" method="POST" id="userform">
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
                        <input type="text" id="id-field" name="id" class="form-control" placeholder="ID" readonly="">
                    </div>

                    <div class="mb-3">
                        <label for="customername-field" class="form-label">Name</label>
                        <input type="text" id="name-field" name="name" class="form-control" placeholder="Enter Name" required="">
                        <div class="invalid-feedback">Please enter a name.</div>
                    </div>

                    <div class="mb-3">
                        <label for="phone-field" class="form-label">Position</label>
                        <input type="text" id="position-field" name="position" class="form-control" placeholder="Enter Position." required="">
                        <div class="invalid-feedback">Please enter a position.</div>
                    </div>

                    <div class="mb-3">
                        <label for="email-field" class="form-label">Email</label>
                        <input type="email" id="email-field" name="email" class="form-control" placeholder="Enter Email" required="">
                        <div class="invalid-feedback">Please enter an email.</div>
                    </div>

                    <div class="mb-3">
                        <label for="date-field" class="form-label">User Type</label>
                        <select class="form-select shadow-sm" name="usertype" id="utype">
                            <option selected value="">--Choose User Type--</option>
                            <option value="Supervisor">Supervisor</option>
                            <option value="User">User</option>
                            <option value="Reviewer">Reviewer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="customername-field" class="form-label">Password</label>
                        <input type="text" id="password-field" name="password" class="form-control" placeholder="Enter Password">
                        <div class="invalid-feedback">Please enter a password.</div>
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
<script>
    document.addEventListener("DOMContentLoaded", function() {

        var userModal = document.getElementById("showModal");

        userModal.addEventListener("show.bs.modal", function(event) {

            var button = event.relatedTarget;

            document.getElementById("id-field").value =
                button.getAttribute("data-id");

            document.getElementById("name-field").value =
                button.getAttribute("data-name");

            document.getElementById("position-field").value =
                button.getAttribute("data-position");

            document.getElementById("email-field").value =
                button.getAttribute("data-email");

            document.getElementById("utype").value =
                button.getAttribute("data-utype");

            // Password intentionally left blank for security

        });

    });


</script>
@endsection
