@extends('components.layout')
@section('content')
<div class="row g-3">
<style>
.circular-progress{
    position: relative;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: conic-gradient(#0d6efd calc(var(--value) * 1%), #aec6de 0);
    display: flex;
    align-items: center;
    justify-content: center;
}

.circular-progress::before{
    content: "";
    position: absolute;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: white;
}

.progress-value{
    position: relative;
    font-size: 18px;
    font-weight: 600;
    color: #0d6efd;
}
</style>
    <!-- main row for spacing -->

    {{-- @php
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
    @endphp --}}



    <div class="col-md-3">
        <div class="card card-animate">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <p class="fw-medium text-muted mb-0 fs-11">APPROVED BUDGET FOR FY {{ date('Y') }}</p>
                    <h2 class="mt-4 ff-secondary fw-semibold">
                        {{number_format($fybudget[0]->grandtotal,2)}}
                    </h2>

                </div>
                <div class="avatar-sm flex-shrink-0">
                    <span class="avatar-title bg-secondary rounded-circle fs-2">
                        <i class="ri-wallet-line"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>



    <div class="col-md-3">
        <div class="card card-animate">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <p class="fw-medium text-muted mb-0 fs-11">UTILIZED BUDGET</p>
                    <h2 class="mt-4 ff-secondary fw-semibold">
                        {{number_format($totalobligation[0]->totalobligation,2)}}
                    </h2>

                </div>
                <div class="avatar-sm flex-shrink-0">
                    <span class="avatar-title bg-secondary rounded-circle fs-2">
                        <div class="d-flex justify-content-center">

                            <div class="circular-progress" style="--value:{{number_format($totalobligation[0]->totalobligation/$fybudget[0]->grandtotal*100,2)}}">
                               
                            </div>

                        </div>
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="col-md-3">
        <div class="card card-animate">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <p class="fw-medium text-muted mb-0">Remaining</p>
                    <h2 class="mt-4 ff-secondary fw-semibold">
                      

                    </h2>

                </div>
                <div class="avatar-sm flex-shrink-0">
                    <span class="avatar-title bg-secondary rounded-circle fs-2">
                        <i class="ri-wallet-line"></i>
                    </span>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <div class="col-md-3">
        <div class="card card-animate">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <p class="fw-medium text-muted mb-0">Utilization Rate</p>
                    <h2 class="mt-4 ff-secondary fw-semibold">
                       
                    </h2>
                    <p class="mb-0 text-muted">

                    </p>
                </div>
                <div class="avatar-sm flex-shrink-0">
                    

                </div>
            </div>
        </div>
    </div> --}}
</div>



<div class="card card-animate col-md-4 float-end">

    <div class="card-body pt-0">


        <div class="upcoming-scheduled">
            <h6 class="text-uppercase fw-semibold mt-4 mb-3 text-muted">Upcoming Events for {{date('F')}}:</h6>
        </div>
        @foreach($task as $tasks)
        <div class="mini-stats-wid d-flex align-items-center mt-3">



            <div class="flex-shrink-0 avatar-sm">
                <span class="mini-stat-icon avatar-title rounded-circle text-secondary bg-secondary-subtle fs-4">
                    {{\Carbon\Carbon::parse($tasks->fromdate)->format('d')}}
                </span>
            </div>
            <div class="flex-grow-1 ms-3">
                <h6 class="mb-1">{{$tasks->pap}}</h6>

            </div>
            <p class="text-muted mb-0 fs-10 float-end">{{$tasks->location}}</p>



        </div><!-- end -->

        @endforeach


    </div><!-- end cardbody -->
</div><!-- end card -->
</div>

<div class="row">
    <div class="col-12">

        <div class="card h-100">

            <!-- Header -->
            <div class="card-header d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">

                <h4 class="card-title mb-0">
                    Active Tasks for {{ date('F') }}
                </h4>

                {{-- <a href="{{ route('new task') }}"
                    id="assignTaskBtn"
                   class="btn btn-success btn-sm rounded-pill d-flex">
                    <i class="ri-add-fill me-1 d-flex"></i>
                    New Task
                </a> --}}

            </div>

            <!-- Body -->
            <div class="card-body">

                <div class="table-responsive">

                    <table class="table align-middle table-hover fs-12">

                        <thead class="table-light ">
                            <tr class="fs-11">
                                <th>PAP</th>
                                <th>TASK</th>
                                <th>PROGRESS</th>
                                <th>ASSIGNED</th>
                                <th>STATUS</th>
                                <th>DUE DATE</th>
                            </tr>
                        </thead>

                        <tbody >
                            @foreach($monthtask as $monthlytask)

                            @php
                                $percent = ((float) $monthlytask->ProgressScore) * 100;

                                $progressClass = $percent >= 80
                                    ? 'bg-success'
                                    : ($percent >= 50 ? 'bg-warning' : 'bg-danger');

                                $statusText = $percent >= 100
                                    ? 'Completed'
                                    : ($percent > 1 ? 'In Progress' : 'Pending');

                                $statusColor = $percent >= 100
                                    ? 'success'
                                    : ($percent > 1 ? 'warning' : 'danger');
                            @endphp

                            <tr>
                                <td class="fw-medium text-truncate" style="max-width:150px;">
                                    {{$monthlytask->pap}}
                                </td>

                                <td class="text-truncate" style="max-width:200px;">
                                    <a href="/Task/viewtask/{{$monthlytask->id}}" class="text-decoration-none">
                                        {{$monthlytask->tasks}}
                                    </a>
                                </td>

                                <td style="min-width:150px;">
                                    <div class="d-flex align-items-center gap-2">
                                        <small class="text-muted">{{$percent}}%</small>
                                        <div class="progress flex-grow-1" style="height:6px;">
                                            <div class="progress-bar {{$progressClass}}"
                                                 style="width: {{$percent}}%">
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{$monthlytask->avatar}}"
                                             class="rounded-circle"
                                             width="30"
                                             height="30">
                                        <span class="d-none d-md-inline">
                                            {{$monthlytask->name}}
                                        </span>
                                    </div>
                                </td>

                                <td>
                                    <span class="badge bg-{{$statusColor}}-subtle text-{{$statusColor}}">
                                        {{$statusText}}
                                    </span>
                                </td>

                                <td class="text-muted">
                                    {{ \Carbon\Carbon::parse($monthlytask->duedate)->format('M d, Y') }}
                                </td>

                            </tr>

                            @endforeach
                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
</div><!-- end row -->




@endsection

<script>
     document.addEventListener('DOMContentLoaded', function() {
        const userType = @json(Auth::user()->usertype);
        const assignTaskBtn = document.getElementById('assignTaskBtn');
       if (userType !== 'admin') {
            assignTaskBtn.style.display = 'none';
        }
    });
</script>
