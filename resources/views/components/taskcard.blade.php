<div class="card task-card {{ $status }} shadow-sm mb-3 border-0 rounded-4 overflow-hidden"
     draggable="true"
     data-id="{{ $task->id }}"
     style="transition: all 0.3s ease;">

    <div class="card-body p-0 bg-white">

        <!-- Top Header (Dynamic Status Bar matching Dark Green / Golden Yellow / White Theme) -->
        <div class="px-3 py-2 d-flex align-items-center justify-content-between text-white"
             style="background-color: 
                {{ $status == 'pending' ? '#ffb703' : '' }}
                {{ $status == 'ongoing' ? '#1b4332' : '' }}
                {{ $status == 'done' ? '#2d6a4f' : '' }};
                color: {{ $status == 'pending' ? '#1b4332 !important' : '#ffffff' }};">
            
            <span class="fs-12 fw-semibold d-flex align-items-center">
                <i class="ri-calendar-line me-1"></i> Due: {{ $task->duedate }}
            </span>

            <small class="fw-bold">
                @if($status == 'done')
                    <span class="badge bg-white text-success px-2 py-1 rounded-pill">Completed</span>
                @elseif(\Carbon\Carbon::parse($task->duedate)->isPast())
                    <span class="badge bg-danger text-white px-2 py-1 rounded-pill">Overdue</span>
                @elseif(\Carbon\Carbon::parse($task->duedate)->isToday())
                    <span class="badge bg-white text-dark px-2 py-1 rounded-pill">Due Today</span>
                @else
                    <span class="opacity-75">
                        ({{ \Carbon\Carbon::parse($task->duedate)->diffForHumans() }})
                    </span>
                @endif
            </small>
        </div>

        <!-- Inner Content Card -->
        <div class="card shadow-none border-0 w-100 bg-transparent">
            <div class="card-body p-3">

                <!-- PAP Title -->
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <h6 class="fw-bold mb-0" style="color: #1b4332; font-size: 0.95rem;">
                        <i class="ri-folder-shield-2-line me-1 text-warning"></i> {{ $task->pap }}
                    </h6>
                </div>

                <!-- Task Description -->
                <p class="mb-3 text-secondary" style="font-size: 0.875rem; line-height: 1.4;">
                    {{ $task->task }}
                </p>

                <!-- Action Footer -->
                <div class="d-flex justify-content-end align-items-center pt-2 border-top border-light">
                    <a href="/Task/updatetask/{{$task->id}}"
                       class="btn btn-sm rounded-pill px-3 py-1 text-white shadow-none"
                       style="background-color: #1b4332; font-size: 0.8rem; transition: background-color 0.2s;">
                       <i class="ri-eye-line me-1"></i> View Details
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>

<style>
    .task-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(27, 67, 50, 0.1) !important;
    }
</style>