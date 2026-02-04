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




@endsection
