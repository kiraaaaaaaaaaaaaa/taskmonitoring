@extends('components.layout')
@section('content')

<style>
    /* Modern Theme Customizations: Dark Green, Golden Yellow, and White */
    :root {
        --bs-dark-green: #0b3c29;
        --bs-medium-green: #134e38;
        --bs-golden-yellow: #d4af37;
        --bs-golden-yellow-light: #fef9e7;
    }

    .card.card-animate {
        border-radius: 1rem;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 0.5rem 1.25rem rgba(11, 60, 41, 0.04);
    }
    
    .card.card-animate:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.75rem 2rem rgba(11, 60, 41, 0.08);
    }

    /* Circular Progress Customization */
    .circular-progress{
        position: relative;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: conic-gradient(var(--bs-golden-yellow) calc(var(--value) * 1%), #e9ecef 0);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .circular-progress::before{
        content: "";
        position: absolute;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: white;
    }

    /* Table Hover Enhancements */
    .table-hover tbody tr {
        transition: background-color 0.2s ease;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(212, 175, 55, 0.04);
    }
</style>

<!-- Top Dashboard Metrics Row -->
<div class="row g-4 mb-4">
    
    <!-- Approved Budget Card -->
    <div class="col-xl-6 col-md-6">
        <div class="card card-animate border-start border-4 border-success bg-white">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-uppercase fw-semibold text-muted mb-1 fs-12 tracking-wide">Approved Budget for FY {{ date('Y') }}</p>
                    <h2 class="mt-2 fw-bold text-dark font-monospace mb-0">
                        ₱{{ number_format($fybudget[0]->grandtotal, 2) }}
                    </h2>
                </div>
                <div class="flex-shrink-0">
                    <span class="avatar-title rounded-circle p-3 fs-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; background-color: var(--bs-dark-green); color: white;">
                        <i class="ri-wallet-3-line"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Utilized Budget Card -->
    <div class="col-xl-6 col-md-6">
        <div class="card card-animate border-start border-4 border-warning bg-white">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-uppercase fw-semibold text-muted mb-1 fs-12 tracking-wide">Utilized Budget</p>
                    <h2 class="mt-2 fw-bold text-dark font-monospace mb-0">
                        ₱{{ number_format($totalobligation[0]->totalobligation, 2) }}
                    </h2>
                </div>
                <div class="flex-shrink-0 d-flex align-items-center gap-3">
                    <div class="text-end d-none d-sm-block">
                        <span class="fs-12 text-muted d-block">Utilization Rate</span>
                        <span class="fw-bold fs-14 text-dark">
                            {{ number_format(($totalobligation[0]->totalobligation / max($fybudget[0]->grandtotal, 1)) * 100, 1) }}%
                        </span>
                    </div>
                    <div class="circular-progress shadow-sm" style="--value:{{ ($totalobligation[0]->totalobligation / max($fybudget[0]->grandtotal, 1)) * 100 }}"></div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Main Grid: Active Tasks Table & Upcoming Events Column -->
<div class="row g-4">
    
    <!-- Active Tasks Table Section -->
    <div class="col-xl-8 col-lg-7">
        <div class="card card-animate h-100 bg-white">
            
            <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="card-title fw-bold text-dark mb-1">
                        Active Tasks for {{ date('F') }}
                    </h4>
                    <p class="text-muted fs-13 mb-0">Real-time status tracking for current operational milestones.</p>
                </div>
            </div>

            <div class="card-body px-4 pb-4">
                <div class="table-responsive">
                    <table class="table align-middle table-hover fs-13 mb-0">
                        <thead class="table-light text-uppercase fs-11 text-muted">
                            <tr>
                                <th class="py-3">PAP</th>
                                <th class="py-3">Task</th>
                                <th class="py-3">Progress</th>
                                <th class="py-3">Assigned</th>
                                <th class="py-3">Status</th>
                                <th class="py-3">Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
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
                                    : ($percent > 1 ? 'warning' : 'secondary');
                            @endphp

                            <tr>
                                <td class="fw-medium text-truncate py-3" style="max-width:140px;" title="{{ $monthlytask->pap }}">
                                    {{ $monthlytask->pap }}
                                </td>

                                <td class="text-truncate py-3" style="max-width:180px;" title="{{ $monthlytask->tasks }}">
                                    <a href="/Task/viewtask/{{ $monthlytask->id }}" class="text-decoration-none fw-semibold text-dark text-hover-success">
                                        {{ $monthlytask->tasks }}
                                    </a>
                                </td>

                                <td class="py-3" style="min-width:130px;">
                                    <div class="d-flex align-items-center gap-2">
                                        <small class="text-muted fw-semibold">{{ $percent }}%</small>
                                        <div class="progress flex-grow-1 bg-light" style="height:6px;">
                                            <div class="progress-bar {{ $progressClass }} rounded-pill" role="progressbar" style="width: {{ $percent }}%"></div>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $monthlytask->avatar }}" class="rounded-circle border" width="32" height="32" alt="Avatar">
                                        <span class="d-none d-md-inline text-dark fw-medium fs-12">
                                            {{ $monthlytask->name }}
                                        </span>
                                    </div>
                                </td>

                                <td class="py-3">
                                    <span class="badge bg-{{ $statusColor }}-subtle text-{{ $statusColor }} px-2.5 py-1.5 rounded-pill fs-11">
                                        {{ $statusText }}
                                    </span>
                                </td>

                                <td class="py-3 text-muted fs-12 text-nowrap">
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

    <!-- Upcoming Events Column -->
    <div class="col-xl-4 col-lg-5">
        <div class="card card-animate h-100 bg-white">
            <div class="card-body p-4">
                
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="text-uppercase fw-bold text-dark mb-0 fs-13">
                        <i class="ri-calendar-event-line text-success me-1"></i> Upcoming Events for {{ date('F') }}
                    </h6>
                </div>

                <div class="upcoming-scheduled">
                    @forelse($task as $tasks)
                    <a href="/Task/task/{{ $tasks->fromdate }}/{{ $tasks->id}}" class="text-decoration-none">
                    <div class="d-flex align-items-start mt-3 p-2 rounded-3 transition">
                        <div class="flex-shrink-0">
                            <span class="avatar-title rounded-circle text-white fw-bold fs-13 d-flex flex-column align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px; background-color: var(--bs-dark-green);">
                                <span class="fs-14 lh-1">{{ \Carbon\Carbon::parse($tasks->fromdate)->format('d') }}</span>
                                <span style="font-size: 9px;" class="text-uppercase text-light opacity-75">{{ \Carbon\Carbon::parse($tasks->fromdate)->format('M') }}</span>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 fw-semibold text-dark fs-13">{{ $tasks->pap }}</h6>
                            <p class="text-muted mb-1 fs-12">{{ $tasks->description }}</p>
                            <span class="badge bg-light text-muted border fs-10">
                                <i class="ri-map-pin-line me-1"></i> {{ $tasks->location ?: 'Location TBD' }}
                            </span>
                        </div>
                    </div>
                    </a>
                    @empty
                    <div class="text-center py-5 text-muted">
                        <i class="ri-calendar-check-line fs-24 mb-2 d-block"></i>
                        <p class="fs-12 mb-0">No upcoming events scheduled for this month.</p>
                    </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>

</div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userType = @json(Auth::user()->usertype);
        const assignTaskBtn = document.getElementById('assignTaskBtn');
        if (assignTaskBtn && userType !== 'admin') {
            assignTaskBtn.style.display = 'none';
        }
    });
</script>