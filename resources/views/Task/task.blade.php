@extends('components.layout')

@section('content')
<a href="javascript:history.back()"
   class="btn btn-secondary btn-label waves-effect waves-light rounded-pill mb-4">
    <i class="ri-arrow-left-s-line label-icon align-middle rounded-pill fs-16 me-2"></i>
    Back
</a>

<div class="row g-4">
    @foreach ($fromtask as $task)
        @php
            $percent = ((float) $task->ProgressScore) * 100;

            $progressClass = $percent >= 80
                ? 'bg-success'
                : ($percent >= 50 ? 'bg-warning' : 'bg-danger');
        @endphp

        <div class="col-12 col-md-6 col-xl-4">
            <div class="card h-80">
                <div class="card-body p-0">

                    <div class="alert alert-primary border-0 rounded-top rounded-0 m-0 d-flex align-items-center"
                         role="alert">
                        
                    </div>

                    <div class="card tasks-box border-0">
                        <div class="card-body">
                            <div class="d-flex mb-2">
                                <h6 class="fs-15 mb-0 flex-grow-1 text-truncate task-title">
                                    <a href="#" class="text-body d-block">
                                        {{ $task->pap }}
                                    </a>
                                </h6>

                                <div class="dropdown">
                                    <a href="#" class="text-muted" data-bs-toggle="dropdown">
                                        <i class="ri-more-fill"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="/Task/viewtask/{{$task->id}}">
                                                <i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                View
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <p class="text-muted">
                                Task: {{ $task->tasks }} <br>
                                Assigned to: {{ $task->Assigned }} <br>
                                Preparer: {{ $task->Preparer }}
                            </p>

                            <div class="mb-3">
                                <div class="d-flex mb-1">
                                    <div class="flex-grow-1">
                                        <h6 class="text-muted mb-0">
                                            <span class="text-info">{{ round($percent) }}%</span> of 100%
                                        </h6>
                                    </div>
                                </div>

                                <div class="progress rounded-3 progress-sm progress-bar-animated">
                                    <div class="progress-bar {{ $progressClass }}"
                                         role="progressbar"
                                         style="width: {{ $percent }}%"
                                         aria-valuenow="{{ $percent }}"
                                         aria-valuemin="0"
                                         aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer border-top-dashed">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h6 class="text-muted mb-0">
                                        {{ $task->activitydate }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection
