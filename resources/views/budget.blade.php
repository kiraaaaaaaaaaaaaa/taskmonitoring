@extends('components.layout')

@section('content')

<button type="button" class="btn btn-success btn-label waves-effect waves-light rounded-pill mb-4" data-bs-toggle="modal" data-bs-target="#allocatemodal">
    <i class="ri-add-fill label-icon align-middle rounded-pill fs-16 me-2"></i>
    Allocate Budget
</button>

<div class="col">
    <div class="card border">
        <div class="card-header">

            @php
            $total = 0;
            $totalcost = 0;

            @endphp

            @foreach($budget as $bud)

            @php
            $total +=$bud->allocatedbudget;
            $totalcost +=$bud->total;

            @endphp

            @endforeach

            @php
            $totalpercent =round( (float) $totalcost / $total * 100);

            $totalprog = $totalpercent >= 80
            ? 'bg-success'
            : ($totalpercent >= 50 ? 'bg-warning' : 'bg-danger');

            $totalprogs = $totalpercent >= 80
            ? 'excellent'
            : ($totalpercent >= 50 ? 'average' : 'poor');
            @endphp


            <span class="badge {{$totalprog}} align-middle fs-10 float-end text-uppercase">{{$totalprogs}}</span><span class="float-end px-1">Overall Utilization Rate - {{$totalpercent}}%</span>
            <h6 class="card-title mb-0">Budget for FY {{date('Y')}}</h6>
        </div>
        <div class="card-header">
            <h3 class="card-title mb-0">{{number_format($total,2)}}</h3>
        </div>


        <div class="card-body">
            <div class="listjs-table" id="customerList">
                <div class="row g-4 mb-3">


                </div>

                <div class="table-responsive table-card mt-3 mb-1">
                    <table class="table align-middle table-nowrap" id="customerTable">
                        <thead class="table-light">
                            <tr>
                                <th class="d-none">ID</th>
                                <th class="">PAP</th>
                                <th class="">Bugdet</th>
                                <th class="">Utilized Budget</th>
                                <th class="">Remaining</th>
                                <th class="">Utilization Rate</th>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all">
                            @foreach($budget as $users)
                            <tr>

                                @php
                                $percent = round( (float) $users->total / $users->allocatedbudget * 100);

                                $prog = $percent >= 80
                                ? 'bg-success'
                                : ($percent >= 50 ? 'bg-warning' : 'bg-danger');

                                $progs = $percent >= 80
                                ? 'excellent'
                                : ($percent >= 50 ? 'average' : 'poor');
                                @endphp


                                <td class="d-none">{{$users->id}}</td>
                                <td class="customer_name">{{$users->pap}}</td>
                                <td class="email">{{number_format($users->allocatedbudget,2)}}</td>
                                <td class="phone">{{number_format($users->total,2)}}</td>
                                <td class="phone">{{number_format($users->allocatedbudget - $users->total,2)}}</td>
                                <td class="status"><span>{{$percent}}%</span><span class="badge {{$prog}} float-end text-uppercase">{{$progs}}</span></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <div class="edit">
                                            <button class="btn btn-sm btn-success edit-item-btn" data-bs-toggle="modal" data-bs-target="#showModal" data-id="{{ $users->id }}" data-pap="{{ $users->pap }}" data-budget="{{ $users->allocatedbudget }}">Edit</button>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<form method="post" action="{{route('budget store')}}">
    @csrf
    <div class="modal fade" id="allocatemodal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="col">
                    <div class="card border">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Allocate Budget</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="card-body">
                            <form action="">
                                <div class="mb-3">
                                    <label for="employeeName" class="form-label">PAP</label>
                                    <select name="budgetPAP" class="form-control">
                                        <option>--Select PAP--</option>
                                        @foreach($paps as $pap)
                                        <option value={{$pap->id}}>{{$pap->pap}}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="employeeUrl" class="form-label">Budget</label>
                                    <input type="text" name="allocatedbudget" class="form-control" id="employeeUrl" placeholder="Enter Amount">
                                </div>
                                <div class="mb-3">
                                    <label for="StartleaveDate" class="form-label">FY</label>
                                    <input type="text" name="FY" class="form-control" id="StartleaveDate" placeholder="Enter FY">
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<form method="post" action="{{route('budget store')}}">
    @csrf
    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title" id="exampleModalLabel">Manage Budget</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>


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
                        <label for="customername-field" class="form-label">PAP</label>
                        <input type="text" id="pap-field" name="pap" class="form-control" readonly>
                       
                    </div>

                    <div class="mb-3">
                        <label for="phone-field" class="form-label">Bugdet</label>
                        <input type="text" id="budget-field" name="budget" class="form-control" placeholder="Enter Budget." required="">
                        <div class="invalid-feedback">Please enter a budget.</div>
                    </div>


                    <div class="modal-footer" style="display: block;">
                        <div class="hstack gap-2 justify-content-end">
                            {{-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> --}}
                            <button type="submit" class="btn btn-success">Save</button>
                            <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                        </div>
                    </div>

                </div>
            </div>
        </div>

</form>
<script>
    document.addEventListener("DOMContentLoaded", function() {

        var userModal = document.getElementById("showModal");

        userModal.addEventListener("show.bs.modal", function(event) {

            var button = event.relatedTarget;

            document.getElementById("id-field").value =
                button.getAttribute("data-id");

            document.getElementById("pap-field").value =
                button.getAttribute("data-pap");

            document.getElementById("budget-field").value =
                button.getAttribute("data-budget");

            // Password intentionally left blank for security

        });

    });

</script>


@endsection
