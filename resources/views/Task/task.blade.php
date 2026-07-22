@extends('components.layout')

@section('content')

<style>
    /* Modern Theme Customizations: Dark Green, Golden Yellow, and White */
    :root {
        --bs-dark-green: #0a3622;
        --bs-medium-green: #114c31;
        --bs-accent-green: #196f47;
        --bs-golden-yellow: #d4af37;
        --bs-golden-yellow-light: #fef9e7;
        --bs-golden-yellow-border: #f3e5ab;
    }

    body {
        background-color: #f7f9fa;
    }

    /* PAP Overview Card Styling */
    .pap-hero-card {
        background: linear-gradient(135deg, var(--bs-dark-green), var(--bs-accent-green));
        color: #ffffff;
        border: none;
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1.5rem rgba(10, 54, 34, 0.1);
    }

    .pap-hero-card .badge-fund {
        background-color: var(--bs-golden-yellow);
        color: var(--bs-dark-green);
        font-weight: 700;
    }

    .pap-meta-item {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.85);
    }

    .pap-meta-item i {
        color: var(--bs-golden-yellow);
        width: 20px;
    }

    /* Task Card Styling */
    .task-card {
        border: none;
        border-radius: 1rem;
        background: #ffffff;
        box-shadow: 0 0.25rem 1rem rgba(10, 54, 34, 0.04);
        transition: all 0.25s ease;
    }

    .task-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1.25rem rgba(10, 54, 34, 0.08);
        border-color: var(--bs-golden-yellow-border);
    }

    .task-title a {
        color: var(--bs-dark-green);
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .task-title a:hover {
        color: var(--bs-accent-green);
    }

    /* Custom Buttons */
    .btn-dark-green {
        background-color: var(--bs-dark-green);
        color: #ffffff;
        border: none;
        transition: all 0.2s ease;
    }

    .btn-dark-green:hover {
        background-color: var(--bs-accent-green);
        color: #ffffff;
    }

    .btn-outline-dark-green {
        border-color: var(--bs-dark-green);
        color: var(--bs-dark-green);
    }

    .btn-outline-dark-green:hover {
        background-color: var(--bs-dark-green);
        color: #ffffff;
    }

    /* Progress bar custom styling */
    .progress {
        background-color: #edf2f7;
        border-radius: 0.5rem;
        overflow: hidden;
    }
</style>

<div class="container-fluid px-0 py-3">
@foreach($viewpap as $viewpaps)
    <!-- Back Navigation -->
    <div class="mb-4">
        <a href="javascript:history.back()" class="btn btn-outline-dark-green btn-label waves-effect waves-light rounded-pill px-3 shadow-sm">
            <i class="ri-arrow-left-s-line label-icon align-middle rounded-pill fs-16 me-2"></i>
            Back
        </a>
        
    </div>

    <!-- PAP Overview Section -->
    
    <div class="card pap-hero-card mb-5">
        <div class="card-body p-4 p-md-5">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
                <h2 class="fw-bold mb-2 mb-md-0 text-white">
                    {{ $viewpaps->pap }}
                </h2>
                <span class="badge badge-fund px-3 py-2 rounded-pill fs-13">
                    <i class="ri-money-dollar-circle-line me-1"></i> {{ $viewpaps->fundName }}
                </span>
            </div>

            <p class="pap-meta-item mb-3">
                <i class="ri-map-pin-line me-1"></i> {{ $viewpaps->location }} &nbsp;|&nbsp; 
                <i class="ri-calendar-event-line me-1"></i> {{ \Carbon\Carbon::parse($viewpaps->fromdate)->format('F d') }} to {{ \Carbon\Carbon::parse($viewpaps->todate)->format('d, Y') }}
            </p>

            <div class="row g-3 mt-2 pt-3 border-top border-light border-opacity-10">
                <div class="col-md-4 pap-meta-item">
                    <i class="ri-building-line me-1"></i> <strong>Assigned Division:</strong> {{ $viewpaps->division_name }} ({{ $viewpaps->division_short_name }})
                </div>
                <div class="col-md-4 pap-meta-item">
                    <i class="ri-user-star-line me-1"></i> <strong>Focal Person:</strong> {{ $viewpaps->focalPerson }}
                </div>
                <div class="col-md-4 pap-meta-item">
                    <i class="ri-flag-line me-1"></i> <strong>Output Supported:</strong> {{ $viewpaps->oosName }}
                </div>
            </div>
            

            @if(!empty($viewpaps->description))
            <div class="mt-4 pt-3 border-top border-light border-opacity-10 text-white opacity-90 fs-14">
                <strong>Description:</strong> {{ $viewpaps->description }}
            </div>
            @endif
        </div>
    </div>
   

    <!-- Tasks Section Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="fw-bold mb-0" style="color: var(--bs-dark-green);">
            <i class="ri-task-line me-2"></i> Associated Tasks
        </h4>
         <a class="btn btn-outline-dark-green btn-label waves-effect waves-light rounded-pill px-3 shadow-sm float-end" href="/Task.createtask/{{ $viewpaps->newID}}" id="addTaskBtn">
                                        <i class="ri-add-circle-line align-bottom me-2 text-success"></i> Add Task
                                    </a>
       
    </div>
     @endforeach

    <!-- Task List / Empty State -->
    @if($fromtask->isEmpty())
        <div class="card text-center py-5 border-0 shadow-sm rounded-4">
            <div class="card-body">
                <div class="avatar-lg bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                    <i class="ri-file-search-line fs-2 text-muted"></i>
                </div>
                <h5 class="text-muted fw-bold">No tasks found for this PAP.</h5>
                <p class="text-muted fs-13 mb-0">There are currently no assigned tasks linked to this program or activity.</p>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach ($fromtask as $task)
            @php
                $percent = ((float) $task->ProgressScore) * 100;
                $progressClass = $percent >= 80 ? 'bg-success' : ($percent >= 50 ? 'bg-warning' : 'bg-danger');
            @endphp

            <div class="col-12 col-md-6 col-xl-4">
                <div class="card task-card h-100 d-flex flex-column">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        
                        <div>
                            <!-- Card Header: Title & Dropdown Actions -->
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <h6 class="fs-15 fw-bold mb-0 flex-grow-1 task-title pe-2">
                                    <a href="/Task/viewtask/{{$task->taskid}}" class="text-dark">
                                        {{ $task->tasks }}
                                    </a>
                                </h6>

                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light rounded-circle shadow-none" type="button" data-bs-toggle="dropdown" style="width: 32px; height: 32px;">
                                        <i class="ri-more-fill text-muted"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                        <li>
                                            <a class="dropdown-item py-2" href="/Task/viewtask/{{$task->taskid}}">
                                                <i class="ri-eye-fill align-middle me-2 text-success"></i> View Details
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        <li>
                                            <form action="/Task/task/{{ $task->taskid }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="dropdown-item py-2 text-danger" onclick="return confirm('Are you sure you want to remove this task?')">
                                                    <i class="ri-delete-bin-line align-middle me-2"></i> Remove Task
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Assigned Personnel Info -->
                            <p class="text-muted fs-13 mb-4">
                                <i class="ri-user-line me-1 text-secondary"></i> Assigned to: <strong class="text-dark">{{ $task->Assigned }}</strong>
                            </p>
                        </div>

                        <!-- Progress Bar & Target Date Section -->
                        <div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fs-11 text-muted fw-bold text-uppercase">Progress</span>
                                    <span class="fs-11 fw-bold text-dark">{{ number_format($percent, 0) }}%</span>
                                </div>
                                <div class="progress progress-sm" style="height: 6px;">
                                    <div class="progress-bar {{ $progressClass }}" role="progressbar" style="width: {{ $percent }}%" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="pt-3 border-top border-light d-flex align-items-center justify-content-between">
                                <span class="fs-11 text-muted fw-bold text-uppercase">Target Date</span>
                                <span class="badge bg-light text-dark fw-bold fs-12 px-2 py-1">
                                    <i class="ri-calendar-check-line text-success me-1"></i> {{ $task->duedate }}
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

</div>



@endsection