@extends('components.layout')

@section('content')

<style>

    /* =========================================================
       THEME
       ========================================================= */

    :root {
        --bs-dark-green: #0b3c29;
        --bs-medium-green: #134e38;
        --bs-accent-green: #1f7a55;
        --bs-golden-yellow: #d4af37;
        --bs-golden-yellow-light: #fef9e7;
    }

    body {
        background-color: #f8f9fa;
    }


    /* =========================================================
       CARD VIEW
       ========================================================= */

    .card-activity {
        border: none;
        border-radius: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 0.5rem 1.25rem rgba(11, 60, 41, 0.04);
        background: #ffffff;
        overflow: hidden;
    }

    .card-activity:hover {
        transform: translateY(-4px);
        box-shadow: 0 0.75rem 2rem rgba(11, 60, 41, 0.08);
    }

    .pap-hero-card {
        background: #ffffff;
        color: var(--bs-dark-green);
        border: none;
        border-left: 10px solid var(--bs-dark-green);
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1.5rem rgba(10, 54, 34, 0.1);
    }

    .task-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1.25rem rgba(10, 54, 34, 0.08);
        border-color: var(--bs-golden-yellow);
    }


    /* =========================================================
       MONTH NAVIGATION
       ========================================================= */

    .month-nav-container {
        background: #ffffff;
        border-radius: 50rem;
        padding: 0.5rem 1.5rem;
        box-shadow: 0 0.25rem 0.75rem rgba(11, 60, 41, 0.04);
        display: inline-flex;
        align-items: center;
    }

    .btn-month-nav {
        background-color: var(--bs-golden-yellow-light);
        color: var(--bs-dark-green);
        border: 1px solid rgba(212, 175, 55, 0.3);
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .btn-month-nav:hover {
        background-color: var(--bs-golden-yellow);
        color: #ffffff;
    }


    /* =========================================================
       BUTTONS
       ========================================================= */

    .btn-dark-green {
        background-color: var(--bs-dark-green);
        color: #ffffff;
        border: none;
        transition: background-color 0.2s ease;
    }

    .btn-dark-green:hover {
        background-color: var(--bs-medium-green);
        color: #ffffff;
    }

    .btn-golden {
        background-color: var(--bs-golden-yellow);
        color: #ffffff;
        border: none;
    }

    .btn-golden:hover {
        background-color: #b8972b;
        color: #ffffff;
    }


    /* =========================================================
       VIEW TOGGLE
       ========================================================= */

    .view-toggle {
        background: #ffffff;
        border: 1px solid #e8ecea;
        border-radius: 50rem;
        padding: 3px;
        display: inline-flex;
        box-shadow: 0 0.25rem 0.75rem rgba(11, 60, 41, 0.04);
    }

    .view-toggle .btn {
        border: none;
        border-radius: 50rem !important;
        padding: 7px 15px;
        font-size: 12px;
        transition: all 0.2s ease;
    }

    .view-toggle .btn-dark-green {
        background-color: var(--bs-dark-green);
        color: #ffffff;
    }

    .view-toggle .btn-light {
        background-color: transparent;
        color: #6c757d;
    }

    .view-toggle .btn-light:hover {
        background-color: #f5f7f6;
        color: var(--bs-dark-green);
    }


    /* =========================================================
       BADGES
       ========================================================= */

    .activity-badge-done {
        background-color: #e8f5e9;
        color: #2e7d32;
        border: 1px solid rgba(46, 125, 50, 0.2);
    }

    .activity-badge-today {
        background-color: var(--bs-golden-yellow-light);
        color: #8c7310;
        border: 1px solid rgba(212, 175, 55, 0.3);
    }


    /* =========================================================
       MODAL
       ========================================================= */

    .modal-content {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.15);
    }


    /* =========================================================
       YEARLY TABLE
       ========================================================= */

    .yearly-pap-table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }


    /* YEAR HEADER */

    .year-header th {
        background: #f8faf9;
        color: var(--bs-dark-green);
        padding: 20px 24px;
        border-bottom: 1px solid #e4e9e6;
    }

    .year-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: var(--bs-golden-yellow-light);
        color: var(--bs-golden-yellow);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
    }


    /* TABLE COLUMN HEADER */

    .yearly-pap-table .column-header th {
        background: #ffffff;
        color: #6c757d;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        padding: 13px 10px;
        border-bottom: 1px solid #e9ecef;
        white-space: nowrap;
    }


    /* MONTH ROW */

    .month-group-row td {
        background: #eef5f1;
        color: var(--bs-dark-green);
        font-size: 14px;
        padding: 13px 24px !important;
        border-top: 1px solid #dfe9e4;
        border-bottom: 1px solid #dfe9e4;
    }

    .month-small-icon {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--bs-dark-green);
    }

    .month-group-row .badge {
        background: var(--bs-dark-green);
        color: #ffffff;
        font-size: 10px;
    }


    /* PAP GROUP ROW */

    .pap-group-row td {
        background: #fafcfb;
        padding: 12px 20px !important;
        border-bottom: 1px solid #edf1ef;
    }

    .pap-group-icon {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        background: var(--bs-dark-green);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
    }


    /* ACTIVITY ROW */

    .activity-row td {
        padding: 13px 10px;
        background: #ffffff;
        border-bottom: 1px solid #f0f2f1;
        font-size: 12px;
    }

    .activity-row:hover td {
        background: #fafcfb;
    }


    /* ACTIVITY NUMBER */

    .activity-number {
        width: 25px;
        height: 25px;
        border-radius: 50%;
        background: #f1f4f2;
        color: var(--bs-dark-green);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: 700;
        flex-shrink: 0;
    }


    /* EMPTY MONTH */

    .empty-month-row td {
        background: #ffffff;
        padding: 10px 20px;
        font-size: 12px;
    }


    /* TABLE ACTIONS */

    .yearly-pap-table .btn-light {
        border: 1px solid #edf0ee;
        background: #ffffff;
    }

    .yearly-pap-table .btn-light:hover {
        background: #f4f7f5;
    }


    /* =========================================================
       RESPONSIVE
       ========================================================= */

    @media (max-width: 768px) {

        .view-toggle .btn {
            padding: 7px 11px;
        }

        .view-toggle .btn span {
            display: none;
        }

        .yearly-pap-table {
            min-width: 1000px;
        }

        .month-nav-container {
            padding: 0.4rem 0.8rem;
        }

        .month-nav-container span {
            font-size: 13px !important;
        }

    }

</style>





{{-- =========================================================
     PAGE HEADER
     ========================================================= --}}

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h4 class="fw-bold text-dark mb-1">
            Activity Schedule
        </h4>

    </div>


    <div class="d-flex align-items-center gap-2">


        {{-- VIEW TOGGLE --}}

        <div class="view-toggle">

            <button type="button"
                    class="btn btn-dark-green active"
                    id="cardViewBtn">

                <i class="ri-layout-grid-line me-1"></i>
                <span>Cards</span>

            </button>


            <button type="button"
                    class="btn btn-light"
                    id="tableViewBtn">

                <i class="ri-table-line me-1"></i>
                <span>Table</span>

            </button>

        </div>


        {{-- ADD ACTIVITY --}}

        <a data-bs-toggle="modal"
           id="assignTaskBtn"
           data-bs-target="#addPapModal"
           class="btn btn-dark-green btn-label rounded-pill px-4 py-2 shadow-sm">

            <i class="ri-add-line align-middle rounded-pill fs-16 me-2"></i>

            Add Activity

        </a>

    </div>

</div>



{{-- =========================================================
     CARD VIEW
     ========================================================= --}}

<div id="cardViewSection">
{{-- =========================================================
     MONTH NAVIGATION
     This is ONLY for CARD VIEW
     ========================================================= --}}

<div class="d-flex justify-content-center align-items-center mb-4" id="monthNavContainer" >

    <div class="month-nav-container" >

        {{-- PREVIOUS MONTH --}}

        <a href="{{ route('calendar', [
            'year' => $Month == 1 ? $Year - 1 : $Year,
            'month' => $Month == 1 ? 12 : $Month - 1
        ]) }}"
        class="btn btn-month-nav me-3 shadow-none text-decoration-none">

            <i class="ri-arrow-left-s-line fs-18"></i>

        </a>


        {{-- CURRENT MONTH --}}

        <span class="fw-bold fs-5 text-dark px-3 font-monospace">

            {{ \Carbon\Carbon::create($Year, $Month, 1)->format('F Y') }}

        </span>


        {{-- NEXT MONTH --}}

        <a href="{{ route('calendar', [
            'year' => $Month == 12 ? $Year + 1 : $Year,
            'month' => $Month == 12 ? 1 : $Month + 1
        ]) }}"
        class="btn btn-month-nav ms-3 shadow-none text-decoration-none">

            <i class="ri-arrow-right-s-line fs-18"></i>

        </a>

    </div>

</div>

    @if($newtask->isEmpty())

        <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white">

            <div class="avatar-lg mx-auto mb-3 bg-light rounded-circle d-flex align-items-center justify-content-center text-muted fs-24">

                <i class="ri-calendar-line"></i>

            </div>

            <h5 class="fw-bold text-dark">
                No Activities Found
            </h5>

            <p class="text-muted fs-13 mb-0">

                No PAPs are scheduled for
                {{ \Carbon\Carbon::create($Year, $Month, 1)->format('F Y') }}.

            </p>

        </div>

    @else

        <div class="row g-4">

            @foreach ($newtask as $task)

                <div class="col-12 col-md-6 col-xl-4">

                    <div class="card card-activity task-card h-100 pap-hero-card">

                        <div class="card-body p-4 d-flex flex-column justify-content-between">

                            <div>


                                {{-- CARD HEADER --}}

                                <div class="d-flex justify-content-between align-items-center mb-3">

                                    <div></div>

                                    <div class="dropdown">

                                        <a href="#"
                                           class="btn btn-icon btn-sm btn-ghost-secondary rounded-circle shadow-none"
                                           data-bs-toggle="dropdown">

                                            <i class="ri-more-2-fill fs-16"></i>

                                        </a>


                                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 py-2">


                                            {{-- ADD TASK --}}

                                            <li>

                                                <a class="dropdown-item addTaskBtn py-2 text-dark"
                                                   href="/Task.createtask/{{ $task->newID }}">

                                                    <i class="ri-add-circle-line align-bottom me-2 text-success"></i>

                                                    Add Task

                                                </a>

                                            </li>


                                            {{-- EDIT --}}

                                            <li>

                                                <a class="dropdown-item py-2 editPapLinkbtn text-dark editPapLink"
                                                   href="#"

                                                   data-bs-toggle="modal"
                                                   data-bs-target="#editPapModal"

                                                   data-id="{{ $task->newID }}"
                                                   data-googlecalendareventID="{{ $task->googlecalendareventID }}"
                                                   data-papid="{{ $task->papID }}"
                                                   data-pap="{{ $task->pap }}"
                                                   data-location="{{ $task->location }}"
                                                   data-datefrom="{{ $task->fromdate }}"
                                                   data-dateend="{{ $task->todate }}"
                                                   data-description="{{ $task->description }}">

                                                    <i class="ri-pencil-line align-bottom me-2 text-warning"></i>

                                                    Edit PAP

                                                </a>

                                            </li>


                                            {{-- REMOVE --}}

                                            <li class="removePapBtn">

                                                <form action="/Task/pap/{{ $task->newID }}"
                                                      method="POST"
                                                      class="d-inline">

                                                    @csrf

                                                    <button type="submit"
                                                            class="dropdown-item py-2 text-danger"

                                                            onclick="return confirm('Are you sure you want to remove this PAP?')">

                                                        <i class="ri-subtract-line align-bottom me-2"></i>

                                                        Remove PAP

                                                    </button>

                                                </form>

                                            </li>


                                            <li>

                                                <hr class="dropdown-divider my-1">

                                            </li>


                                            {{-- VIEW --}}

                                            <li>

                                                <a class="dropdown-item py-2 text-dark"
                                                   href="/Task/task/{{ $task->fromdate }}/{{ $task->newID }}">

                                                    <i class="ri-eye-line align-bottom me-2 text-primary"></i>

                                                    View Details

                                                </a>

                                            </li>

                                        </ul>

                                    </div>

                                </div>


                                {{-- PAP NAME --}}

                                <h5 class="fw-bold text-dark mb-2 text-truncate"
                                    title="{{ $task->pap }}">

                                    {{ $task->pap }}

                                </h5>


                                {{-- DESCRIPTION --}}

                                @if(!empty($task->description))

                                    <p class="text-muted fs-12 mb-3 text-clamp-2">

                                        {{ $task->description }}

                                    </p>

                                @endif

                            </div>


                            {{-- CARD FOOTER --}}

                            <div class="pt-3 border-top mt-3 d-flex align-items-center justify-content-between text-muted fs-12">

                                <div class="d-flex align-items-center gap-1 text-truncate">

                                    <i class="ri-map-pin-line text-success"></i>

                                    <span class="text-truncate"
                                          style="max-width: 140px;"
                                          title="{{ $task->location }}">

                                        {{ $task->location ?: 'Location TBD' }}

                                    </span>

                                </div>


                                <div class="text-nowrap font-monospace text-dark fw-medium">

                                    <i class="ri-calendar-2-line text-warning me-1"></i>

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

    @endif

</div>



{{-- =========================================================
     WHOLE YEAR TABLE VIEW

     YEAR
       ↓
     MONTH
       ↓
     PAP
       ↓
     ACTIVITIES
     ========================================================= --}}

<div id="tableViewSection" style="display: none;">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        <div class="table-responsive">

            <table class="table mb-0 yearly-pap-table">


                {{-- =================================================
                     YEAR
                     ================================================= --}}

                <thead>

                    <tr class="year-header">

                        <th colspan="6">

                            <div class="d-flex align-items-center gap-3">

                                <div class="year-icon">

                                    <i class="ri-calendar-2-line"></i>

                                </div>

                                <div>

                                    <h5 class="fw-bold mb-0">

                                        {{ $Year }}

                                    </h5>

                                    <small class="text-muted">

                                        Annual Activity Schedule

                                    </small>

                                </div>

                            </div>

                        </th>

                    </tr>


                    {{-- COLUMN HEADERS --}}

                    <tr class="column-header">

                        <th style="width: 25%;" class="ps-4">
                            PAP / Activity
                        </th>

                        <th style="width: 25%;">
                            Description
                        </th>

                        <th style="width: 15%;">
                            Location
                        </th>

                        <th style="width: 12%;">
                            Date From
                        </th>

                        <th style="width: 12%;">
                            Date To
                        </th>

                        <th style="width: 11%;" class="text-end pe-4">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>


                    {{-- GROUP YEARLY DATA BY MONTH --}}

                    @php

                        $groupedYearlyTasks = $yearlyTasks->groupBy(function ($item) {

                            return \Carbon\Carbon::parse($item->fromdate)->format('n');

                        });

                    @endphp


                    {{-- =================================================
                         JANUARY TO DECEMBER
                         ================================================= --}}

                    @for($monthNumber = 1; $monthNumber <= 12; $monthNumber++)


                        @php

                            $monthTasks = $groupedYearlyTasks->get(
                                $monthNumber,
                                collect()
                            );

                        @endphp


                        {{-- =================================================
                             MONTH ROW
                             ================================================= --}}

                        <tr class="month-group-row">

                            <td colspan="6">

                                <div class="d-flex align-items-center gap-2">

                                    <div class="month-small-icon">

                                        <i class="ri-calendar-line"></i>

                                    </div>


                                    <span class="fw-bold">

                                        {{ \Carbon\Carbon::create($Year, $monthNumber, 1)->format('F') }}

                                    </span>


                                    <span class="badge rounded-pill">

                                        {{ $monthTasks->count() }}

                                    </span>

                                </div>

                            </td>

                        </tr>


                        {{-- =================================================
                             EMPTY MONTH
                             ================================================= --}}

                        @if($monthTasks->isEmpty())

                            <tr class="empty-month-row">

                                <td colspan="6" class="ps-5">

                                    <span class="text-muted fst-italic">

                                        No activities scheduled for this month.

                                    </span>

                                </td>

                            </tr>


                        @else


                            {{-- =================================================
                                 GROUP BY PAP
                                 ================================================= --}}

                            @foreach($monthTasks->groupBy('papID') as $papID => $papTasks)


                                {{-- PAP ROW --}}

                               


                                {{-- =================================================
                                     ACTIVITIES UNDER PAP
                                     ================================================= --}}

                                @foreach($papTasks as $index => $task)

                                    <tr class="activity-row">


                                        {{-- PAP / ACTIVITY --}}

                                        <td class="ps-5">

                                            <div class="d-flex align-items-center gap-2">

                                                <span class="activity-number">

                                                    {{ $index + 1 }}

                                                </span>


                                                <span class="text-dark fw-medium">

                                                    {{ $task->pap }}

                                                </span>

                                            </div>

                                        </td>


                                        {{-- DESCRIPTION --}}

                                        <td>

                                            @if(!empty($task->description))

                                                <span class="text-muted">

                                                    {{ $task->description }}

                                                </span>

                                            @else

                                                <span class="text-muted fst-italic">

                                                    No description

                                                </span>

                                            @endif

                                        </td>


                                        {{-- LOCATION --}}

                                        <td>

                                            <div class="d-flex align-items-center gap-1">

                                                <i class="ri-map-pin-line text-success"></i>

                                                <span>

                                                    {{ $task->location ?: 'Location TBD' }}

                                                </span>

                                            </div>

                                        </td>


                                        {{-- DATE FROM --}}

                                        <td>

                                            <span class="font-monospace small">

                                                {{ \Carbon\Carbon::parse($task->fromdate)->format('M d, Y') }}

                                            </span>

                                        </td>


                                        {{-- DATE TO --}}

                                        <td>

                                            <span class="font-monospace small">

                                                {{ \Carbon\Carbon::parse($task->todate)->format('M d, Y') }}

                                            </span>

                                        </td>


                                        {{-- ACTIONS --}}

                                        <td class="text-end pe-4">

                                            <div class="d-inline-flex gap-1">


                                                {{-- ADD TASK --}}

                                                <a href="/Task.createtask/{{ $task->newID }}"
                                                   class="btn  text-success addTaskBtn"
                                                   title="Add Task">

                                                    <i class="ri-add-circle-line"></i>

                                                </a>


                                                {{-- EDIT --}}

                                                <a 
                                                   class="btn text-warning editPapLink"

                                                   data-bs-toggle="modal"
                                                   data-bs-target="#editPapModal"

                                                   data-id="{{ $task->newID }}"
                                                   data-googlecalendareventID="{{ $task->googlecalendareventID }}"
                                                   data-papid="{{ $task->papID }}"
                                                   data-pap="{{ $task->pap }}"
                                                   data-location="{{ $task->location }}"
                                                   data-datefrom="{{ $task->fromdate }}"
                                                   data-dateend="{{ $task->todate }}"
                                                   data-description="{{ $task->description }}"

                                                   title="Edit PAP">

                                                    <i class="ri-pencil-line"></i>

                                                </a>


                                                {{-- REMOVE --}}

                                                <form action="/Task/pap/{{ $task->newID }}"
                                                      method="POST"
                                                      class="d-inline removePapBtn">

                                                    @csrf

                                                    <button type="submit"
                                                            class="btn text-danger"

                                                            title="Remove PAP"

                                                            onclick="return confirm('Are you sure you want to remove this PAP?')">

                                                        <i class="ri-delete-bin-line"></i>

                                                    </button>

                                                </form>


                                                {{-- VIEW DETAILS --}}

                                                <a href="/Task/task/{{ $task->fromdate }}/{{ $task->newID }}"
                                                   class="btn text-primary"
                                                   title="View Details">

                                                    <i class="ri-eye-line"></i>

                                                </a>

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            @endforeach

                        @endif

                    @endfor

                </tbody>

            </table>

        </div>

    </div>

</div>



{{-- =========================================================
     ADD ACTIVITY MODAL
     ========================================================= --}}

<div class="modal fade"
     id="addPapModal"
     tabindex="-1"
     aria-labelledby="addPapModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header border-0 pb-0">

                <h5 class="modal-title fw-bold text-dark"
                    id="addPapModalLabel">

                    New Activity Milestone

                </h5>

                <button type="button"
                        class="btn-close shadow-none"
                        data-bs-dismiss="modal">

                </button>

            </div>


            <form method="POST"
                  action="{{ route('savePAP') }}">

                @csrf

                <div class="modal-body pt-3">


                    {{-- PAP --}}

                    <div class="mb-3">

                        <label for="papName"
                               class="form-label fw-semibold fs-13">

                            PAP Name
                            <span class="text-danger">*</span>

                        </label>


                        <select class="form-select rounded-3 py-2"
                                id="papName"
                                name="pap"
                                required>

                            <option value=""
                                    disabled
                                    selected>

                                -- Select PAP --

                            </option>


                            @foreach($papOptions as $option)

                                <option value="{{ $option->id }}">

                                    {{ $option->pap }}

                                </option>

                            @endforeach


                            <option value="addpap"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addPapModals"
                                    data-bs-dismiss="modal">

                                -- Add New PAP --

                            </option>

                        </select>

                    </div>


                    {{-- DESCRIPTION --}}

                    <div class="mb-3">

                        <label for="description"
                               class="form-label fw-semibold fs-13">

                            Description
                            <span class="text-muted fw-normal">
                                (Optional)
                            </span>

                        </label>


                        <input type="text"
                               class="form-control rounded-3 py-2"
                               id="description"
                               name="description"
                               placeholder="Brief activity details">

                    </div>


                    {{-- DATE --}}

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

                                    <input type="date"
                                           class="form-control rounded-end py-2"
                                           id="indicativeDate"
                                           name="datefrom"
                                           required>

                                </div>

                            </div>


                            <div class="col-6">

                                <div class="input-group">

                                    <span class="input-group-text bg-light border-end-0 fs-12">
                                        To
                                    </span>

                                    <input type="date"
                                           class="form-control rounded-end py-2"
                                           id="indicativeDateEnd"
                                           name="dateend"
                                           required>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- LOCATION --}}

                    <div class="mb-3">

                        <label for="location"
                               class="form-label fw-semibold fs-13">

                            Location

                        </label>


                        <input type="text"
                               class="form-control rounded-3 py-2"
                               id="location"
                               name="location"
                               placeholder="Venue or location">

                    </div>

                </div>


                <div class="modal-footer border-0 pt-0">

                    <button type="button"
                            class="btn btn-light rounded-pill px-4"
                            data-bs-dismiss="modal">

                        Close

                    </button>


                    <button type="submit"
                            class="btn btn-dark-green rounded-pill px-4">

                        Save Activity

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



{{-- =========================================================
     ADD NEW PAP MODAL
     ========================================================= --}}

<form action="{{ route('createPAP') }}"
      method="POST">

    @csrf

    <div class="modal fade"
         id="addPapModals"
         tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header border-0 pb-0">

                    <h5 class="modal-title fw-bold text-dark">

                        Add New PAP

                    </h5>


                    <button type="button"
                            class="btn-close shadow-none"
                            data-bs-dismiss="modal">

                    </button>

                </div>


                <div class="modal-body py-3">

                    <label class="form-label fw-semibold fs-13">

                        PAP Title
                        <span class="text-danger">*</span>

                    </label>


                    <input type="text"
                           name="pap"
                           class="form-control rounded-3 py-2"
                           placeholder="Enter PAP title"
                           required>

                </div>


                <div class="modal-footer border-0 pt-0">

                    <button type="button"
                            class="btn btn-light rounded-pill px-4"
                            data-bs-dismiss="modal">

                        Cancel

                    </button>


                    <button class="btn btn-dark-green rounded-pill px-4"
                            name="action"
                            value="pap">

                        Save PAP

                    </button>

                </div>

            </div>

        </div>

    </div>

</form>



{{-- =========================================================
     EDIT ACTIVITY MODAL
     ========================================================= --}}

<div class="modal fade"
     id="editPapModal"
     tabindex="-1"
     aria-labelledby="editPapModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header border-0 pb-0">

                <h5 class="modal-title fw-bold text-dark"
                    id="editPapModalLabel">

                    Edit Activity Milestone

                </h5>


                <button type="button"
                        class="btn-close shadow-none"
                        data-bs-dismiss="modal">

                </button>

            </div>


            <form method="POST"
                  action="{{ route('savePAP') }}">

                @csrf

                <div class="modal-body pt-3">


                    <input type="hidden"
                           id="editpapid"
                           name="editpapid">


                    <input type="hidden"
                           id="googlecalendareventID"
                           name="googlecalendareventID">


                    {{-- PAP NAME --}}

                    <div class="mb-3">

                        <label for="editpapName"
                               class="form-label fw-semibold fs-13">

                            PAP Name

                        </label>


                        <input type="text"
                               class="form-control rounded-3 py-2 bg-light text-muted"
                               id="editpapName"
                               name="editpapName"
                               readonly>

                    </div>


                    {{-- DESCRIPTION --}}

                    <div class="mb-3">

                        <label for="editdescription"
                               class="form-label fw-semibold fs-13">

                            Description

                        </label>


                        <input type="text"
                               class="form-control rounded-3 py-2"
                               id="editdescription"
                               name="editdescription"
                               placeholder="Description details">

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

                                    <input type="date"
                                           class="form-control rounded-end py-2"
                                           id="editindicativeDate"
                                           name="editdatefrom">

                                </div>

                            </div>


                            <div class="col-6">

                                <div class="input-group">

                                    <span class="input-group-text bg-light border-end-0 fs-12">
                                        To
                                    </span>

                                    <input type="date"
                                           class="form-control rounded-end py-2"
                                           id="editindicativeDateEnd"
                                           name="editdateend">

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- LOCATION --}}

                    <div class="mb-3">

                        <label for="editlocation"
                               class="form-label fw-semibold fs-13">

                            Location

                        </label>


                        <input type="text"
                               class="form-control rounded-3 py-2"
                               id="editlocation"
                               name="editlocation"
                               placeholder="Venue or location">

                    </div>

                </div>


                <div class="modal-footer border-0 pt-0">

                    <button type="button"
                            class="btn btn-light rounded-pill px-4"
                            data-bs-dismiss="modal">

                        Close

                    </button>


                    <button type="submit"
                            class="btn btn-dark-green rounded-pill px-4">

                        Save Changes

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


@endsection



{{-- =========================================================
     JAVASCRIPT
     ========================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {


    /* =========================================================
       VIEW TOGGLE
       ========================================================= */

    const cardViewBtn =
        document.getElementById('cardViewBtn');

    const tableViewBtn =
        document.getElementById('tableViewBtn');

    const cardViewSection =
        document.getElementById('cardViewSection');

    const tableViewSection =
        document.getElementById('tableViewSection');
const monthNavContainer = document.getElementById('monthNavContainer');

    if (cardViewBtn && tableViewBtn) {


        /* CARD VIEW */

        cardViewBtn.addEventListener('click', function () {

            cardViewSection.style.display = 'block';

            tableViewSection.style.display = 'none';
            monthNavContainer.style.display = 'block';


            cardViewBtn.classList.add(
                'btn-dark-green',
                'active'
            );

            cardViewBtn.classList.remove(
                'btn-light'
            );


            tableViewBtn.classList.remove(
                'btn-dark-green',
                'active'
            );

            tableViewBtn.classList.add(
                'btn-light'
            );

        });


        /* TABLE VIEW */

        tableViewBtn.addEventListener('click', function () {

            cardViewSection.style.display = 'none';
            monthNavContainer.style.display = 'none';


            tableViewSection.style.display = 'block';


            tableViewBtn.classList.add(
                'btn-dark-green',
                'active'
            );

            tableViewBtn.classList.remove(
                'btn-light'
            );


            cardViewBtn.classList.remove(
                'btn-dark-green',
                'active'
            );

            cardViewBtn.classList.add(
                'btn-light'
            );

        });

    }



    /* =========================================================
       USER TYPE PERMISSIONS
       ========================================================= */

    const userType =
        @json(Auth::user()->usertype);

    const addbtn =
        document.getElementById('assignTaskBtn');


    if (userType === '2') {


        document.querySelectorAll('.assignTaskBtn')
            .forEach(el => {

                el.style.display = 'none';

            });


        document.querySelectorAll('.addTaskBtn')
            .forEach(el => {

                el.style.display = 'none';

            });


        document.querySelectorAll('.editPapLink')
            .forEach(el => {

                el.style.display = 'none';

            });


        document.querySelectorAll('.deletePapBtn')
            .forEach(el => {

                el.style.display = 'none';

            });


        document.querySelectorAll('.dropdownDivider')
            .forEach(el => {

                el.style.display = 'none';

            });


        document.querySelectorAll('.removePapBtn')
            .forEach(el => {

                el.style.display = 'none';

            });


        if (addbtn) {

            addbtn.style.display = 'none';

        }

    }



    /* =========================================================
       EDIT PAP MODAL
       ========================================================= */

    document.querySelectorAll('.editPapLink')
        .forEach(link => {

            link.addEventListener('click', function () {


                const papId =
                    this.getAttribute('data-id');


                const papName =
                    this.getAttribute('data-pap');


                const location =
                    this.getAttribute('data-location');


                const dateFrom =
                    this.getAttribute('data-datefrom');


                const dateEnd =
                    this.getAttribute('data-dateend');


                const description =
                    this.getAttribute('data-description');


                const googlecalendareventID =
                    this.getAttribute(
                        'data-googlecalendareventID'
                    );


                document.getElementById(
                    'editpapid'
                ).value = papId;


                document.getElementById(
                    'editpapName'
                ).value = papName;


                document.getElementById(
                    'editlocation'
                ).value = location;


                document.getElementById(
                    'editindicativeDate'
                ).value = dateFrom;


                document.getElementById(
                    'editindicativeDateEnd'
                ).value = dateEnd;


                document.getElementById(
                    'editdescription'
                ).value = description;


                document.getElementById(
                    'googlecalendareventID'
                ).value =
                    googlecalendareventID;

            });

        });



    /* =========================================================
       ADD NEW PAP
       ========================================================= */

    const papNameSelect =
        document.getElementById('papName');


    if (papNameSelect) {

        papNameSelect.addEventListener(
            'change',
            function () {

                if (this.value === 'addpap') {

                    const modal =
                        new bootstrap.Modal(
                            document.getElementById(
                                'addPapModals'
                            )
                        );

                    modal.show();

                    this.value = '';

                }

            }
        );

    }

});

</script>