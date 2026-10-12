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

        border-color: var(--bs-golden-yellow);

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

     .pap-hero {

        background: #ffffff;

    color: var(--bs-dark-green);

    border: none;

    border-left: 10px solid var(--bs-dark-green);

    border-radius: 1rem;

    box-shadow: 0 0.5rem 1.5rem rgba(10, 54, 34, 0.1);

    }

</style>



<div class="container-fluid px-0 py-3">

@foreach($viewpap as $viewpaps)

    <!-- Back Navigation -->

    <div class="mb-4">



    <a href="javascript:history.back()" class="btn btn-outline-dark-green btn-label waves-effect waves-light rounded-pill px-3 shadow-sm">

                                        <i class="ri-arrow-left-s-line align-bottom me-2 text-success rounded-pill"></i> Back

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

                <i class="ri-map-pin-line me-1"></i> {{ $viewpaps->location }} &nbsp;|&nbsp;&#x20;

                <i class="ri-calendar-event-line me-1"></i> {{ \Carbon\Carbon::parse($viewpaps->fromdate)->format('F d') }} to {{ \Carbon\Carbon::parse($viewpaps->todate)->format('d, Y') }}

            </p>



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

        <div class="table-responsive">

    <table class="table align-middle mb-0">

        <thead class="table-light">

            <tr>

                <th style="width: 35%;">Task</th>

                <th style="width: 20%;">Assigned To</th>

                <th style="width: 20%;">Progress</th>

                <th style="width: 15%;">Target Date</th>

                <th style="width: 10%;" class="text-center">Action</th>

            </tr>

        </thead>



        <tbody>

            @forelse ($fromtask as $task)



                @php

                    $percent = min(100, max(0, ((float) ($task->reviewer_progress ?? 0)) * 100));



                    $progressClass = $percent >= 80

                        ? 'bg-success'

                        : ($percent >= 50 ? 'bg-warning' : 'bg-danger');

                @endphp



                <tr>



                    {{-- TASK --}}

                    <td>

                        <div class="d-flex align-items-center">



                            <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-3">

                                <i class="ri-task-line text-success fs-18"></i>

                            </div>



                            <div>

                                <a href="/Task/viewtask/{{ $task->taskid }}"

                                   class="fw-semibold text-dark text-decoration-none">

                                    {{ $task->tasks }}

                                </a>



                            </div>



                        </div>

                    </td>



                    {{-- ASSIGNED PERSONNEL --}}

                    <td>

                        <div class="d-flex align-items-center">



                            <img src="{{ $task->avatar }}" class="rounded-circle border" width="32" height="32" alt="Avatar">



                            <span class="text-dark fw-medium">

                                {{ $task->Assigned }}

                            </span>



                        </div>

                    </td>



                    {{-- PROGRESS --}}

                    <td>



                        <div style="min-width: 150px;">



                            <div class="d-flex justify-content-between align-items-center mb-1">



                                <span class="fs-11 text-muted fw-bold text-uppercase"
                                      title="{{ $task->reviewers ?? 'No reviewers assigned' }}">

                                    Progress

                                </span>



                                <span class="fs-11 fw-bold text-dark">

                                    {{ number_format($percent, 0) }}%

                                </span>



                            </div>



                            <div class="progress"

                                 style="height: 7px;">



                                <div class="progress-bar {{ $progressClass }}"

                                     role="progressbar"

                                     style="width: {{ min($percent, 100) }}%;"

                                     aria-valuenow="{{ $percent }}"

                                     aria-valuemin="0"

                                     aria-valuemax="100">

                                </div>



                            </div>



                        </div>



                    </td>



                    {{-- TARGET DATE --}}

                    <td>



                        <span class="badge bg-light text-dark fw-semibold px-3 py-2">



                            <i class="ri-calendar-check-line text-success me-1"></i>



                            {{ $task->duedate }}



                        </span>



                    </td>



                    {{-- ACTION --}}

                    <td class="text-center">

    <div class="d-flex align-items-center justify-content-center gap-2">



        {{-- View --}}

        <a href="/Task/viewtask/{{ $task->taskid }}"

           class="btn btn-sm btn-light rounded-circle shadow-none"

           title="View Details"

           style="width: 34px; height: 34px;">

            <i class="ri-eye-fill text-success"></i>

        </a>



        {{-- Delete --}}

        <form action="/Task/task/{{ $task->taskid }}"

              method="POST"

              class="m-0">

            @csrf



            <button type="submit"

                    class="btn btn-sm btn-light rounded-circle shadow-none"

                    title="Remove Task"

                    style="width: 34px; height: 34px;"

                    onclick="return confirm('Are you sure you want to remove this task?')">

                <i class="ri-delete-bin-line text-danger"></i>

            </button>

        </form>



    </div>

</td>



                </tr>



            @empty



                <tr>

                    <td colspan="5" class="text-center py-5">



                        <div class="text-muted">



                            <i class="ri-task-line fs-30 d-block mb-2"></i>



                            <h6 class="fw-semibold text-dark">

                                No Tasks Found

                            </h6>



                            <p class="fs-12 mb-0">

                                There are currently no tasks assigned to this PAP.

                            </p>



                        </div>



                    </td>

                </tr>



            @endforelse

        </tbody>



    </table>

</div>

    @endif



</div>



<script>

    document.addEventListener('DOMContentLoaded', function() {

        const userType = "{{ Auth::user()->usertype }}";



        const removeTaskBtn = document.getElementById('removeTaskBtn');

        const addtask = document.getElementById('addTaskBtn');



        if (userType === '2') {



            if(removeTaskBtn) removeTaskBtn.style.display = 'none';

            if(addtask) addtask.style.display = 'none';

        }

    });

</script>



@endsection
