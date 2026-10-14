@extends('components.layout')

@section('content')

@php
$currentDate = \Carbon\Carbon::create((int) $Year, (int) $Month, 1)->startOfDay();

$previousMonth = $currentDate->copy()->subMonth();
$nextMonth = $currentDate->copy()->addMonth();

$startOfMonth = $currentDate->copy()->startOfMonth()->startOfDay();
$endOfMonth = $currentDate->copy()->endOfMonth()->endOfDay();

$calendarStart = $startOfMonth
->copy()
->startOfWeek(\Carbon\Carbon::SUNDAY)
->startOfDay();

$calendarEnd = $endOfMonth
->copy()
->endOfWeek(\Carbon\Carbon::SATURDAY)
->endOfDay();
@endphp

<style>
    :root {
        --green-dark: #0a3d2c;
        --green-main: #0d5139;
        --green-soft: #edf6f1;
        --gold: #d4af37;
        --gold-soft: #fff9e8;
        --border: #e7ece9;
        --text-dark: #17212b;
        --text-muted: #667085;
        --page-bg: #f5f8f6;
    }

    body {
        background-color: var(--page-bg);
    }

    .schedule-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .schedule-title {
        margin: 0;
        color: var(--text-dark);
        font-size: 24px;
        font-weight: 700;
    }

    .schedule-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .view-toggle {
        display: flex;
        padding: 3px;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 50px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .04);
    }

    .view-toggle button {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border: none;
        border-radius: 50px;
        background: transparent;
        color: var(--text-muted);
        font-size: 12px;
        font-weight: 500;
        transition: .2s ease;
    }

    .view-toggle button.active {
        background: var(--green-dark);
        color: #fff;
    }

    .btn-add-activity {
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 10px 20px;
        border: none;
        border-radius: 50px;
        background: var(--green-dark);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(10, 61, 44, .15);
        transition: .2s ease;
    }

    .btn-add-activity:hover {
        background: var(--green-main);
        color: #fff;
    }

    .month-navigation-container {
        display: flex;
        justify-content: center;
        margin-bottom: 25px;
    }

    .month-navigation {
        display: flex;
        align-items: center;
        gap: 24px;
        padding: 7px 14px;
        background: #fff;
        border-radius: 50px;
        box-shadow: 0 5px 18px rgba(0, 0, 0, .05);
    }

    .month-button {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e7d89f;
        border-radius: 50%;
        background: var(--gold-soft);
        color: var(--green-dark);
        font-size: 18px;
        text-decoration: none;
        transition: .2s ease;
    }

    .month-button:hover {
        background: var(--gold);
        color: #fff;
    }

    .month-title {
        min-width: 155px;
        color: #111827;
        font-size: 16px;
        font-weight: 700;
        text-align: center;
    }

    /* CARDS */

    .pap-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 24px;
    }

    .pap-tile {
        position: relative;
        min-height: 275px;
        padding: 25px;
        background: #fff;
        border: 1px solid var(--border);
        border-left: 9px solid var(--green-dark);
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, .06);
        overflow: hidden;
        transition: .25s ease;
    }

    .pap-tile:hover {
        transform: translateY(-3px);
        box-shadow: 0 14px 30px rgba(0, 0, 0, .09);
    }

    .pap-tile-menu {
        position: absolute;
        top: 18px;
        right: 18px;
    }

    .pap-tile-menu button {
        padding: 5px;
        border: none;
        background: transparent;
        color: var(--green-dark);
        font-size: 19px;
    }

    .pap-tile-content {
        padding-top: 38px;
    }

    .pap-title {
        display: block;
        margin-bottom: 9px;
        color: #111827;
        font-size: 18px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .pap-title:hover {
        color: var(--green-main);
    }

    .pap-description {
        min-height: 65px;
        margin-bottom: 16px;
        color: #4b5563;
        font-size: 13px;
        line-height: 1.7;
    }

    .pap-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-top: 15px;
        padding-top: 17px;
        border-top: 1px solid var(--border);
    }

    .pap-location {
        display: flex;
        align-items: center;
        min-width: 0;
        color: var(--text-muted);
        font-size: 11px;
        font-weight: 500;
    }

    .pap-location i {
        margin-right: 5px;
        color: #00a66c;
        font-size: 14px;
    }

    .pap-location span {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .pap-date {
        display: flex;
        align-items: center;
        flex-shrink: 0;
        color: #344054;
        font-size: 11px;
        font-weight: 500;
    }

    .pap-date i {
        margin-right: 6px;
        color: #f0a500;
        font-size: 14px;
    }

    .empty-state {
        padding: 80px 20px;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 15px;
        color: #98a2b3;
        text-align: center;
    }

    .empty-state i {
        display: block;
        margin-bottom: 10px;
        font-size: 40px;
    }

    /* CALENDAR */

    .calendar-wrapper {
        width: 100%;
        overflow-x: auto;
        padding-bottom: 5px;
    }

    .activity-calendar {
        min-width: 950px;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, .05);
    }

    .calendar-weekdays {
        display: grid;
        grid-template-columns: repeat(7, minmax(0, 1fr));
        background: var(--green-dark);
        color: #fff;
    }

    .calendar-weekday {
        padding: 14px 10px;
        border-right: 1px solid rgba(255, 255, 255, .1);
        text-align: center;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .calendar-weekday:last-child {
        border-right: none;
    }

    .calendar-week {
        position: relative;
        min-height: calc(80px + (var(--event-rows) * 34px));
        border-bottom: 1px solid var(--border);
    }

    .calendar-week:last-child {
        border-bottom: none;
    }

    .calendar-days-row {
        position: absolute;
        inset: 0;
        display: grid;
        grid-template-columns: repeat(7, minmax(0, 1fr));
    }

    .calendar-day {
        min-height: 100%;
        padding: 9px;
        background: #fff;
        border-right: 1px solid var(--border);
    }

    .calendar-day:last-child {
        border-right: none;
    }

    .calendar-day.other-month {
        background: #f7f9f8;
    }

    .calendar-day-number {
        width: 29px;
        height: 29px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #344054;
        font-size: 12px;
        font-weight: 700;
    }

    .calendar-day.other-month .calendar-day-number {
        color: #b5bdb9;
    }

    .calendar-day.today {
        background: #fbfdfc;
    }

    .calendar-day.today .calendar-day-number {
        background: var(--green-dark);
        color: #fff;
    }

    .calendar-linear-events {
        position: relative;
        z-index: 10;
        display: grid;
        grid-template-columns: repeat(7, minmax(0, 1fr));
        grid-auto-rows: 28px;
        row-gap: 5px;
        padding-top: 43px;
        pointer-events: none;
    }

    .linear-calendar-event {
        display: flex;
        align-items: center;
        height: 28px;
        margin: 0 3px;
        padding: 0 9px;
        background: var(--green-dark);
        border-radius: 5px;
        color: #fff;
        text-decoration: none;
        overflow: hidden;
        pointer-events: auto;
        transition: .2s ease;
    }

    .linear-calendar-event:hover {
        background: var(--green-main);
        color: #fff;
        box-shadow: 0 3px 8px rgba(0, 0, 0, .14);
    }

    .linear-event-content {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 0;
    }

    .linear-event-title {
        min-width: 0;
        overflow: hidden;
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .linear-event-location {
        margin-left: auto;
        flex-shrink: 0;
        color: rgba(255, 255, 255, .78);
        font-size: 9px;
        white-space: nowrap;
    }

    .linear-event-location i {
        margin-right: 2px;
    }

    .linear-calendar-event.continues-before {
        margin-left: 0;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    .linear-calendar-event.continues-before::before {
        content: "‹";
        margin-right: 5px;
        font-size: 14px;
    }

    .linear-calendar-event.continues-after {
        margin-right: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .linear-calendar-event.continues-after::after {
        content: "›";
        margin-left: auto;
        padding-left: 5px;
        font-size: 14px;
    }

    @media (max-width: 1199px) {
        .pap-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767px) {
        .schedule-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .schedule-actions {
            width: 100%;
            justify-content: space-between;
        }

        .pap-grid {
            grid-template-columns: 1fr;
        }

        .pap-footer {
            flex-direction: column;
            align-items: flex-start;
        }
    }

</style>

<div class="schedule-header">
    <h2 class="schedule-title">Activity Schedule</h2>

    <div class="schedule-actions">
        <div class="view-toggle">
            <button type="button" id="cardsViewBtn" class="active">
                <i class="ri-layout-grid-line"></i>
                Cards
            </button>

            <button type="button" id="calendarViewBtn">
                <i class="ri-calendar-line"></i>
                Calendar
            </button>
        </div>

        <button type="button" class="btn-add-activity" data-bs-toggle="modal" data-bs-target="#addPapModal">
            <i class="ri-add-line"></i>
            Add Activity
        </button>
    </div>
</div>

<div class="month-navigation-container">
    <div class="month-navigation">
        <a href="/Task/pap/{{ $previousMonth->year }}/{{ $previousMonth->month }}" class="month-button">
            <i class="ri-arrow-left-s-line"></i>
        </a>

        <div class="month-title">
            {{ $currentDate->format('F Y') }}
        </div>

        <a href="/Task/pap/{{ $nextMonth->year }}/{{ $nextMonth->month }}" class="month-button">
            <i class="ri-arrow-right-s-line"></i>
        </a>
    </div>
</div>

{{-- CARD VIEW --}}

<div id="cardsView">

    @if(count($newtask) > 0)

    <div class="pap-grid">

        @foreach($newtask as $activity)

        @php
        $fromDate = \Carbon\Carbon::parse($activity->fromdate);

        $toDate = !empty($activity->todate)
        ? \Carbon\Carbon::parse($activity->todate)
        : $fromDate->copy();
        @endphp

        <div class="pap-tile">

            <div class="dropdown pap-tile-menu">
                <button type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ri-more-2-fill"></i>
                </button>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="/Task/task/{{ $activity->fromdate }}/{{ $activity->newID }}">
                            <i class="ri-eye-line me-2"></i>
                            View Activity
                        </a>
                    </li>
                </ul>
            </div>

            <div class="pap-tile-content">

                <a href="/Task/task/{{ $activity->fromdate }}/{{ $activity->newID }}" class="pap-title" title="{{ $activity->pap }}">
                    {{ $activity->pap }}
                </a>

                <div class="pap-description">
                    {{ $activity->description ?: 'No description provided.' }}
                </div>

                <div class="pap-footer">

                    <div class="pap-location">
                        <i class="ri-map-pin-line"></i>

                        <span>
                            {{ strtoupper($activity->location ?: 'LOCATION TBD') }}
                        </span>
                    </div>

                    <div class="pap-date">
                        <i class="ri-calendar-2-line"></i>

                        @if($fromDate->isSameDay($toDate))

                        {{ $fromDate->format('M d, Y') }}

                        @elseif($fromDate->isSameMonth($toDate))

                        {{ $fromDate->format('M d') }}
                        -
                        {{ $toDate->format('M d, Y') }}

                        @else

                        {{ $fromDate->format('M d, Y') }}
                        -
                        {{ $toDate->format('M d, Y') }}

                        @endif
                    </div>

                </div>
            </div>
        </div>

        @endforeach

    </div>

    @else

    <div class="empty-state">
        <i class="ri-calendar-line"></i>

        <h6 class="fw-bold text-dark">
            No Activities
        </h6>

        <p class="mb-0">
            No activities scheduled for {{ $currentDate->format('F Y') }}.
        </p>
    </div>

    @endif

</div>


{{-- CALENDAR VIEW --}}

<div id="calendarView" class="d-none">

    <div class="calendar-wrapper">

        <div class="activity-calendar">

            <div class="calendar-weekdays">
                <div class="calendar-weekday">Sunday</div>
                <div class="calendar-weekday">Monday</div>
                <div class="calendar-weekday">Tuesday</div>
                <div class="calendar-weekday">Wednesday</div>
                <div class="calendar-weekday">Thursday</div>
                <div class="calendar-weekday">Friday</div>
                <div class="calendar-weekday">Saturday</div>
            </div>

            @php
            $weekStart = $calendarStart->copy();
            @endphp

            @while($weekStart->lte($calendarEnd))

            @php
            $weekEnd = $weekStart
            ->copy()
            ->addDays(6)
            ->endOfDay();

            $weekActivities = $task
            ->filter(function ($activity) use ($weekStart, $weekEnd) {

            // Do not display Consultancy PAPs in calendar
            if (
            isset($activity->pap) &&
            str_contains(
                strtolower($activity->pap),
                'consultancy'
            )
            ) {
            return false;
            }

            $activityStart = \Carbon\Carbon::parse(
            $activity->fromdate
            )->startOfDay();

            $activityEnd = !empty($activity->todate)
            ? \Carbon\Carbon::parse(
            $activity->todate
            )->endOfDay()
            : $activityStart
            ->copy()
            ->endOfDay();

            return
            $activityStart->lte($weekEnd)
            &&
            $activityEnd->gte($weekStart);
            })
            ->values();

            $activityRows = [];
            $occupiedRows = [];

            foreach ($weekActivities as $activity) {

            $activityStart = \Carbon\Carbon::parse(
            $activity->fromdate
            )->startOfDay();

            $activityEnd = !empty($activity->todate)
            ? \Carbon\Carbon::parse(
            $activity->todate
            )->endOfDay()
            : $activityStart
            ->copy()
            ->endOfDay();

            $segmentStart = $activityStart->lt($weekStart)
            ? $weekStart->copy()->startOfDay()
            : $activityStart->copy()->startOfDay();

            $segmentEnd = $activityEnd->gt($weekEnd)
            ? $weekEnd->copy()->startOfDay()
            : $activityEnd->copy()->startOfDay();

            /*
            * Carbon dayOfWeek:
            *
            * Sunday = 0
            * Monday = 1
            * Tuesday = 2
            * Wednesday = 3
            * Thursday = 4
            * Friday = 5
            * Saturday = 6
            *
            * CSS calendar columns:
            *
            * Sunday = 1
            * Monday = 2
            * Tuesday = 3
            * Wednesday = 4
            * Thursday = 5
            * Friday = 6
            * Saturday = 7
            */

            $startColumn = ((int) $segmentStart->dayOfWeek) + 1;

            /*
            * CSS grid ending line is exclusive.
            *
            * Monday only:
            * 2 / 3
            *
            * Monday-Friday:
            * 2 / 7
            */

            $endColumn = ((int) $segmentEnd->dayOfWeek) + 2;

            if ($endColumn > 8) {
            $endColumn = 8;
            }

            $row = 1;

            while (true) {

            $hasConflict = false;

            if (isset($occupiedRows[$row])) {

            foreach ($occupiedRows[$row] as $occupied) {

            if (
            $startColumn < $occupied['end'] && $endColumn> $occupied['start']
                ) {
                $hasConflict = true;
                break;
                }

                }

                }

                if (!$hasConflict) {
                break;
                }

                $row++;
                }

                if (!isset($occupiedRows[$row])) {
                $occupiedRows[$row] = [];
                }

                $occupiedRows[$row][] = [
                'start' => $startColumn,
                'end' => $endColumn,
                ];

                $activityRows[] = [
                'activity' => $activity,
                'startColumn' => $startColumn,
                'endColumn' => $endColumn,
                'row' => $row,
                'continuesBefore' => $activityStart->lt($weekStart),
                'continuesAfter' => $activityEnd->gt($weekEnd),
                ];
                }

                $maxRows = !empty($occupiedRows)
                ? max(array_keys($occupiedRows))
                : 0;
                @endphp


                <div class="calendar-week" style="--event-rows: {{ $maxRows }};">

                    <div class="calendar-days-row">

                        @for($i = 0; $i < 7; $i++) @php $day=$weekStart ->copy()
                            ->addDays($i);
                            @endphp

                            <div class="calendar-day
                                    {{ !$day->isSameMonth($currentDate) ? 'other-month' : '' }}
                                    {{ $day->isToday() ? 'today' : '' }}">
                                <div class="calendar-day-number">
                                    {{ $day->day }}
                                </div>
                            </div>

                            @endfor

                    </div>


                    <div class="calendar-linear-events">

                        @foreach($activityRows as $eventData)

                        @php
                        $activity = $eventData['activity'];

                        $displayStart = \Carbon\Carbon::parse(
                        $activity->fromdate
                        );

                        $displayEnd = !empty($activity->todate)
                        ? \Carbon\Carbon::parse(
                        $activity->todate
                        )
                        : $displayStart->copy();
                        @endphp

                        <a href="/Task/task/{{ $activity->fromdate }}/{{ $activity->id }}" class="linear-calendar-event
                                    {{ $eventData['continuesBefore'] ? 'continues-before' : '' }}
                                    {{ $eventData['continuesAfter'] ? 'continues-after' : '' }}" style="
                                    grid-column:
                                        {{ $eventData['startColumn'] }}
                                        /
                                        {{ $eventData['endColumn'] }};

                                    grid-row:
                                        {{ $eventData['row'] }};
                                " title="{{ $activity->pap }} | {{ $displayStart->format('M d, Y') }} - {{ $displayEnd->format('M d, Y') }}">

                            <div class="linear-event-content">

                                <span class="linear-event-title">
                                    {{ $activity->pap }}
                                </span>

                                @if(!empty($activity->location))

                                <span class="linear-event-location">
                                    <i class="ri-map-pin-line"></i>
                                    {{ $activity->location }}
                                </span>

                                @endif

                            </div>

                        </a>

                        @endforeach

                    </div>

                </div>


                @php
                $weekStart = $weekStart
                ->copy()
                ->addDays(7)
                ->startOfDay();
                @endphp

                @endwhile

        </div>

    </div>

</div>


{{-- ADD ACTIVITY MODAL --}}

<div class="modal fade" id="addPapModal" tabindex="-1" aria-labelledby="addPapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content border-0 rounded-4 shadow">

            <div class="modal-header border-0 pb-0">

                <div>
                    <h5 class="modal-title fw-bold" id="addPapModalLabel">
                        Add Activity
                    </h5>

                    <p class="text-muted fs-12 mb-0">
                        Create a new activity schedule.
                    </p>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>

            <div class="modal-body p-4">

                <form method="POST" action="{{ route('store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="papID" class="form-label fw-semibold">
                            Program / Activity / Project
                            <span class="text-danger">*</span>
                        </label>

                        <select name="papID" id="papID" class="form-select" required>
                            <option value="">
                                -- Select PAP --
                            </option>

                            @foreach($papOptions as $papOption)

                            <option value="{{ $papOption->id }}">
                                {{ $papOption->pap }}
                            </option>

                            @endforeach

                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">
                            Description
                        </label>

                        <textarea name="description" id="description" class="form-control" rows="3" placeholder="Enter activity description"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label fw-semibold">
                            Location
                        </label>

                        <input type="text" name="location" id="location" class="form-control" placeholder="Enter activity location">
                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label for="fromdate" class="form-label fw-semibold">
                                Start Date
                                <span class="text-danger">*</span>
                            </label>

                            <input type="date" name="fromdate" id="fromdate" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="todate" class="form-label fw-semibold">
                                End Date
                            </label>

                            <input type="date" name="todate" id="todate" class="form-control">
                        </div>

                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-3">

                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn rounded-pill px-4 text-white" style="background: var(--green-dark);">
                            <i class="ri-save-line me-1"></i>
                            Save Activity
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        const cardsViewBtn = document.getElementById('cardsViewBtn');
        const calendarViewBtn = document.getElementById('calendarViewBtn');

        const cardsView = document.getElementById('cardsView');
        const calendarView = document.getElementById('calendarView');

        cardsViewBtn.addEventListener('click', function() {

            cardsView.classList.remove('d-none');
            calendarView.classList.add('d-none');

            cardsViewBtn.classList.add('active');
            calendarViewBtn.classList.remove('active');

            localStorage.setItem('papView', 'cards');

        });

        calendarViewBtn.addEventListener('click', function() {

            calendarView.classList.remove('d-none');
            cardsView.classList.add('d-none');

            calendarViewBtn.classList.add('active');
            cardsViewBtn.classList.remove('active');

            localStorage.setItem('papView', 'calendar');

        });

        const savedView = localStorage.getItem('papView');

        if (savedView === 'calendar') {
            calendarViewBtn.click();
        }

    });

</script>

@endsection
