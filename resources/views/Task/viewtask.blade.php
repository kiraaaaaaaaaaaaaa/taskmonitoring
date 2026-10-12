@extends('components.layout')

@section('content')

<style>

    /* ============================================================
       THEME
    ============================================================ */

    :root {
        --bs-dark-green: #0a3622;
        --bs-medium-green: #114c31;
        --bs-accent-green: #196f47;

        --bs-golden-yellow: #d4af37;
        --bs-golden-yellow-light: #fef9e7;
        --bs-golden-yellow-border: #f3e5ab;

        --review-success: #0d6b4b;
        --review-success-light: #e7f5ed;

        --review-received: #a47800;
        --review-received-light: #fff5d9;

        --review-pending: #747d78;
        --review-pending-light: #f0f2f1;

        --review-muted: #77817b;
    }


    body {
        background-color: #f7f9fa;
    }


    /* ============================================================
       CARD
    ============================================================ */

    .card {
        border: none;

        border-radius: 1rem;

        box-shadow:
            0 0.5rem 1.5rem
            rgba(10, 54, 34, 0.05);

        background: #ffffff;
    }


    /* ============================================================
       FORM
    ============================================================ */

    .form-label {
        font-weight: 600;

        color: var(--bs-dark-green);

        font-size: 0.85rem;

        text-transform: uppercase;

        letter-spacing: 0.5px;
    }


    .form-control {
        border-radius: 0.5rem;

        border: 1px solid #ced4da;

        padding: 0.65rem 0.9rem;

        font-size: 0.925rem;

        background-color: #f8f9fa;

        color: #495057;
    }


    .form-control:focus {
        border-color: var(--bs-accent-green);

        box-shadow:
            0 0 0 0.25rem
            rgba(25, 111, 71, 0.15);

        background-color: #ffffff;
    }


    /* ============================================================
       OBLIGATION CARD
    ============================================================ */

    .obligation-header {
        background-color:
            var(--bs-dark-green) !important;

        color: #ffffff;

        border-top-left-radius:
            1rem !important;

        border-top-right-radius:
            1rem !important;

        font-weight: 600;

        letter-spacing: 0.5px;
    }


    /* ============================================================
       BUTTONS
    ============================================================ */

    .btn-dark-green {
        background-color:
            var(--bs-dark-green);

        color: #ffffff;

        border: none;

        transition: all 0.2s ease;
    }


    .btn-dark-green:hover {
        background-color:
            var(--bs-accent-green);

        color: #ffffff;
    }


    .btn-outline-dark-green {
        border-color:
            var(--bs-dark-green);

        color:
            var(--bs-dark-green);
    }


    .btn-outline-dark-green:hover {
        background-color:
            var(--bs-dark-green);

        color: #ffffff;
    }


    .btn-golden-yellow {
        background-color:
            var(--bs-golden-yellow);

        color:
            var(--bs-dark-green);

        font-weight: 600;

        border: none;
    }


    .btn-golden-yellow:hover {
        background-color: #c59f2c;

        color:
            var(--bs-dark-green);
    }



    /* ============================================================
       REVIEW PROGRESS
    ============================================================ */

    .review-progress-wrapper {
        padding-top: 3px;
    }


    .review-progress-heading {
        display: flex;

        align-items: center;

        gap: 9px;

        margin-bottom: 25px;

        color:
            var(--bs-dark-green);

        font-size: 1.25rem;

        font-weight: 700;
    }


    .review-progress-heading i {
        color:
            var(--bs-accent-green);

        font-size: 22px;
    }



    /* ============================================================
       REVIEW TIMELINE
    ============================================================ */

    .review-timeline {
        padding:
            0 5px;
    }


    .review-timeline-item {
        position: relative;

        display: grid;

        grid-template-columns:
            45px minmax(0, 1fr);

        gap: 15px;

        min-height: 90px;
    }


    .review-timeline-item:last-child {
        min-height: auto;
    }



    /* ============================================================
       TIMELINE MARKER
    ============================================================ */

    .review-marker {
        position: relative;

        display: flex;

        justify-content: center;
    }


    .review-timeline-item:not(:last-child)
    .review-marker::after {

        content: "";

        position: absolute;

        top: 34px;

        bottom: -5px;

        width: 2px;

        background: #dfe6e2;
    }


    .review-marker-circle {
        position: relative;

        z-index: 2;

        width: 32px;

        height: 32px;

        display: flex;

        align-items: center;

        justify-content: center;

        border: 2px solid #d8dfdb;

        border-radius: 50%;

        background: #ffffff;

        color:
            var(--review-muted);

        font-size: 12px;

        font-weight: 800;
    }



    /* ============================================================
       COMPLETED / SIGNED
    ============================================================ */

    .review-timeline-item.completed
    .review-marker-circle {

        background:
            var(--review-success);

        border-color:
            var(--review-success);

        color: #ffffff;
    }


    .review-timeline-item.completed
    .review-marker::after {

        background:
            var(--review-success);
    }



    /* ============================================================
       CURRENT REVIEWER
    ============================================================ */

    .review-timeline-item.current
    .review-marker-circle {

        background:
            var(--bs-golden-yellow);

        border-color:
            var(--bs-golden-yellow);

        color:
            var(--bs-dark-green);

        box-shadow:
            0 0 0 6px
            rgba(212, 175, 55, 0.16);
    }



    /* ============================================================
       REVIEW CONTENT
    ============================================================ */

    .review-timeline-content {
        min-width: 0;

        padding:
            1px 0 22px;
    }


    .review-timeline-top {
        display: flex;

        align-items: flex-start;

        justify-content:
            space-between;

        gap: 15px;
    }


    .review-order {
        margin-bottom: 4px;

        color:
            var(--review-muted);

        font-size: 10px;

        font-weight: 700;

        letter-spacing: 0.8px;

        text-transform: uppercase;
    }


    .review-name {
        color: #101c17;

        font-size: 16px;

        font-weight: 700;

        line-height: 1.3;
    }


    .current-review-label {
        margin-top: 7px;

        color: #9a7600;

        font-size: 11px;

        font-weight: 700;
    }



    /* ============================================================
       STATUS BADGES
    ============================================================ */

    .review-status {
        flex-shrink: 0;

        display: inline-flex;

        align-items: center;

        justify-content: center;

        padding:
            6px 12px;

        border-radius: 50px;

        font-size: 10px;

        font-weight: 700;

        white-space: nowrap;
    }


    /* SIGNED */

    .review-status.signed {
        background:
            var(--review-success-light);

        color:
            var(--review-success);
    }


    /* RECEIVED */

    .review-status.received {
        background:
            var(--review-received-light);

        color:
            var(--review-received);
    }


    /* PENDING */

    .review-status.pending {
        background:
            var(--review-pending-light);

        color:
            var(--review-pending);
    }


    /* NOT APPLICABLE */

    .review-status.na {
        background: #f0f2f1;

        color: #747d78;
    }



    /* ============================================================
       EMPTY REVIEWERS
    ============================================================ */

    .review-empty {
        padding: 18px;

        border: 1px dashed #dfe6e2;

        border-radius: 12px;

        background: #fbfcfd;

        color:
            var(--review-muted);

        font-size: 13px;

        text-align: center;
    }



    /* ============================================================
       MOBILE
    ============================================================ */

    @media (max-width: 576px) {

        .review-progress-heading {
            font-size: 17px;

            margin-bottom: 20px;
        }


        .review-timeline {
            padding: 0;
        }


        .review-timeline-item {
            grid-template-columns:
                40px minmax(0, 1fr);

            gap: 10px;

            min-height: 82px;
        }


        .review-marker-circle {
            width: 30px;

            height: 30px;

            font-size: 11px;
        }


        .review-timeline-item:not(:last-child)
        .review-marker::after {

            top: 32px;
        }


        .review-name {
            font-size: 14px;
        }


        .review-status {
            padding:
                5px 9px;

            font-size: 9px;
        }


        .current-review-label {
            font-size: 10px;
        }

    }

</style>



{{-- ================================================================
    BACK BUTTON
================================================================ --}}

<div class="mb-4">

    <a
        href="javascript:history.back()"
        class="
            btn
            btn-outline-dark-green
            rounded-pill
            px-3
            shadow-sm
        "
    >

        <i class="ri-arrow-left-s-line me-2"></i>

        Back

    </a>

</div>



<div class="container py-4">

    <form action="">


        <div class="row g-4 justify-content-center">


            {{-- ========================================================
                MAIN DETAILS CARD
            ======================================================== --}}

            <div class="col-lg-8">


                <div
                    class="
                        card
                        shadow-sm
                        border-0
                        rounded-4
                    "
                >


                    <div class="card-body p-4 p-md-5">


                        {{-- ============================================
                            TITLE
                        ============================================ --}}

                        <h4
                            class="fw-bold mb-4"
                            style="
                                color:
                                var(--bs-dark-green);
                            "
                        >

                            <i
                                class="
                                    ri-file-info-line
                                    me-2
                                "
                            ></i>

                            Task Overview & Details

                        </h4>



                        {{-- ============================================
                            PAP
                        ============================================ --}}

                        <div class="mb-3">

                            <label class="form-label">

                                Program, Activity,
                                Project (PAP)

                            </label>


                            <input
                                type="text"

                                class="form-control"

                                value="{{
                                    $fromtask->pap
                                }}"

                                readonly
                            >

                        </div>



                        {{-- ============================================
                            TASK
                        ============================================ --}}

                        <div class="mb-3">

                            <label class="form-label">

                                Task Description

                            </label>


                            <input
                                type="text"

                                class="form-control"

                                value="{{
                                    $fromtask->tasks
                                }}"

                                readonly
                            >

                        </div>



                        {{-- ============================================
                            ASSIGNED / ACTIVITY DATE
                        ============================================ --}}

                        <div class="row">


                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Assigned Personnel

                                </label>


                                <input
                                    type="text"

                                    class="form-control"

                                    value="{{
                                        $fromtask->Assigned
                                    }}"

                                    readonly
                                >

                            </div>



                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Activity Date

                                </label>


                                <input
                                    type="date"

                                    class="form-control"

                                    value="{{
                                        $fromtask->activitydate
                                    }}"

                                    readonly
                                >

                            </div>


                        </div>



                        {{-- ============================================
                            DUE DATE / LINK
                        ============================================ --}}

                        <div class="row">


                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Due Date

                                </label>


                                <input
                                    type="date"

                                    class="form-control"

                                    value="{{
                                        $fromtask->duedate
                                    }}"

                                    readonly
                                >

                            </div>



                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    File Link

                                </label>


                                <div class="input-group">


                                    <input
                                        type="text"

                                        class="form-control"

                                        id="fileLink"

                                        value="{{
                                            $fromtask->link
                                        }}"

                                        readonly
                                    >


                                    <a
                                        href="{{
                                            $fromtask->link
                                        }}"

                                        class="
                                            btn
                                            btn-golden-yellow
                                            px-3
                                            d-flex
                                            align-items-center
                                        "

                                        target="_blank"

                                        title="Open Link"
                                    >

                                        <i
                                            class="
                                                ri-link
                                                fs-16
                                            "
                                        ></i>

                                    </a>


                                </div>

                            </div>


                        </div>



                        {{-- ============================================
                            NOTES
                        ============================================ --}}

                        <div class="mb-4">

                            <label class="form-label">

                                Notes

                            </label>


                            <textarea
                                class="form-control"

                                rows="3"

                                readonly
                            >{{ $fromtask->note }}</textarea>

                        </div>



                        <hr class="my-4 border-light">



                        {{-- ====================================================
                            REVIEWER PROGRESS
                        ==================================================== --}}

                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | CURRENT REVIEWER
                            |--------------------------------------------------------------------------
                            |
                            | The first reviewer that is NOT Completed
                            | or Not Applicable becomes the current reviewer.
                            |
                            */

                            $currentReviewer =
                                $reviewers->first(
                                    function ($reviewer) {

                                        return !in_array(
                                            $reviewer->status,
                                            [
                                                'Completed',
                                                'Not Applicable'
                                            ],
                                            true
                                        );

                                    }
                                );

                        @endphp



                        <div class="review-progress-wrapper">


                            <div class="review-progress-heading">

                                <i
                                    class="
                                        ri-shield-check-line
                                    "
                                ></i>

                                Reviewer Sign-Off Progress

                            </div>



                            <div class="review-timeline">


                                @forelse(
                                    $reviewers as $reviewer
                                )


                                    @php

                                        /*
                                        |--------------------------------------------------------------------------
                                        | DISPLAY STATUS
                                        |--------------------------------------------------------------------------
                                        |
                                        | Database       Display
                                        | ------------------------
                                        | Completed      Signed
                                        | Received       Received
                                        | In Progress    Received
                                        | Pending        Pending
                                        |
                                        | This does NOT change the database.
                                        |
                                        */

                                        $displayStatus =
                                            match(
                                                $reviewer->status
                                            ) {

                                                'Completed'
                                                    => 'Signed',

                                                'In Progress'
                                                    => 'Received',

                                                default
                                                    => $reviewer->status

                                            };


                                        /*
                                        |--------------------------------------------------------------------------
                                        | COMPLETED
                                        |--------------------------------------------------------------------------
                                        */

                                        $isCompleted =
                                            in_array(
                                                $reviewer->status,
                                                [
                                                    'Completed',
                                                    'Not Applicable'
                                                ],
                                                true
                                            );


                                        /*
                                        |--------------------------------------------------------------------------
                                        | CURRENT
                                        |--------------------------------------------------------------------------
                                        */

                                        $isCurrent =
                                            $currentReviewer &&
                                            $currentReviewer->id ==
                                            $reviewer->id;


                                        /*
                                        |--------------------------------------------------------------------------
                                        | TIMELINE CLASS
                                        |--------------------------------------------------------------------------
                                        */

                                        $itemClass =
                                            $isCompleted
                                                ? 'completed'
                                                : (
                                                    $isCurrent
                                                        ? 'current'
                                                        : ''
                                                );


                                        /*
                                        |--------------------------------------------------------------------------
                                        | STATUS CLASS
                                        |--------------------------------------------------------------------------
                                        */

                                        $statusClass =
                                            match(
                                                $displayStatus
                                            ) {

                                                'Signed'
                                                    => 'signed',

                                                'Received'
                                                    => 'received',

                                                'Not Applicable'
                                                    => 'na',

                                                default
                                                    => 'pending'

                                            };


                                        /*
                                        |--------------------------------------------------------------------------
                                        | CIRCLE CONTENT
                                        |--------------------------------------------------------------------------
                                        */

                                        $marker =
                                            $isCompleted
                                                ? '✓'
                                                : $reviewer
                                                    ->review_order;

                                    @endphp



                                    <div
                                        class="
                                            review-timeline-item
                                            {{ $itemClass }}
                                        "
                                    >


                                        {{-- ============================
                                            MARKER
                                        ============================ --}}

                                        <div class="review-marker">


                                            <div
                                                class="
                                                    review-marker-circle
                                                "
                                            >

                                                {{ $marker }}

                                            </div>


                                        </div>



                                        {{-- ============================
                                            REVIEWER INFORMATION
                                        ============================ --}}

                                        <div
                                            class="
                                                review-timeline-content
                                            "
                                        >


                                            <div
                                                class="
                                                    review-timeline-top
                                                "
                                            >


                                                <div>


                                                    <div
                                                        class="
                                                            review-order
                                                        "
                                                    >

                                                        Reviewer

                                                        {{
                                                            $reviewer
                                                                ->review_order
                                                        }}

                                                    </div>



                                                    <div
                                                        class="
                                                            review-name
                                                        "
                                                    >

                                                        {{
                                                            $reviewer
                                                                ->reviewer_name
                                                            ?? 'Unknown user'
                                                        }}

                                                    </div>


                                                </div>



                                                {{-- ====================
                                                    STATUS
                                                ==================== --}}

                                                <span
                                                    class="
                                                        review-status
                                                        {{
                                                            $statusClass
                                                        }}
                                                    "
                                                >

                                                    {{
                                                        $displayStatus
                                                    }}

                                                </span>


                                            </div>



                                            {{-- ========================
                                                CURRENT REVIEW STAGE
                                            ======================== --}}

                                            @if($isCurrent)

                                                <div
                                                    class="
                                                        current-review-label
                                                    "
                                                >

                                                    Current review stage

                                                </div>

                                            @endif


                                        </div>


                                    </div>


                                @empty


                                    <div class="review-empty">

                                        No reviewers assigned.

                                    </div>


                                @endforelse


                            </div>


                        </div>


                    </div>

                </div>

            </div>



            {{-- ========================================================
                SIDEBAR — OBLIGATION DETAILS
            ======================================================== --}}

            <div class="col-lg-4">


                <div
                    class="
                        card
                        shadow-sm
                        border-0
                        rounded-4
                    "
                >


                    <div
                        class="
                            card-header
                            obligation-header
                            py-3
                            px-4
                        "
                    >

                        <i
                            class="
                                ri-wallet-3-line
                                me-2
                            "
                        ></i>

                        Obligation Details

                    </div>



                    <div class="card-body p-4">


                        <div class="mb-3">

                            <label class="form-label">

                                Allocated From

                            </label>

                        </div>



                        {{-- FUND SOURCE --}}

                        <div class="mb-3">

                            <label
                                class="
                                    form-label
                                    text-muted
                                    fs-11
                                "
                            >

                                Fund Source

                            </label>


                            <input
                                class="
                                    form-control
                                    bg-white
                                "

                                value="{{
                                    $fromtask->fundName
                                }}"

                                readonly
                            >

                        </div>



                        {{-- OBEX / MOOE --}}

                        <div class="mb-4">

                            <label
                                class="
                                    form-label
                                    text-muted
                                    fs-11
                                "
                            >

                                OBEX / MOOE

                            </label>


                            <input
                                class="
                                    form-control
                                    bg-white
                                "

                                value="{{
                                    $fromtask->mooeName
                                }}"

                                readonly
                            >

                        </div>



                        <hr class="border-light my-4">



                        {{-- OBLIGATED AMOUNT --}}

                        <div class="mb-2">

                            <label class="form-label">

                                Obligated Amount

                            </label>


                            <div class="input-group">


                                <span
                                    class="
                                        input-group-text
                                        bg-light
                                        fw-bold
                                        text-success
                                    "
                                >

                                    ₱

                                </span>


                                <input
                                    class="
                                        form-control
                                        bg-white
                                        text-end
                                        fw-bold
                                        fs-16
                                        text-dark
                                    "

                                    value="{{
                                        number_format(
                                            $fromtask
                                                ->obligatedbudget,
                                            2
                                        )
                                    }}"

                                    readonly
                                >


                            </div>

                        </div>


                    </div>

                </div>

            </div>


        </div>


    </form>

</div>

@endsection