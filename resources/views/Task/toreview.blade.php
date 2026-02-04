@extends('components.layout')

@section('content')

<div class="row g-4">
    @foreach ($groupedTasks as $date => $tasks)
    <div class="mb-4" id="cardborder">

        <!-- Group Header -->
        <h4 class="pb-2 mb-3">
            <i class="bi bi-calendar-event text-warning"></i>
            {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}
        </h4>

        <div class="row">
            @foreach ($tasks as $task)
                <div class="col-md-4 mb-4">
                    <div class="card task-card h-100 shadow-lg border-0">
                        <div class="card-body d-flex flex-column">

                            <div class="d-flex align-items-center">
                                <!-- Left Icon -->
                                @if($task->is_read == 0)
                                    <i class="bi bi-exclamation-circle-fill text-danger"></i>
                                @endif
                            </div>

                            <h5 class="card-title fw-bold">
                                {{ $task->pap }}
                            </h5>

                            <p class="mb-1">
                                <i class="bi bi-pencil-square"></i>
                                {{ $task->task }}
                            </p>
                            

                            <p class="mb-1">
                                @if($task->progressScore < 1)
                                    <i class="bi bi-hourglass-split text-warning"></i>
                                    In Progress
                                @else
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    Completed
                                @endif
                            </p>

                             <p class="mb-1">
                                <i class="bi bi-pencil-square">Due:</i>
                                {{ $task->duedate }}
                            </p>

                            <div class="mt-auto d-flex justify-content-between">

                                <!-- VIEW -->
                                <a href="/Task/updatetask/{{$task->id}}"
                                   class="btn btn-outline-info btn-sm">
                                    <i class="bi bi-pencil"></i> View
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endforeach
</div>


@endsection
