<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="theme-color" content="#0b3c29">

    <title>BRO Document Tracking</title>

    <style>

        * {
            box-sizing: border-box;
        }

        :root {
            --green-dark: #0b3c29;
            --green: #145a3a;
            --green-light: #eaf2ed;

            --gold: #d4af37;
            --gold-light: #faf5df;

            --text: #17221c;
            --muted: #77817b;

            --border: #e3e8e5;
            --background: #f4f7f5;

            --success: #198754;
            --success-light: #e8f5ed;

            --pending: #9a7b16;
            --pending-light: #fff8df;

            --blue: #2463a9;
            --blue-light: #eaf2fb;
        }


        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100%;
        }


        body {
            font-family:
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                Roboto,
                Arial,
                sans-serif;

            background: var(--background);
            color: var(--text);
        }


        button,
        input {
            font-family: inherit;
        }


        /* ============================================================
           PAGE
        ============================================================ */

        .page {
            width: 100%;
            max-width: 520px;
            min-height: 100vh;

            margin: 0 auto;

            background: #fff;
        }


        /* ============================================================
           HEADER
        ============================================================ */

        .header {
            position: relative;

            padding: 28px 22px 27px;

            background: var(--green-dark);
            color: #fff;

            overflow: hidden;
        }


        .header::before {
            content: "";

            position: absolute;

            width: 180px;
            height: 180px;

            border-radius: 50%;

            right: -75px;
            top: -95px;

            background: rgba(212, 175, 55, .10);
        }


        .header::after {
            content: "";

            position: absolute;

            width: 100px;
            height: 100px;

            border-radius: 50%;

            right: 40px;
            bottom: -70px;

            background: rgba(255, 255, 255, .04);
        }


        .header-office {
            position: relative;
            z-index: 2;

            margin-bottom: 7px;

            color: var(--gold);

            font-size: 10px;
            font-weight: 800;

            letter-spacing: 1.5px;

            text-transform: uppercase;
        }


        .header-title {
            position: relative;
            z-index: 2;

            margin: 0;

            font-size: 22px;
            font-weight: 750;

            line-height: 1.25;
        }


        .header-subtitle {
            position: relative;
            z-index: 2;

            margin-top: 7px;

            font-size: 12px;

            color: rgba(255, 255, 255, .70);
        }


        /* ============================================================
           CONTENT
        ============================================================ */

        .content {
            padding: 20px 18px 35px;
        }


        .section {
            margin-bottom: 27px;
        }


        .section:last-child {
            margin-bottom: 0;
        }


        .section-label {
            display: flex;
            align-items: center;

            gap: 8px;

            margin-bottom: 12px;

            color: var(--green);

            font-size: 10px;
            font-weight: 800;

            letter-spacing: 1.2px;

            text-transform: uppercase;
        }


        .section-label::before {
            content: "";

            width: 4px;
            height: 15px;

            border-radius: 10px;

            background: var(--gold);
        }


        /* ============================================================
           ALERT
        ============================================================ */

        .success-alert {
            display: flex;
            align-items: flex-start;

            gap: 10px;

            margin-bottom: 20px;

            padding: 14px 15px;

            border: 1px solid #cce7d6;
            border-radius: 13px;

            background: var(--success-light);

            color: var(--success);

            font-size: 13px;
            line-height: 1.4;
        }


        .success-alert-icon {
            flex-shrink: 0;

            width: 20px;
            height: 20px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: var(--success);

            color: #fff;

            font-size: 11px;
            font-weight: 800;
        }


        /* ============================================================
           TASK CARD
        ============================================================ */

        .task-card {
            padding: 18px;

            border: 1px solid var(--border);
            border-radius: 16px;

            background: #fff;

            box-shadow:
                0 4px 18px rgba(11, 60, 41, .05);
        }


        .info-item + .info-item {
            margin-top: 17px;

            padding-top: 17px;

            border-top: 1px solid #eef1ef;
        }


        .info-label {
            margin-bottom: 5px;

            color: var(--muted);

            font-size: 9px;
            font-weight: 800;

            letter-spacing: 1px;

            text-transform: uppercase;
        }


        .info-value {
            color: var(--text);

            font-size: 16px;
            font-weight: 700;

            line-height: 1.45;

            word-break: break-word;
        }


        /* ============================================================
           REVIEW TIMELINE
        ============================================================ */

        .timeline {
            padding: 3px 1px;
        }


        .review-step {
            position: relative;

            display: grid;

            grid-template-columns: 40px minmax(0, 1fr);

            gap: 12px;

            min-height: 78px;
        }


        .review-step:last-child {
            min-height: auto;
        }


        .review-marker {
            position: relative;

            display: flex;
            justify-content: center;
        }


        .review-step:not(:last-child)
        .review-marker::after {
            content: "";

            position: absolute;

            top: 31px;
            bottom: -3px;

            width: 2px;

            background: #dfe6e2;
        }


        .marker-circle {
            position: relative;
            z-index: 2;

            width: 29px;
            height: 29px;

            display: flex;
            align-items: center;
            justify-content: center;

            border: 2px solid #d8dfdb;
            border-radius: 50%;

            background: #fff;

            color: var(--muted);

            font-size: 11px;
            font-weight: 800;
        }


        /* ============================================================
           SIGNED / COMPLETED STEP
        ============================================================ */

        .review-step.completed
        .marker-circle {
            border-color: var(--green);

            background: var(--green);

            color: #fff;
        }


        .review-step.completed
        .review-marker::after {
            background: var(--green);
        }


        /* ============================================================
           CURRENT STEP
        ============================================================ */

        .review-step.current
        .marker-circle {
            border-color: var(--gold);

            background: var(--gold);

            color: var(--green-dark);

            box-shadow:
                0 0 0 5px rgba(212, 175, 55, .14);
        }


        .review-content {
            min-width: 0;

            padding: 2px 0 19px;
        }


        .review-top {
            display: flex;

            align-items: flex-start;
            justify-content: space-between;

            gap: 10px;
        }


        .review-information {
            min-width: 0;
        }


        .review-order {
            margin-bottom: 4px;

            color: var(--muted);

            font-size: 9px;
            font-weight: 800;

            letter-spacing: .9px;

            text-transform: uppercase;
        }


        .reviewer-name {
            color: var(--text);

            font-size: 15px;
            font-weight: 750;

            line-height: 1.3;

            word-break: break-word;
        }


        .current-text {
            margin-top: 7px;

            color: #98760d;

            font-size: 10px;
            font-weight: 750;
        }


        /* ============================================================
           STATUS BADGES
        ============================================================ */

        .status {
            flex-shrink: 0;

            display: inline-flex;
            align-items: center;

            padding: 5px 9px;

            border-radius: 50px;

            font-size: 9px;
            font-weight: 800;

            white-space: nowrap;
        }


        .status-signed {
            background: var(--success-light);

            color: var(--success);
        }


        .status-received {
            background: var(--blue-light);

            color: var(--blue);
        }


        .status-pending {
            background: var(--pending-light);

            color: var(--pending);
        }


        .status-na {
            background: #f0f1f1;

            color: #707773;
        }


        /* ============================================================
           CURRENT REVIEW CARD
        ============================================================ */

        .current-card {
            position: relative;

            overflow: hidden;

            padding: 20px;

            border: 1px solid #d7e7dd;
            border-radius: 16px;

            background: var(--green-light);
        }


        .current-card::before {
            content: "";

            position: absolute;

            left: 0;
            top: 0;
            bottom: 0;

            width: 5px;

            background: var(--green);
        }


        .current-label {
            margin-bottom: 6px;

            color: var(--green);

            font-size: 9px;
            font-weight: 800;

            letter-spacing: 1px;

            text-transform: uppercase;
        }


        .current-name {
            margin-bottom: 10px;

            color: var(--green-dark);

            font-size: 20px;
            font-weight: 750;

            line-height: 1.3;
        }


        /* ============================================================
           RECEIVED MESSAGE
        ============================================================ */

        .received-message {
            display: flex;
            align-items: flex-start;

            gap: 10px;

            margin-top: 17px;

            padding-top: 15px;

            border-top: 1px solid #d4e3da;

            color: var(--green);

            font-size: 12px;

            line-height: 1.5;
        }


        .message-icon {
            flex-shrink: 0;

            width: 22px;
            height: 22px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: var(--green);

            color: #fff;

            font-size: 11px;
            font-weight: 800;
        }


        /* ============================================================
           BUTTON
        ============================================================ */

        .action-form {
            margin-top: 17px;
        }


        .action-button {
            width: 100%;

            padding: 15px 16px;

            border: 0;
            border-radius: 12px;

            background: var(--green-dark);

            color: #fff;

            font-size: 14px;
            font-weight: 750;

            cursor: pointer;

            box-shadow:
                0 5px 15px rgba(11, 60, 41, .18);

            transition:
                transform .15s ease,
                opacity .15s ease;
        }


        .action-button:active {
            transform: scale(.98);
        }


        .signed-button {
            background: var(--green);
        }


        .button-description {
            margin-top: 10px;

            color: var(--muted);

            font-size: 10px;

            line-height: 1.45;

            text-align: center;
        }


        /* ============================================================
           ALL REVIEWS COMPLETE
        ============================================================ */

        .completed-card {
            padding: 27px 20px;

            border: 1px solid #d3eadb;
            border-radius: 16px;

            background: var(--success-light);

            text-align: center;
        }


        .completed-icon {
            width: 50px;
            height: 50px;

            margin: 0 auto 13px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: var(--green);

            color: #fff;

            font-size: 22px;
            font-weight: 800;
        }


        .completed-title {
            color: var(--green-dark);

            font-size: 17px;
            font-weight: 750;
        }


        .completed-description {
            margin-top: 6px;

            color: var(--muted);

            font-size: 11px;

            line-height: 1.5;
        }


        /* ============================================================
           FOOTER
        ============================================================ */

        .footer {
            padding: 0 18px 25px;

            color: #9aa19d;

            font-size: 9px;

            line-height: 1.5;

            text-align: center;
        }


        /* ============================================================
           DESKTOP / TABLET
        ============================================================ */

        @media (min-width: 521px) {

            body {
                padding: 25px 0;
            }


            .page {
                min-height: auto;

                overflow: hidden;

                border-radius: 18px;

                box-shadow:
                    0 10px 40px rgba(11, 60, 41, .10);
            }

        }


        /* ============================================================
           SMALL MOBILE
        ============================================================ */

        @media (max-width: 350px) {

            .content {
                padding-left: 14px;
                padding-right: 14px;
            }


            .review-top {
                flex-direction: column;

                gap: 7px;
            }


            .status {
                align-self: flex-start;
            }

        }

    </style>

</head>


<body>


<div class="page">


    {{-- ================================================================
        HEADER
    ================================================================= --}}

    <header class="header">

        <div class="header-office">
            Bangsamoro Revenue Office
        </div>

        <h1 class="header-title">
            Document Tracking
        </h1>

        <div class="header-subtitle">
            Task Review and Document Status
        </div>

    </header>



    <main class="content">


        {{-- ============================================================
            SUCCESS MESSAGE
        ============================================================ --}}

        @if(session('success'))

            <div class="success-alert">

                <div class="success-alert-icon">
                    ✓
                </div>

                <div>
                    {{ session('success') }}
                </div>

            </div>

        @endif



        {{-- ============================================================
            TASK INFORMATION
        ============================================================ --}}

        <section class="section">


            <div class="section-label">
                Document Information
            </div>


            <div class="task-card">


                <div class="info-item">

                    <div class="info-label">
                        Task
                    </div>

                    <div class="info-value">
                        {{ $task->task }}
                    </div>

                </div>



                <div class="info-item">

                    <div class="info-label">
                        Program / Activity / Project
                    </div>

                    <div class="info-value">
                        {{ $task->pap }}
                    </div>

                </div>


                @if(!empty($task->activitydate))

                    <div class="info-item">

                        <div class="info-label">
                            Activity Date
                        </div>

                        <div class="info-value">

                            {{
                                \Carbon\Carbon::parse(
                                    $task->activitydate
                                )->format('F d, Y')
                            }}

                        </div>

                    </div>

                @endif


            </div>

        </section>



        {{-- ============================================================
            REVIEW PROGRESS
        ============================================================ --}}

        <section class="section">


            <div class="section-label">
                Document Progress
            </div>


            <div class="timeline">


                @forelse($reviewers as $reviewer)


                    @php

                        /*
                        |--------------------------------------------------------------------------
                        | QR DISPLAY STATUS
                        |--------------------------------------------------------------------------
                        |
                        | IMPORTANT:
                        |
                        | Database Value        QR Display
                        | --------------------------------
                        | Pending               Pending
                        | Received              Received
                        | In Progress           Received
                        | Completed             Signed
                        | Not Applicable        Not Applicable
                        |
                        | "Signed" is DISPLAY ONLY.
                        |
                        */


                        $displayStatus = match($reviewer->status) {

                            'Completed' =>
                                'Signed',

                            'In Progress' =>
                                'Received',

                            default =>
                                $reviewer->status

                        };


                        /*
                        |--------------------------------------------------------------------------
                        | CURRENT REVIEWER
                        |--------------------------------------------------------------------------
                        */

                        $isCurrent =
                            $currentReviewer &&
                            $currentReviewer->id == $reviewer->id;


                        /*
                        |--------------------------------------------------------------------------
                        | FINISHED REVIEWER
                        |--------------------------------------------------------------------------
                        */

                        $isCompleted = in_array(
                            $reviewer->status,
                            [
                                'Completed',
                                'Not Applicable'
                            ],
                            true
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | TIMELINE CLASS
                        |--------------------------------------------------------------------------
                        */

                        $stepClass = $isCompleted
                            ? 'completed'
                            : ($isCurrent ? 'current' : '');


                        /*
                        |--------------------------------------------------------------------------
                        | BADGE CLASS
                        |--------------------------------------------------------------------------
                        */

                        $statusClass = match($displayStatus) {

                            'Signed' =>
                                'status-signed',

                            'Received' =>
                                'status-received',

                            'Not Applicable' =>
                                'status-na',

                            default =>
                                'status-pending'

                        };


                        /*
                        |--------------------------------------------------------------------------
                        | MARKER
                        |--------------------------------------------------------------------------
                        */

                        $marker = $isCompleted
                            ? '✓'
                            : $reviewer->review_order;

                    @endphp



                    <div class="review-step {{ $stepClass }}">


                        {{-- TIMELINE MARKER --}}

                        <div class="review-marker">

                            <div class="marker-circle">
                                {{ $marker }}
                            </div>

                        </div>



                        {{-- REVIEW INFORMATION --}}

                        <div class="review-content">


                            <div class="review-top">


                                <div class="review-information">

                                    <div class="review-order">

                                        Reviewer
                                        {{ $reviewer->review_order }}

                                    </div>


                                    <div class="reviewer-name">

                                        {{
                                            $reviewer->reviewer_name
                                            ?? 'Reviewer'
                                        }}

                                    </div>

                                </div>



                                <span class="status {{ $statusClass }}">

                                    {{ $displayStatus }}

                                </span>


                            </div>



                            @if($isCurrent)

                                <div class="current-text">
                                    Current review stage
                                </div>

                            @endif


                        </div>


                    </div>


                @empty


                    <div class="task-card">

                        <div class="info-value">
                            No reviewers assigned to this document.
                        </div>

                    </div>


                @endforelse


            </div>


        </section>



        {{-- ============================================================
            CURRENT REVIEW
        ============================================================ --}}

        <section class="section">


            <div class="section-label">
                Current Review
            </div>



            @if($currentReviewer)


                @php

                    /*
                    |--------------------------------------------------------------------------
                    | CURRENT DISPLAY STATUS
                    |--------------------------------------------------------------------------
                    */

                    $currentDisplayStatus = match(
                        $currentReviewer->status
                    ) {

                        'Completed' =>
                            'Signed',

                        'In Progress' =>
                            'Received',

                        default =>
                            $currentReviewer->status

                    };


                    /*
                    |--------------------------------------------------------------------------
                    | CURRENT STATUS BADGE
                    |--------------------------------------------------------------------------
                    */

                    $currentStatusClass = match(
                        $currentDisplayStatus
                    ) {

                        'Signed' =>
                            'status-signed',

                        'Received' =>
                            'status-received',

                        default =>
                            'status-pending'

                    };

                @endphp



                <div class="current-card">


                    <div class="current-label">
                        Current Reviewer
                    </div>


                    <div class="current-name">

                        {{
                            $currentReviewer->reviewer_name
                            ?? 'Reviewer'
                        }}

                    </div>



                    <span class="status {{ $currentStatusClass }}">

                        {{ $currentDisplayStatus }}

                    </span>



                    {{-- =================================================
                        PENDING

                        Actual database:
                        Pending

                        Button submits:
                        Received
                    ================================================== --}}

                    @if(
                        $currentReviewer->status === 'Pending'
                    )


                        <form
                            class="action-form"

                            method="POST"

                            action="{{
                                route(
                                    'task.qr.review.update',
                                    $task->qr_review_token
                                )
                            }}"
                        >


                            @csrf


                            <input
                                type="hidden"
                                name="status"
                                value="Received"
                            >


                            <button
                                type="submit"
                                class="action-button"
                            >

                                Mark Document as Received

                            </button>


                        </form>


                        <div class="button-description">

                            Confirm that the physical document
                            has been received by the current reviewer.

                        </div>



                    {{-- =================================================
                        RECEIVED

                        Actual database:
                        Received

                        QR displays:
                        Received

                        Button submits:
                        Signed

                        Controller must translate:
                        Signed → Completed
                    ================================================== --}}

                    @elseif(
                        in_array(
                            $currentReviewer->status,
                            [
                                'Received',
                                'In Progress'
                            ],
                            true
                        )
                    )


                        <div class="received-message">


                            <div class="message-icon">
                                ✓
                            </div>


                            <div>

                                <strong>
                                    Document Received
                                </strong>

                                <br>

                                The document has been received
                                by the current reviewer.

                            </div>


                        </div>



                        <form
                            class="action-form"

                            method="POST"

                            action="{{
                                route(
                                    'task.qr.review.update',
                                    $task->qr_review_token
                                )
                            }}"
                        >


                            @csrf


                            {{-- IMPORTANT:
                                 "Signed" is sent to the controller.

                                 Controller translates:
                                 Signed = Completed
                            --}}

                            <input
                                type="hidden"
                                name="status"
                                value="Signed"
                            >


                            <button
                                type="submit"
                                class="
                                    action-button
                                    signed-button
                                "
                            >

                                Mark Document as Signed

                            </button>


                        </form>


                        <div class="button-description">

                            Confirm that the document has been
                            signed and completed by the current reviewer.

                        </div>


                    @endif


                </div>



            @else


                {{-- =====================================================
                    NO CURRENT REVIEWER

                    This means all task_reviewers are either:

                    Completed
                    Not Applicable
                ====================================================== --}}


                <div class="completed-card">


                    <div class="completed-icon">
                        ✓
                    </div>


                    <div class="completed-title">
                        Document Review Completed
                    </div>


                    <div class="completed-description">

                        All required review and signature
                        stages for this document have been completed.

                    </div>


                </div>


            @endif


        </section>


    </main>



    {{-- ================================================================
        FOOTER
    ================================================================= --}}

    <footer class="footer">

        Bangsamoro Revenue Office

        <br>

        Task Monitoring System

    </footer>


</div>


</body>

</html>