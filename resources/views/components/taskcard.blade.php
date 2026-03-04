<div class="card task-card {{ $status }} shadow-sm mb-3"
     draggable="true"
     data-id="{{ $task->id }}">

    <div class="card-body p-0">

        <!-- Top Header (Status Color Bar) -->
        <div class="alert 
            {{ $status == 'pending' ? 'alert-warning' : '' }}
            {{ $status == 'ongoing' ? 'alert-primary' : '' }}
            {{ $status == 'done' ? 'alert-success' : '' }}
            border-0 rounded-top m-0 d-flex align-items-center justify-content-between"
            role="alert">


            <small>
                Due: {{ $task->duedate }}
                @if($status == 'done')
                    <span class="text-success">(Completed)</span>
                @elseif(\Carbon\Carbon::parse($task->duedate)->isPast())
                    <span class="text-danger">(Overdue)</span>
                @elseif(\Carbon\Carbon::parse($task->duedate)->isToday())
                    <span class="text-warning">(Due Today)</span>
                
                @else
                    <span class="text-muted">
                ({{ \Carbon\Carbon::parse($task->duedate)->diffForHumans() }})
                    </span>
                @endif
            </small>
        </div>

        <!-- Inner Content Card -->
        <div class="card shadow-none border-0 w-100">
    <div class="card-body p-2">

        <div class="d-flex align-items-start justify-content-between mb-1">

            <h6 class="fw-bold mb-0">
                {{ $task->pap }}
            </h6>

        </div>

        <p class="mb-2">
            {{ $task->task }}
        </p>

        <div class="d-flex justify-content-end">
            <a href="/Task/updatetask/{{$task->id}}"
               class="btn btn-sm btn-outline-dark">
               View
            </a>
        </div>

    </div>
</div>

    </div>
</div>