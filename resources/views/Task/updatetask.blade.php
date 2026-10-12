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



    /* Container & Card Styling */

    .task-form-wrapper {

        padding: 10px 0 40px 0;

    }



    .card {

        border: none;

        border-radius: 1rem;

        box-shadow: 0 0.5rem 1.5rem rgba(10, 54, 34, 0.05);

        background: #ffffff;

    }



    .form-label {

        font-weight: 600;

        color: var(--bs-dark-green);

        font-size: 0.85rem;

        text-transform: uppercase;

        letter-spacing: 0.5px;

    }



    .form-control, .form-select {

        border-radius: 0.50rem;

        border: 1px solid #ced4da;

        padding: 0.65rem 0.9rem;

        font-size: 0.925rem;

        transition: all 0.2s ease;

    }



    .form-control:focus, .form-select:focus {

        border-color: var(--bs-accent-green);

        box-shadow: 0 0 0 0.25rem rgba(25, 111, 71, 0.15);

    }



    .form-control[readonly], .form-control:disabled {

        background-color: #f8f9fa;

        color: #495057;

        border-color: #e9ecef;

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



    /* Reviewer Row Grid Styling */

    .reviewer-row {

        background: #fbfcfd;

        border: 1px solid #edf2f7;

        padding: 12px 15px;

        border-radius: 0.75rem;

        margin-bottom: 12px;

        transition: all 0.2s ease;

    }



    .reviewer-row:hover {

        border-color: var(--bs-golden-yellow-border);

        box-shadow: 0 0.25rem 0.75rem rgba(10, 54, 34, 0.03);

    }



    /* Toggle Obligation Button Styling */

    .btn-toggle-panel {

        background-color: #ffffff;

        border: 1px solid var(--bs-golden-yellow-border);

        color: var(--bs-dark-green);

        transition: all 0.2s ease;

    }



    .btn-toggle-panel:hover {

        background-color: var(--bs-golden-yellow-light);

        border-color: var(--bs-golden-yellow);

        color: var(--bs-dark-green);

    }



    /* Obligation Details Sidebar Header */

    .obligation-header {

        background: linear-gradient(135deg, var(--bs-dark-green), var(--bs-accent-green));

        color: #ffffff;

        border-top-left-radius: 1rem;

        border-top-right-radius: 1rem;

        font-weight: 700;

        padding: 15px 20px;

    }

</style>



<div class="task-form-wrapper">

    <form action="{{ route('updatetask') }}" method="POST" id="updateTaskForm">

        @csrf



        <!-- Back Navigation & Header Action -->

        <div class="d-flex justify-content-between align-items-center mb-4">

            <a href="javascript:history.back()"

               class="btn btn-outline-dark-green btn-label waves-effect waves-light rounded-pill px-3">

                <i class="ri-arrow-left-s-line align-middle rounded-pill fs-16 me-2"></i>

                Back

            </a>



            <button type="submit" class="btn btn-dark-green rounded-pill px-4 shadow-sm">

                <i class="ri-save-line label-icon align-middle rounded-pill fs-16 me-2"></i> Save Changes  

            </button>

        </div>



        <div class="row justify-content-center g-4">



            <!-- Main Task Details Form -->

            <div class="col-lg-7">

                <div class="card shadow-sm border-0 rounded-4">

                    <div class="card-body p-4 p-md-5">







                        <input class="form-control" name="id" value="{{$fromtask->id}}" hidden>



                        <div class="mb-3">

                            <label class="form-label">PAP (Programs, Activities, Projects)</label>

                            <input type="text" class="form-control" value="{{$fromtask->pap}}" readonly>

                        </div>



                        <div class="mb-3">

                            <label class="form-label">Task Description</label>

                            <input type="text" class="form-control" value="{{$fromtask->tasks}}" readonly>

                        </div>



                        <div class="mb-3">

                            <label class="form-label">Assigned Personnel</label>

                            <input type="text" class="form-control" value="{{$fromtask->Assigned}}" readonly>

                        </div>



                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">Indicative Date</label>

                                <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($fromtask->papdate)->format('F d') }} to {{ \Carbon\Carbon::parse($fromtask->papdateend)->format('d, Y') }}" readonly>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">Target Date of Accomplishment</label>

                                <input type="date" class="form-control" value="{{$fromtask->duedate}}" readonly>

                            </div>

                        </div>



                        <div class="mb-3">

                            <label for="note" class="form-label">Notes & Remarks</label>

                            <textarea class="form-control" id="note" name="note" rows="3" placeholder="Enter optional notes here...">{{$fromtask->note}}</textarea>

                        </div>



                        <div class="mb-4">

                            <label for="filelink" class="form-label">Reference Link / Deliverable URL</label>

                            <div class="input-group">

                                <span class="input-group-text bg-light"><i class="ri-link"></i></span>

                                <input type="url" id="filelink" name="link" class="form-control" value="{{$fromtask->link}}" placeholder="https://example.com">

                            </div>

                        </div>



                        <hr class="my-4 text-muted opacity-25">





                        <!-- Reviewers & Status Section -->
                        <h5 class="fw-bold mb-3" style="color: var(--bs-dark-green);">
                            <i class="ri-shield-check-line me-2"></i> Multi-Stage Reviewers & Status
                        </h5>
                        @forelse($reviewers as $reviewer)
                            <div class="reviewer-row mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-6 mb-2 mb-md-0">
                                        <label class="form-label text-muted fs-11 mb-1">Reviewer {{ $reviewer->review_order }}</label>
                                        <input value="{{ $reviewer->reviewer_name }}" class="form-control bg-light" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted fs-11 mb-1">Status</label>
                                        @if((int) $reviewer->reviewer_id === (int) Auth::id() &&
                                            (int) $fromtask->reviewLevel >= 1 &&
                                            (int) $reviewer->id === (int) optional($reviewers->first(fn($r) => !in_array($r->status, ['Completed', 'Not Applicable'])))->id)
                                            <select class="form-select" name="review_status[{{ $reviewer->id }}]">
                                                @foreach(['Pending', 'Received', 'Completed', 'Not Applicable'] as $option)
                                                    <option value="{{ $option }}" @selected(old('review_status.'.$reviewer->id, $reviewer->status) === $option)>{{ $option }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input class="form-control bg-light" value="{{ $reviewer->status }}" readonly>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">No reviewers assigned.</p>
                        @endforelse
                    </div>
                </div>
                <div class="mb-4" id="forusertype2" style="display: none;">

            <button type="submit" class="btn btn-dark-green rounded-pill px-4 shadow-sm float-end" value="staff" name="action">

                <i class="ri-save-line label-icon align-middle rounded-pill fs-16 me-2"></i> Save and Submit for Review

            </button>
            <div class="d-flex justify-content-between align-items-center mt-3">

    <button type="button"
            class="btn btn-dark-green rounded-pill px-4 shadow-sm"
            id="generateQrButton"
            data-bs-toggle="modal"
            data-bs-target="#taskQrModal">
        <i class="ri-qr-code-line me-1"></i>
        Generate QR Code
    </button>

</div>

        </div>

            </div>





            <!-- Toggle Button Column -->

            <div class="col-auto d-none d-lg-flex justify-content-center align-items-center">

                <button type="button"

                        id="toggleObligation"

                        class="btn btn-toggle-panel rounded-circle shadow-sm d-flex align-items-center justify-content-center"

                        style="width: 48px; height: 48px;"

                        title="Toggle Obligation Details">

                    <i id="toggleIcon" class="ri-arrow-right-s-line fs-4"></i>

                </button>

            </div>



            <!-- Obligation Details Sidebar -->

            <div class="col-lg-4" id="obligationDetails">

                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">

                    <div class="obligation-header">

                        <i class="ri-money-dollar-circle-line me-2"></i> Obligation Details

                    </div>



                    <div class="card-body p-4">

                        <div class="mb-3">

                            <label class="form-label">Allocated From Fund</label>

                            <input type="text" class="form-control bg-light" value="{{$fromtask->fundname}}" readonly>

                        </div>



                        <div class="mb-4">

                            <label class="form-label" for="mooe">OBEX / MOOE Category</label>

                            <select class="form-select" name="mooe" id="mooe">

                                <option value="{{$fromtask->mooeID}}">{{$fromtask->mooeName}}</option>

                                @foreach($mooe as $mooes)

                                <option value="{{$mooes->mooeID}}">{{$mooes->mooeName}}</option>

                                @endforeach

                            </select>

                        </div>



                        <hr class="my-4 text-muted opacity-25">



                        <div class="mb-3">

                            <label class="form-label">Obligated Amount</label>

                            <div class="input-group">

                                <span class="input-group-text bg-light fw-bold text-success">₱</span>

                                <input type="number" step="0.01" class="form-control text-end fw-bold" name="budget" value="{{$fromtask->obligatedbudget}}">

                            </div>

                        </div>

                    </div>





                </div>





            </div>







        </div>







    </form>

</div>



<div class="modal fade" id="taskQrModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ri-qr-code-line me-1"></i>
                    Task QR Code
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body text-center py-4">

                {{-- PRINTABLE AREA --}}
                <div id="qrPrintArea">

                    <div class="mb-3">
                        @php
    $taskUrl = url('http://192.168.68.111:8003/qr-review/' . $fromtask->qr_review_token);

    $qrCode = app(\SimpleSoftwareIO\QrCode\Generator::class)
        ->size(220)
        ->margin(2)
        ->generate($taskUrl);
@endphp

{!! $qrCode !!}

                    <h5 class="fw-bold mb-1">
                        {{ $fromtask->tasks }}
                    </h5>

                    <p class="text-muted mb-1">
                        {{ $fromtask->pap }}
                    </p>

                    <small class="text-muted">
                        Scan QR Code to view task
                    </small>

                </div>

            </div>

            <div class="modal-footer justify-content-center">

                <button type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">
                    Close
                </button>

                <button type="button"
                        class="btn btn-success"
                        onclick="printTaskQR()">

                    <i class="ri-printer-line me-1"></i>
                    Print QR Code

                </button>

            </div>

        </div>
    </div>
</div>


<script>

    document.addEventListener('DOMContentLoaded', function() {

        const obligationDetails = document.getElementById('obligationDetails');

        const mooeSelect = document.getElementById('mooe');

        const toggleButton = document.getElementById('toggleObligation');

        const utype2 = document.getElementById('forusertype2');







        if(mooeSelect.value !== "")

        {

            obligationDetails.style.display = 'block';

        } else {

            obligationDetails.style.display = 'none';

        }



        toggleButton.addEventListener('click', function() {

            if (obligationDetails.style.display === 'none') {

                obligationDetails.style.display = 'block';

                document.getElementById('toggleIcon').classList.remove('ri-arrow-right-s-line');

                document.getElementById('toggleIcon').classList.add('ri-arrow-left-s-line');

            } else {

                obligationDetails.style.display = 'none';

                document.getElementById('toggleIcon').classList.remove('ri-arrow-left-s-line');

                document.getElementById('toggleIcon').classList.add('ri-arrow-right-s-line');

            }

        });





    });



    document.addEventListener('DOMContentLoaded', function() {

        const utype2 = document.getElementById('forusertype2');
        const qrcodebutton = document.getElementById('generateQrButton');

        const userType = @json(Auth::user()->usertype);



        if (userType <= 2) {

            utype2.style.display = 'block';
            qrcodebutton.style.display = 'block';

        } else {

            utype2.style.display = 'none';
            qrcodebutton.style.display = 'none';

        }



    });


function printTaskQR() {

    const printContent =
        document.getElementById('qrPrintArea').innerHTML;

    const printWindow = window.open('', '', 'width=600,height=700');

    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Task QR Code</title>

            <style>
                body {
                    font-family: Arial, sans-serif;
                    text-align: center;
                    padding: 40px;
                }

                .qr-container {
                    max-width: 400px;
                    margin: auto;
                }

                svg {
                    width: 220px;
                    height: 220px;
                }

                h5 {
                    font-size: 18px;
                    margin: 15px 0 5px;
                }

                p {
                    font-size: 14px;
                    margin: 5px 0;
                }

                small {
                    font-size: 12px;
                }
            </style>
        </head>

        <body>

            <div class="qr-container">
                ${printContent}
            </div>

            <script>
                window.onload = function() {
                    window.print();
                    window.close();
                };
            <\/script>

        </body>
        </html>
    `);

    printWindow.document.close();
}




</script>



@endsection