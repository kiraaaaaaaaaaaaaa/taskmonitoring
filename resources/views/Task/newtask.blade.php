@extends('components.layout')

@section('content')

<style>
    :root {
        --bs-dark-green: #0a3622;
        --bs-medium-green: #114c31;
        --bs-accent-green: #196f47;
        --bs-golden-yellow: #d4af37;
        --bs-golden-yellow-light: #fef9e7;
        --bs-golden-yellow-border: #f3e5ab;
        --page-bg: #f7f9fa;
        --border: #e7ebe8;
        --text-muted: #7b857f;
    }

    body {
        background-color: var(--page-bg);
    }

    /* =====================================================
       HERO
    ===================================================== */

    .pap-hero-card {
        background: linear-gradient(135deg,
                var(--bs-dark-green),
                var(--bs-accent-green));
        color: #ffffff;
        border: none;
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1.5rem rgba(10, 54, 34, 0.10);
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


    /* =====================================================
       BUTTONS
    ===================================================== */

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


    /* =====================================================
       TABS
    ===================================================== */

    .pap-tabs-wrapper {
        margin-bottom: 30px;
    }

    .pap-tabs {
        display: flex;
        align-items: center;
        gap: 5px;
        width: fit-content;
        max-width: 100%;
        padding: 5px;
        background: #ffffff;
        border: 1px solid var(--border);
        border-radius: 14px;
        box-shadow: 0 5px 18px rgba(10, 54, 34, 0.05);
    }

    .pap-tab {
        border: none;
        background: transparent;
        color: var(--text-muted);
        padding: 11px 20px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.25s ease;
        white-space: nowrap;
    }

    .pap-tab i {
        font-size: 17px;
    }

    .pap-tab:hover {
        color: var(--bs-dark-green);
        background: #edf4ef;
    }

    .pap-tab.active {
        background: var(--bs-dark-green);
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(10, 54, 34, 0.18);
    }

    .pap-tab.active i {
        color: var(--bs-golden-yellow);
    }

    .tab-pane {
        animation: tabFade .25s ease;
    }

    @keyframes tabFade {
        from {
            opacity: 0;
            transform: translateY(5px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }


    /* =====================================================
       TASK CARD
    ===================================================== */

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
    }

    .pap-hero {
        background: #ffffff;
        color: var(--bs-dark-green);
        border: none;
        border-left: 10px solid var(--bs-dark-green);
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1.5rem rgba(10, 54, 34, 0.1);
    }


    /* =====================================================
       OVERVIEW CARDS
    ===================================================== */

    .overview-card {
        background: #ffffff;
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 22px;
        height: 100%;
        box-shadow: 0 5px 18px rgba(10, 54, 34, 0.04);
        transition: all .25s ease;
    }

    .overview-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(10, 54, 34, 0.08);
    }

    .overview-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: #eaf2ed;
        color: var(--bs-dark-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 23px;
        margin-bottom: 16px;
    }

    .overview-label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-muted);
        margin-bottom: 5px;
    }

    .overview-number {
        font-size: 28px;
        font-weight: 700;
        color: var(--bs-dark-green);
    }

    .overview-description {
        font-size: 12px;
        color: var(--text-muted);
        margin-bottom: 0;
    }


    /* =====================================================
       EMPTY STATE
    ===================================================== */

    .empty-state {
        background: #ffffff;
        border: 1px dashed var(--border);
        border-radius: 16px;
        padding: 60px 20px;
        text-align: center;
    }

    .empty-state-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        background: var(--bs-golden-yellow-light);
        color: var(--bs-golden-yellow);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin: 0 auto 15px;
    }

    .empty-state h6 {
        color: var(--bs-dark-green);
        font-weight: 700;
    }

    .empty-state p {
        color: var(--text-muted);
        font-size: 13px;
    }


    /* =====================================================
       RESPONSIVE
    ===================================================== */

    @media (max-width: 768px) {

        .pap-tabs-wrapper {
            overflow-x: auto;
            padding-bottom: 5px;
        }

        .pap-tabs {
            width: max-content;
        }

        .pap-tab {
            padding: 10px 14px;
            font-size: 12px;
        }

        .pap-meta-item {
            font-size: 0.8rem;
        }
    }

    @media (max-width: 576px) {

        .pap-hero-card .card-body {
            padding: 1.25rem !important;
        }

        .pap-tab {
            padding: 9px 12px;
        }

        .pap-tab i {
            font-size: 15px;
        }
    }

</style>


<div class="container-fluid px-0 py-3">


    <!-- =====================================================
         BACK
    ====================================================== -->

    <div class="mb-4">

        <a href="javascript:history.back()" class="btn btn-outline-dark-green btn-label waves-effect waves-light rounded-pill px-3 shadow-sm">

            <i class="ri-arrow-left-s-line align-bottom me-2 text-success"></i>

            Back

        </a>

    </div>



    <!-- =====================================================
         PAP HEADER
    ====================================================== -->

    <div class="card pap-hero-card mb-4">

        <div class="card-body p-4 p-md-5">

            <div class="d-flex align-items-center justify-content-between">

                <h2 class="fw-bold mb-0 text-white">
                    {{ $pap->pap }}
                </h2>

            </div>

        </div>

    </div>



    <!-- =====================================================
         TABS
    ====================================================== -->

    <div class="pap-tabs-wrapper">

        <div class="pap-tabs" role="tablist">


            <!-- OVERVIEW -->

            <button class="pap-tab active" id="general-information-tab" data-bs-toggle="tab" data-bs-target="#general-information" type="button" role="tab" aria-controls="general-information" aria-selected="true">

                <i class="ri-dashboard-line"></i>

                General Information

            </button>


            <!-- SCHEDULED ACTIVITIES -->

            <button class="pap-tab" id="activities-tab" data-bs-toggle="tab" data-bs-target="#activities" type="button" role="tab" aria-controls="activities" aria-selected="false">

                <i class="ri-calendar-check-line"></i>

                Scheduled Activities

            </button>


            <!-- TASKS -->

            <button class="pap-tab" id="tasks-tab" data-bs-toggle="tab" data-bs-target="#tasks" type="button" role="tab" aria-controls="tasks" aria-selected="false">

                <i class="ri-task-line"></i>

                Tasks

            </button>


            <!-- FILES -->

            <button class="pap-tab" id="files-tab" data-bs-toggle="tab" data-bs-target="#files" type="button" role="tab" aria-controls="files" aria-selected="false">

                <i class="ri-folder-3-line"></i>

                Files

            </button>

        </div>

    </div>



    <!-- =====================================================
         TAB CONTENT
    ====================================================== -->

    <div class="tab-content">


        <!-- =================================================
             GENERAL INFORMATION TAB
        ================================================== -->

        <div class="tab-pane fade show active card card-body" id="general-information" role="tabpanel" aria-labelledby="general-information-tab">




            <!-- SECTION HEADER -->

            <div class="mb-4">
                <a data-bs-toggle="modal" id="assignTaskBtn" data-bs-target="#editpap{{ $pap->papsID }}" class="btn rounded-pill float-end" style="color:var(--bs-dark-green);">

                    <i class="ri-settings-2-line align-middle "></i>

                </a>


                <h4 class="fw-bold mb-1" style="color:var(--bs-dark-green);">

                    <i class="ri-information-line me-2"></i>

                    General Information

                </h4>

                <p class="text-muted fs-13 mb-0">

                    General information and details of this PAP.

                </p>

            </div>



            <!-- INFORMATION CARDS -->

            <div class="row g-4">


                <!-- ASSIGNED DIVISION -->

                <div class="col-12 col-md-6 ">

                    <div class="info-card  card card-body card card-activity task-card h-100 pap-hero">

                        <div class="info-icon">

                            <i class="ri-building-line" style="color: var(--bs-golden-yellow);"></i>

                        </div>

                        <div class="info-content ">

                            <div class="info-label">

                                Assigned Division

                            </div>

                            <div class="info-value">

                                {{ $pap->division_name }}

                            </div>

                            @if(!empty($pap->division_short_name))

                            <div class="info-subtext">

                                {{ $pap->division_short_name }}

                            </div>

                            @endif

                        </div>

                    </div>

                </div>



                <!-- FOCAL PERSON -->

                <div class="col-12 col-md-6">

                    <div class="info-card card card-body card card-activity task-card h-100 pap-hero">

                        <div class="info-icon">

                            <i class="ri-user-star-line" style="color: var(--bs-golden-yellow);"></i>

                        </div>

                        <div class="info-content">

                            <div class="info-label">

                                Focal Person

                            </div>

                            <div class="info-value">

                                {{ $pap->focalPerson }}

                            </div>

                        </div>

                    </div>

                </div>



                <!-- OUTPUT SUPPORTED -->

                <div class="col-12 col-md-6">

                    <div class="info-card card card-body card card-activity task-card h-100 pap-hero">

                        <div class="info-icon">

                            <i class="ri-flag-line" style="color: var(--bs-golden-yellow);"></i>

                        </div>

                        <div class="info-content">

                            <div class="info-label">

                                Output Supported

                            </div>

                            <div class="info-value">

                                {{ $pap->oosName }}

                            </div>

                        </div>

                    </div>

                </div>



                <!-- FUND SOURCE -->

                <div class="col-12 col-md-6">

                    <div class="info-card card card-body card card-activity task-card h-100 pap-hero   ">

                        <div class="info-icon">

                            <i class="ri-money-dollar-circle-line" style="color: var(--bs-golden-yellow);"></i>

                        </div>

                        <div class="info-content">

                            <div class="info-label">

                                Fund Source

                            </div>

                            <div class="info-value">

                                {{ $pap->fundName }}

                            </div>

                        </div>

                    </div>

                </div>


            </div>



            <!-- DESCRIPTION -->

            @if(!empty($pap->description))

            <div class="info-card mt-4 card card-body card card-activity task-card h-100 pap-hero">

                <div class="info-icon">

                    <i class="ri-file-text-line"></i>

                </div>

                <div class="info-content">

                    <div class="info-label">

                        Description

                    </div>

                    <div class="info-description">

                        {{ $pap->description }}

                    </div>

                </div>

            </div>

            @endif


        </div>



        <!-- =================================================
             SCHEDULED ACTIVITIES TAB
        ================================================== -->

        <div class="tab-pane fade" id="activities" role="tabpanel" aria-labelledby="activities-tab">


            <!-- SECTION HEADER -->

            <div class="d-flex align-items-center justify-content-between mb-4">

                <div>

                    <h4 class="fw-bold mb-1" style="color:var(--bs-dark-green);">

                        <i class="ri-calendar-check-line me-2"></i>

                        Scheduled Activities

                    </h4>

                    <p class="text-muted fs-13 mb-0">

                        Manage scheduled activities for this PAP.

                    </p>

                </div>


                <a data-bs-toggle="modal" id="assignTaskBtn" data-bs-target="#addPapModal" class="btn btn-dark-green btn-label rounded-pill px-4 py-2 shadow-sm">

                    <i class="ri-add-line align-middle fs-16 me-2"></i>

                    Add Schedule

                </a>

            </div>



            <!-- ACTIVITY CARDS -->

            @if(count($newtask) > 0)

            <div class="row g-4">

                @foreach ($newtask as $task)

                <div class="col-12 col-md-6 col-xl-4">

                    <div class="card card-activity task-card h-100 pap-hero">

                        <div class="card-body p-4 d-flex flex-column justify-content-between">


                            <!-- TOP -->

                            <div>

                                <div class="d-flex justify-content-between align-items-center mb-3">

                                    @php
                                    $quarter = \Carbon\Carbon::parse($task->fromdate)->quarter;
                                    @endphp

                                    <span class="badge btn-dark-green border px-2.5 py-1.5 rounded-pill fs-11" style="color: #d4af37;">
                                        <i class="ri-calendar-event-line me-2"></i>
                                        Q{{ $quarter }}
                                    </span>
                                    <!--<span class="badge badge-label bg-primary"><i class="mdi mdi-circle-medium"></i> Primary</span> -->

                                    <div></div>


                                    <!-- DROPDOWN -->

                                    <div class="dropdown">

                                        <a href="#" class="btn btn-icon btn-sm btn-ghost-secondary rounded-circle shadow-none" data-bs-toggle="dropdown" aria-expanded="false">

                                            <i class="ri-more-2-fill fs-16"></i>

                                        </a>


                                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 py-2">


                                            <!-- ADD TASK -->

                                            <li>

                                                <a class="dropdown-item addTaskBtn py-2 text-dark" href="/Task.createtask/{{ $task->newID }}" id="addTaskBtn">

                                                    <i class="ri-add-circle-line align-bottom me-2 text-success"></i>

                                                    Add Task

                                                </a>

                                            </li>


                                            <!-- EDIT -->

                                            <li>

                                                <a href="#" class=" dropdown-item text-warning editPapLink" data-bs-toggle="modal" data-bs-target="#editPapModal" data-id="{{ $task->newID }}" data-google-calendar-event-id="{{ $task->googlecalendareventID }}" data-pap-id="{{ $task->papID }}" data-pap="{{ $task->pap }}" data-location="{{ $task->location }}" data-date-from="{{ $task->fromdate }}" data-date-end="{{ $task->todate }}" data-description="{{ $task->description }}">

                                                    <i class="ri-pencil-line align-bottom me-2"></i>
                                                    Edit Activity
                                                </a>

                                            </li>


                                            <!-- REMOVE -->

                                            <li class="removePapBtn">

                                                <form action="/Task/pap/{{ $task->newID }}" method="POST" class="d-inline">

                                                    @csrf

                                                    <button type="submit" class="dropdown-item py-2 text-danger" onclick="return confirm('Are you sure you want to remove this Activity?')">

                                                        <i class="ri-subtract-line align-bottom me-2"></i>

                                                        Remove Activity

                                                    </button>

                                                </form>

                                            </li>


                                            <li>

                                                <hr class="dropdown-divider my-1">

                                            </li>


                                            <!-- VIEW -->

                                            <li>

                                                <a class="dropdown-item py-2 text-dark" href="/Task/task/{{ $task->fromdate }}/{{ $task->newID }}">

                                                    <i class="ri-eye-line align-bottom me-2 text-primary"></i>

                                                    View Details

                                                </a>

                                            </li>

                                        </ul>

                                    </div>

                                </div>



                                <!-- PAP NAME -->

                                <h5 class="fw-bold text-dark mb-2 text-truncate" title="{{ $task->pap }}">

                                    {{ $task->pap }}

                                </h5>



                                <!-- DESCRIPTION -->

                                @if(!empty($task->description))

                                <p class="text-muted fs-12 mb-3" style="
                                                    display:-webkit-box;
                                                    -webkit-line-clamp:2;
                                                    -webkit-box-orient:vertical;
                                                    overflow:hidden;
                                                ">

                                    {{ $task->description }}

                                </p>

                                @endif

                            </div>



                            <!-- FOOTER -->

                            <div class="pt-3 border-top mt-3 d-flex align-items-center justify-content-between text-muted fs-12">


                                <!-- LOCATION -->

                                <div class="d-flex align-items-center gap-1 text-truncate">

                                    <i class="ri-map-pin-line text-success"></i>

                                    <span class="text-truncate" style="max-width:140px;" title="{{ $task->location }}">

                                        {{ $task->location ?: 'Location TBD' }}

                                    </span>

                                </div>


                                <!-- DATE -->

                                <div class="text-nowrap font-monospace text-dark fw-medium">

                                    <i class="ri-calendar-2-line text-warning me-1">
                                    </i>

                                    {{ \Carbon\Carbon::parse($task->fromdate)->format('M d') }}

                                    -

                                    {{ \Carbon\Carbon::parse($task->todate)->format('M d, Y') }}

                                </div>

                            </div>


                        </div>

                    </div>

                </div>

                @endforeach

            </div>

            @else

            <div class="empty-state">

                <div class="empty-state-icon">

                    <i class="ri-calendar-close-line"></i>

                </div>

                <h6>

                    No Scheduled Activities

                </h6>

                <p>

                    There are currently no activities scheduled for this PAP.

                </p>

            </div>

            @endif

        </div>



        <!-- =================================================
             TASKS TAB
        ================================================== -->

        <div class="tab-pane fade" id="tasks" role="tabpanel" aria-labelledby="tasks-tab">


            <div class="d-flex align-items-center justify-content-between mb-4">

                <div>

                    <h4 class="fw-bold mb-1" style="color:var(--bs-dark-green);">

                        <i class="ri-task-line me-2"></i>

                        Tasks

                    </h4>



                    <p class="text-muted fs-13 mb-0">

                        Manage tasks associated with this PAP.

                    </p>

                </div>


                <button type="button" class="btn btn-dark-green rounded-pill px-4" href="#" data-bs-toggle="modal" data-bs-target="#papModal{{$pap->papsID}}">

                    <i class="ri-add-line me-1"></i>

                    Add Task

                </button>

            </div>

            @if(count($newtaskforpap) > 0)

            <div>


                <div calss="dynamic-table">
                    <table class="table table-hover table-nowrap align-middle mb-0" id="taskTable">
                        <thead class="table-light">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col" class="text-center" style="width: 120px;">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($newtaskforpap as $task)
                            <tr>
                                {{-- Task Description --}}
                                <td>
                                    <span class="fw-medium text-dark">
                                        {{ $task->tasks }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-2">

                                        {{-- Edit --}}
                                        <a href="#" class="btn btn-sm btn-light rounded-circle shadow-none" data-bs-toggle="modal" data-bs-target="#edittasks{{ $task->id }}" title="Edit Task" style="width: 34px; height: 34px;">
                                            <i class="ri-pencil-line text-warning"></i>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="/papmangement/task/{{ $task->id }}" method="POST" class="m-0" onsubmit="return confirm('Are you sure you want to delete this task?');">

                                            @csrf

                                            <button type="submit" class="btn btn-sm btn-light rounded-circle shadow-none" title="Delete Task" style="width: 34px; height: 34px;">
                                                <i class="ri-delete-bin-line text-danger"></i>
                                            </button>

                                        </form>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>


            @else

            <div class="empty-state">

                <div class="empty-state-icon">

                    <i class="ri-task-line"></i>

                </div>

                <h6>

                    No Tasks Available

                </h6>

                <p>

                    Tasks associated with this PAP will appear here.

                </p>

            </div>

            @endif

        </div>



        <!-- =================================================
             FILES TAB
        ================================================== -->

        <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab">


            <div class="d-flex align-items-center justify-content-between mb-4">

                <div>

                    <h4 class="fw-bold mb-1" style="color:var(--bs-dark-green);">

                        <i class="ri-folder-3-line me-2"></i>

                        Files & Documents

                    </h4>

                    <p class="text-muted fs-13 mb-0">

                        Manage documents associated with this PAP.

                    </p>

                </div>




            </div>

            @if(count($link) == 0)



            <div class="empty-state">

                <div class="empty-state-icon">

                    <i class="ri-folder-open-line"></i>

                </div>

                <h6>

                    No Files Available

                </h6>

                <p>

                    Uploaded documents will appear here.

                </p>

            </div>

            @else


            <div class="empty-state">

                <table class="table table-hover table-nowrap align-middle mb-0" id="taskTable">
                    <thead>
                        <tr>
                            <th></th>
                            <th>File for</th>
                            <th>Uploaded By</th>
                            <th>File Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($link as $date => $tasks)

                        {{-- DATE HEADER --}}
                        <tr class="table-light">
                            <td class="fw-bold text-start" colspan="5">
                                <i class="ri-calendar-line me-1"></i>
                                {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}
                            </td>
                        </tr>

                        {{-- TASKS UNDER THIS DATE --}}
                        @foreach ($tasks as $task)
                        <tr>
                            <td></td>
                            <td>
                                {{ $task->taskname }}
                            </td>

                            <td>
                                {{ $task->assignedName ?? 'Not Assigned' }}
                            </td>
                            <td>
                                {{ $task->link }}
                            </td>

                            <td>
                                @if ($task->link)
                                <a href="{{ $task->link }}" target="_blank" class="btn btn-sm btn-primary">
                                    <i class="ri-external-link-line me-1"></i>
                                    Open Link
                                </a>
                                @else
                                <span class="text-muted">No Link</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach



                        @endforeach


                    </tbody>
                </table>


            </div>
            @endif

        </div>


    </div>


</div>



<!-- =====================================================
     ADD PAP MODAL
====================================================== -->

<div class="modal fade" id="addPapModal" tabindex="-1" aria-labelledby="addPapModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header border-0 pb-0">

                <h5 class="modal-title fw-bold text-dark" id="addPapModalLabel">

                    New Activity Milestone

                </h5>

                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close">
                </button>

            </div>


            <form method="POST" action="{{ route('savePAP') }}">

                @csrf

                <div class="modal-body pt-3">


                    <!-- PAP -->

                    <div class="mb-3">

                        <label for="papName" class="form-label fw-semibold fs-13">

                            PAP Name

                            <span class="text-danger">*</span>

                        </label>

                        <input type="text" class="form-control rounded-3 py-2" id="papName" name="papName" value="{{ $pap->pap }}" readonly>

                        <input type="hidden" value="{{ $pap->papsID }}" name="pap">

                    </div>


                    <!-- DESCRIPTION -->

                    <div class="mb-3">

                        <label for="description" class="form-label fw-semibold fs-13">

                            Description

                            <span class="text-danger">*</span>

                        </label>

                        <textarea class="form-control rounded-3 py-2" id="description" name="description" rows="4" placeholder="Brief activity details" required></textarea>

                    </div>


                    <!-- DATE -->

                    <div class="mb-3">

                        <label class="form-label fw-semibold fs-13">

                            Indicative Date Range

                            <span class="text-danger">*</span>

                        </label>


                        <div class="row g-2">

                            <div class="col-6">

                                <div class="input-group">

                                    <span class="input-group-text bg-light border-end-0 fs-12">

                                        From

                                    </span>

                                    <input type="date" class="form-control rounded-end py-2" id="indicativeDate" name="datefrom" required>

                                </div>

                            </div>


                            <div class="col-6">

                                <div class="input-group">

                                    <span class="input-group-text bg-light border-end-0 fs-12">

                                        To

                                    </span>

                                    <input type="date" class="form-control rounded-end py-2" id="indicativeDateEnd" name="dateend" required>

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- LOCATION -->

                    <div class="mb-3">

                        <label for="location" class="form-label fw-semibold fs-13">

                            Location

                        </label>

                        <input type="text" class="form-control rounded-3 py-2" id="location" name="location" placeholder="Venue or location">

                    </div>

                </div>


                <div class="modal-footer border-0 pt-0">

                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">

                        Close

                    </button>

                    <button type="submit" class="btn btn-dark-green rounded-pill px-4">

                        Save Activity

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<!====================================================== EDIT PAP MODAL======================================================-->
    <form action="{{ route('createPAP') }}" method="POST">
        @csrf

        <div class="modal fade" id="editpap{{ $pap->papsID }}" tabindex="-1" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">

                    <div class="modal-body p-4">

                        {{-- PAP ID --}}
                        <input type="hidden" name="PAP" value="{{ $pap->papsID }}">

                        {{-- PAP Name --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                PAP Name
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="editpapname" class="form-control shadow-none" value="{{ $pap->pap }}" required>
                        </div>

                        {{-- Sector - Hidden --}}
                        <div class="mb-3 d-none">
                            <select class="form-select" id="sectorselect{{ $pap->papsID }}" name="editsectorselect">

                                <option value="{{ $pap->sectorID }}" selected>
                                    {{ $pap->sector->sector_name ?? '' }}
                                </option>

                            </select>
                        </div>

                        {{-- Division + Fund Source --}}
                        <div class="row">

                            {{-- Division --}}
                            <div class="col-md-6 mb-3 d-none">
                                <label for="divisionSelect{{ $pap->papsID }}" class="form-label fw-semibold">
                                    Assign Division
                                    <span class="text-danger">*</span>
                                </label>

                                <select class="form-select shadow-none" id="divisionSelect{{ $pap->papsID }}" name="editdivisionSelect" required>

                                    <option value="{{ $pap->divID }}" selected>
                                        {{ $pap->division->division_name ?? '-- Select Division --' }}
                                    </option>

                                </select>
                            </div>

                            {{-- Fund Source --}}
                            <div class="col-md-6 mb-3">
                                <label for="funds{{ $pap->papsID }}" class="form-label fw-semibold">
                                    Fund Source
                                    <span class="text-danger">*</span>
                                </label>

                                <select class="form-select shadow-none" id="funds{{ $pap->papsID }}" name="editfunds" required>

                                    <option value="" disabled>
                                        -- Select Source of Fund --
                                    </option>

                                    @foreach($fund as $funds)
                                    <option value="{{ $funds->id }}" {{ $pap->fundID == $funds->id ? 'selected' : '' }}>
                                        {{ $funds->fundName }}
                                    </option>
                                    @endforeach

                                </select>
                            </div>

                        </div>

                        {{-- Focal + Output/Outcome --}}
                        <div class="row">

                            {{-- Focal --}}
                            <div class="col-md-6 mb-3">
                                <label for="focalSelect{{ $pap->papsID }}" class="form-label fw-semibold">
                                    Assign Focal
                                    <span class="text-danger">*</span>
                                </label>

                                <select class="form-select shadow-none" id="focalSelect{{ $pap->papsID }}" name="editfocalSelect" required>

                                    <option value="" disabled>
                                        -- Select Focal --
                                    </option>

                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $pap->userID == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                    @endforeach

                                </select>
                            </div>

                            {{-- Output / Outcome --}}
                            <div class="col-md-6 mb-3">
                                <label for="oosSelect{{ $pap->papsID }}" class="form-label fw-semibold">
                                    Output/Outcome Supported
                                    <span class="text-danger">*</span>
                                </label>

                                <select class="form-select shadow-none" id="oosSelect{{ $pap->papsID }}" name="editoosSelect" required>

                                    <option value="" disabled>
                                        -- Select Output/Outcome --
                                    </option>

                                    @foreach($oos as $output)
                                    <option value="{{ $output->oosID }}" {{ $pap->oosID == $output->oosID ? 'selected' : '' }}>
                                        {{ $output->oosName }}
                                    </option>
                                    @endforeach

                                </select>
                            </div>

                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="modal-footer bg-light px-4 py-3">

                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                            Close
                        </button>

                        <button type="submit" class="btn btn-theme-accent rounded-pill px-4" name="action" value="editpap">
                            Save Activity
                        </button>

                    </div>

                </div>
            </div>
        </div>

    </form>

    <!-- ================= ADD TASK MODALS ================= -->
    <div>

        <form action="{{ route('createPAP') }}" method="POST">
            @csrf
            <div class="modal fade" id="papModal{{$pap->papsID}}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header modal-header-custom p-4">
                            <h5 class="modal-title fw-bold">Add Task to: {{$pap->pap}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-4">
                            <input type="text" name="PAP" value="{{$pap->papsID}}" hidden>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Task Description <span class="text-danger">*</span></label>
                                <input type="text" name="task" class="form-control shadow-none" placeholder="Enter Task Details" required>
                            </div>
                        </div>
                        <div class="modal-footer bg-light px-4 py-3">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-theme-primary rounded-pill px-4" name="action" value="task">Save Task</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>

    <!-- =====================================================
     EDIT TASK MODALS
====================================================== -->
    @foreach ($newtaskforpap as $newtaskforpap)
    <form action="{{ route('createPAP') }}" method="POST">
        @csrf
        <div class="modal fade" id="edittasks{{$newtaskforpap->id}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header modal-header-custom p-4">
                        <h5 class="modal-title fw-bold">Edit Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <input type="text" name="PAP" value="{{$newtaskforpap->id}}" hidden>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Task Description <span class="text-danger">*</span></label>
                            <input type="text" name="task" class="form-control shadow-none" value="{{$newtaskforpap->tasks}}" required>
                        </div>
                    </div>
                    <div class="modal-footer bg-light px-4 py-3">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-theme-primary rounded-pill px-4" name="action" value="edittask">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endforeach

    <!-- ===========================================
Edit Activity Modal
=========================================== -->

    <div class="modal fade" id="editPapModal" tabindex="-1" aria-labelledby="editPapModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header border-0 pb-0">

                    <h5 class="modal-title fw-bold text-dark" id="editPapModalLabel">

                        Edit Activity Milestone

                    </h5>


                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal">

                    </button>

                </div>


                <form method="POST" action="{{ route('savePAP') }}">

                    @csrf

                    <div class="modal-body pt-3">


                        <input type="hidden" id="editpapid" name="editpapid">


                        <input type="hidden" id="googlecalendareventID" name="googlecalendareventID">


                        {{-- PAP NAME --}}

                        <div class="mb-3">

                            <label for="editpapName" class="form-label fw-semibold fs-13">

                                PAP Name

                            </label>


                            <input type="text" class="form-control rounded-3 py-2 bg-light text-muted" id="editpapName" name="editpapName" readonly>

                        </div>


                        {{-- DESCRIPTION --}}

                        <div class="mb-3">

                            <label for="editdescription" class="form-label fw-semibold fs-13">

                                Description

                            </label>


                            <input type="text" class="form-control rounded-3 py-2" id="editdescription" name="editdescription" placeholder="Description details">

                        </div>


                        {{-- DATES --}}

                        <div class="mb-3">

                            <label class="form-label fw-semibold fs-13">

                                Indicative Date Range

                            </label>


                            <div class="row g-2">

                                <div class="col-6">

                                    <div class="input-group">

                                        <span class="input-group-text bg-light border-end-0 fs-12">
                                            From
                                        </span>

                                        <input type="date" class="form-control rounded-end py-2" id="editindicativeDate" name="editdatefrom">

                                    </div>

                                </div>


                                <div class="col-6">

                                    <div class="input-group">

                                        <span class="input-group-text bg-light border-end-0 fs-12">
                                            To
                                        </span>

                                        <input type="date" class="form-control rounded-end py-2" id="editindicativeDateEnd" name="editdateend">

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- LOCATION --}}

                        <div class="mb-3">

                            <label for="editlocation" class="form-label fw-semibold fs-13">

                                Location

                            </label>


                            <input type="text" class="form-control rounded-3 py-2" id="editlocation" name="editlocation" placeholder="Venue or location">

                        </div>

                    </div>


                    <div class="modal-footer border-0 pt-0">

                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">

                            Close

                        </button>


                        <button type="submit" class="btn btn-dark-green rounded-pill px-4">

                            Save Changes

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>




    <!-- =====================================================
     JAVASCRIPT
====================================================== -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userType = "{{ Auth::user()->usertype }}";


            /*
            |--------------------------------------------------------------------------
            | USER TYPE PERMISSIONS
            |--------------------------------------------------------------------------
            */

            if (userType === '2') {

                document
                    .querySelectorAll('.removePapBtn')
                    .forEach(function(element) {

                        element.style.display = 'none';

                    });


                document
                    .querySelectorAll('.addTaskBtn')
                    .forEach(function(element) {

                        element.style.display = 'none';

                    });

            }


            /*
            |--------------------------------------------------------------------------
            | CLOSE ALL DROPDOWNS WHEN A TAB IS CHANGED
            |--------------------------------------------------------------------------
            */

            document
                .querySelectorAll('.pap-tab')
                .forEach(function(tab) {

                    tab.addEventListener('click', function() {

                        document
                            .querySelectorAll('.dropdown.show')
                            .forEach(function(dropdown) {

                                const button =
                                    dropdown.querySelector('[data-bs-toggle="dropdown"]');

                                if (button) {

                                    bootstrap.Dropdown
                                        .getOrCreateInstance(button)
                                        .hide();

                                }

                            });

                    });

                });


            /*
            |--------------------------------------------------------------------------
            | CLOSE DROPDOWNS WHEN CLICKING OUTSIDE
            |--------------------------------------------------------------------------
            */

            document.addEventListener('click', function(event) {

                if (!event.target.closest('.dropdown')) {

                    document
                        .querySelectorAll('.dropdown.show')
                        .forEach(function(dropdown) {

                            const button =
                                dropdown.querySelector('[data-bs-toggle="dropdown"]');

                            if (button) {

                                bootstrap.Dropdown
                                    .getOrCreateInstance(button)
                                    .hide();

                            }

                        });

                }

            });







        });

        
        document.addEventListener("DOMContentLoaded", function() {

            // Hide all task rows when page loads
            document.querySelectorAll(".task-row").forEach(function(task) {
                task.classList.add("d-none");
            });

            // Set all arrows to right arrow initially
            document.querySelectorAll(".toggle-icon").forEach(function(icon) {
                icon.classList.remove("ri-arrow-down-s-line");
                icon.classList.add("ri-arrow-right-s-line");

                icon.addEventListener("click", function() {

                    const papId = this.dataset.pap;
                    const tasks = document.querySelectorAll(".task-group-" + papId);

                    tasks.forEach(function(task) {
                        task.classList.toggle("d-none");
                    });

                    if (this.classList.contains("ri-arrow-down-s-line")) {
                        this.classList.remove("ri-arrow-down-s-line");
                        this.classList.add("ri-arrow-right-s-line");
                    } else {
                        this.classList.remove("ri-arrow-right-s-line");
                        this.classList.add("ri-arrow-down-s-line");
                    }

                });
            });

        });

        document.addEventListener('DOMContentLoaded', function() {

            const divisions = @json($division);

            /*
            |--------------------------------------------------------------------------
            | Edit PAP Modal
            |--------------------------------------------------------------------------
            */

            document.querySelectorAll('.modal[id^="editpap"]').forEach(function(modal) {

                modal.addEventListener('show.bs.modal', function() {

                    const papId = modal.id.replace('editpap', '');

                    const sectorSelect = document.getElementById(
                        'sectorselect' + papId
                    );

                    const divisionSelect = document.getElementById(
                        'divisionSelect' + papId
                    );

                    if (!sectorSelect || !divisionSelect) {
                        return;
                    }

                    const sectorID = sectorSelect.value;

                    /*
                     * Store the currently selected division
                     * before rebuilding the options.
                     */
                    const currentDivision = divisionSelect.value;

                    /*
                     * Clear existing division options
                     */
                    divisionSelect.innerHTML = '';

                    /*
                     * Default option
                     */
                    const defaultOption = document.createElement('option');
                    defaultOption.value = '';
                    defaultOption.textContent = '-- Select Division --';

                    divisionSelect.appendChild(defaultOption);

                    /*
                     * Populate divisions based on sector
                     */
                    divisions.forEach(function(div) {

                        if (String(div.sectorID) === String(sectorID)) {

                            const option = document.createElement('option');

                            option.value = div.id;

                            option.textContent =
                                div.division_name +
                                (div.division_short_name ?
                                    ' (' + div.division_short_name + ')' :
                                    '');

                            /*
                             * Restore current division
                             */
                            if (
                                String(div.id) ===
                                String(currentDivision)
                            ) {
                                option.selected = true;
                            }

                            divisionSelect.appendChild(option);
                        }

                    });

                });

            });


        });

        document.addEventListener('DOMContentLoaded', function() {

            const editModal = document.getElementById('editPapModal');

            if (!editModal) {
                console.error('Edit Activity modal not found.');
                return;
            }

            document.querySelectorAll('.editPapLink').forEach(function(link) {

                link.addEventListener('click', function() {

                    // Get values from the clicked activity
                    const papId = this.dataset.id || '';
                    const papName = this.dataset.pap || '';
                    const location = this.dataset.location || '';
                    const dateFrom = this.dataset.dateFrom || '';
                    const dateEnd = this.dataset.dateEnd || '';
                    const description = this.dataset.description || '';
                    const googleCalendarEventID =
                        this.dataset.googleCalendarEventId || '';

                    // Populate Edit Activity modal
                    document.getElementById('editpapid').value = papId;

                    document.getElementById('editpapName').value = papName;

                    document.getElementById('editlocation').value = location;

                    document.getElementById('editindicativeDate').value = dateFrom;

                    document.getElementById('editindicativeDateEnd').value = dateEnd;

                    document.getElementById('editdescription').value = description;

                    document.getElementById('googlecalendareventID').value =
                        googleCalendarEventID;

                });

            });

        });

    </script>


    @endsection
