@extends('components.layout')
@section('content')
<div class="row g-3">
    <!-- main row for spacing -->

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



    <div class="col-md-3">
        <div class="card card-animate">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <p class="fw-medium text-muted mb-0">Total Budget</p>
                    <h2 class="mt-4 ff-secondary fw-semibold">
                        <span>{{number_format($total,2)}}</span>
                    </h2>

                </div>
                <div class="avatar-sm flex-shrink-0">
                    <span class="avatar-title bg-secondary rounded-circle fs-2">
                        <i class="ri-funds-line"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>



    <div class="col-md-3">
        <div class="card card-animate">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <p class="fw-medium text-muted mb-0">Utilized Budget</p>
                    <h2 class="mt-4 ff-secondary fw-semibold">
                        <span>{{number_format($totalcost,2)}}</span>
                    </h2>

                </div>
                <div class="avatar-sm flex-shrink-0">
                    <span class="avatar-title bg-secondary rounded-circle fs-2">
                        <i data-feather="activity"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-animate">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <p class="fw-medium text-muted mb-0">Remaining</p>
                    <h2 class="mt-4 ff-secondary fw-semibold">
                        <span>{{number_format(($total - $totalcost),2)}}</span>

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
                    <p class="fw-medium text-muted mb-0">Utilization Rate</p>
                    <h2 class="mt-4 ff-secondary fw-semibold">
                        <span class="float-end px-1">{{$totalpercent}}%</span>
                    </h2>
                    <p class="mb-0 text-muted">

                    </p>
                </div>
                <div class="avatar-sm flex-shrink-0">
                    <span class="avatar-title {{$totalprog}} rounded-circle fs-10 float-end text-uppercase">
                        {{$totalprogs}}
                    </span>

                </div>
            </div>
        </div>
    </div>
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
                    {{\Carbon\Carbon::parse($tasks->activitydate)->format('d')}}
                </span>
            </div>
            <div class="flex-grow-1 ms-3">
                <h6 class="mb-1">{{$tasks->pap}}</h6>

            </div>



        </div><!-- end -->

        @endforeach


    </div><!-- end cardbody -->
</div><!-- end card -->
</div>

<div class="row">
    <div class="col-xl-15">
        <div class="card card-height-100">
            <div class="card-header d-flex align-items-center">
                <h4 class="card-title flex-grow-1 mb-0">Active Tasks for {{date('F')}}</h4>
                <a href="{{ route('new task') }}" class="btn btn-success  btn-label waves-effect waves-light rounded-pill">
                     <i class="ri-add-fill label-icon align-middle rounded-pill fs-16 me-2"></i>
                   
                </a>
                
                
            </div>
            <!-- end cardheader -->
            <div class="card-body">
                <div class="table-responsive table-card">
                    <table class="table table-nowrap table-centered align-middle">
                        <thead class="bg-light text-muted">
                            <tr>
                                <th scope="col">PAP</th>
                                <th scope="col">Task</th>
                                <th scope="col">Progress</th>
                                <th scope="col">Assigned</th>
                                <th scope="col">Status</th>
                                <th scope="col" style="width: 10%;">Due Date</th>
                            </tr><!-- end tr -->
                        </thead><!-- thead -->

                        <tbody>
                            @foreach($monthtask as $monthlytask)
                            <tr>
                                <td class="fw-medium">{{$monthlytask->pap}}</td>
                                <td>
                                

                                    <a href="/Task/viewtask/{{$monthlytask->id}}" class="text-reset">
                                        {{$monthlytask->tasks}}
                                    </a>
                                </td>
                                <td>
                                    @php
                                    $percent = ((float) $monthlytask->ProgressScore) * 100;

                                    $progressClass = $percent >= 80
                                    ? 'bg-success'
                                    : ($percent >= 50 ? 'bg-warning' : 'bg-danger');
                                    @endphp
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-1 text-muted fs-13">{{$percent}}%</div>
                                        <div class="progress progress-sm bg-primary-subtle flex-grow-1" style="width: 68%;">
                                            <div class="progress-bar {{$progressClass}} rounded" role="progressbar" style="width: {{$percent}}%" aria-valuenow="{{$percent}}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="avatar-group flex-nowrap">
                                        <div class="avatar-group-item">
                                            <img class="rounded-circle header-profile-user" src={{$monthlytask->avatar}} alt="Header Avatar">
                                            {{$monthlytask->name}}
                                        </div>

                                    </div>
                                </td>
                                @php
                                $percent = ((float) $monthlytask->ProgressScore) * 100;

                                $progressClass = $percent >= 100
                                ? 'text-success'
                                : ($percent > 1 ? 'text-warning' : 'text-danger');
                                $badge = $percent >= 100
                                ? 'Completed'
                                : ($percent > 1 ? 'In Progress' : 'Pending');
                                $bg = $percent >= 100
                                ? 'bg-success-subtle'
                                : ($percent > 1 ? 'bg-warning-subtle' : 'bg-danger-subtle');
                                @endphp
                                <td><span class="badge {{$bg}} {{$progressClass}}">{{$badge}}</span></td>
                                <td class="text-muted">{{\Carbon\Carbon::parse($monthlytask->duedate)->format('M d, Y')}}</td>
                            </tr><!-- end tr -->
                            @endforeach


                        </tbody><!-- end tbody -->
                    </table><!-- end table -->
                </div>



            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->


</div><!-- end row -->




@endsection
