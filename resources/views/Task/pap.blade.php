@extends('components.layout')

@section('content')



<div class="d-flex justify-content-center align-items-center mb-4">
    {{-- PREVIOUS --}}
    <a href="{{ route('monitoring', [
        'year' => $Month == 1 ? $Year - 1 : $Year,
        'month' => $Month == 1 ? 12 : $Month - 1
    ]) }}" class="btn btn-outline-primary me-2">
        ◀
    </a>

    {{-- LABEL --}}
    <span class="fw-bold fs-5">
        {{ \Carbon\Carbon::create($Year, $Month, 1)->format('F Y') }}
    </span>

    {{-- NEXT --}}
    <a href="{{ route('monitoring', [
        'year' => $Month == 12 ? $Year + 1 : $Year,
        'month' => $Month == 12 ? 1 : $Month + 1
    ]) }}" class="btn btn-outline-primary ms-2">
        ▶
    </a>
</div>


<a href="{{ route('new task') }}"
   class="btn btn-success btn-label waves-effect waves-light rounded-pill mb-4">
    <i class="ri-add-fill label-icon align-middle rounded-pill fs-16 me-2"></i>
    Create PAP
</a>

<div class="row g-4">
    <div class="row g-4">
        @foreach ($tasks as $task)



        <div class="col-12 col-md-6 col-xl-4">
            <div class="card h-80">
                <div class="card-body p-0">
                    <div class="alert alert-primary border-0 rounded-top rounded-0 m-0 d-flex align-items-center" role="alert">

                    </div>
                    <div class="card tasks-box border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between mb-2">

                                <h6 class="fs-15 mb-3 text-truncate">
                                    {{ $task->pap }}
                                </h6>

                                <div class="dropdown">
                                    <a href="#" class="text-muted" data-bs-toggle="dropdown">
                                        <i class="ri-more-fill"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                       
                                        
                                            <a class="dropdown-item" href="/Task/task/{{$task->first_activity}}/{{$task->PAP}}">
                                                <i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                View
                                            </a>
                                        </li>
                                    </ul>
                                </div>


                            </div>

                            @php
                            $percent =  ((float)$task->average_progress * 100);

                            $progressClass = $percent >= 80
                            ? 'bg-success'
                            : ($percent >= 50 ? 'bg-warning' : 'bg-danger');
                            @endphp

                            <div class="mb-2">
                                <span class="text-info fw-semibold">{{ number_format($percent, 2) }}%</span> of 100%
                            </div>

                            <div class="progress progress-sm">
                                <div class="progress-bar {{ $progressClass }}" role="progressbar" style="width: {{ $percent }}%" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        @endforeach
    </div>

</div>

@endsection
