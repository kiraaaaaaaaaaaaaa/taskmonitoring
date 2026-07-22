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

    /* Card styling */
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
        box-shadow: 0 0 0 0.25rem rgba(25, 111, 71, 0.15);
        background-color: #ffffff;
    }

    /* Reviewer row styling */
    .reviewer-row {
        background: #fbfcfd;
        border: 1px solid #edf2f7;
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        margin-bottom: 0.75rem;
        transition: all 0.2s ease;
    }

    .reviewer-row:hover {
        border-color: var(--bs-golden-yellow-border);
    }

    /* Sidebar Obligation Card Header */
    .obligation-header {
        background-color: var(--bs-dark-green) !important;
        color: #ffffff;
        border-top-left-radius: 1rem !important;
        border-top-right-radius: 1rem !important;
        font-weight: 600;
        letter-spacing: 0.5px;
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

    .btn-golden-yellow {
        background-color: var(--bs-golden-yellow);
        color: var(--bs-dark-green);
        font-weight: 600;
        border: none;
    }

    .btn-golden-yellow:hover {
        background-color: #c59f2c;
        color: var(--bs-dark-green);
    }
</style>
<div class="mb-4">
            <a href="javascript:history.back()" class="btn btn-outline-dark-green rounded-pill px-3 shadow-sm">
                <i class="ri-arrow-left-s-line me-2"></i> Back
            </a>
        </div>

<div class="container py-4">
    <form action="">

        <!-- Back Button -->
        

        <div class="row g-4 justify-content-center">
            
            <!-- Main Details Card -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4 p-md-5">
                        
                        <h4 class="fw-bold mb-4" style="color: var(--bs-dark-green);">
                            <i class="ri-file-info-line me-2"></i> Task Overview & Details
                        </h4>

                        <div class="mb-3">
                            <label class="form-label">Program, Activity, Project (PAP)</label>
                            <input type="text" class="form-control" value="{{ $fromtask->pap }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Task Description</label>
                            <input type="text" class="form-control" value="{{ $fromtask->tasks }}" readonly>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Assigned Personnel</label>
                                <input type="text" class="form-control" value="{{ $fromtask->Assigned }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Activity Date</label>
                                <input type="date" class="form-control" value="{{ $fromtask->activitydate }}" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Due Date</label>
                                <input type="date" class="form-control" value="{{ $fromtask->duedate }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">File Link</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="fileLink" value="{{ $fromtask->link }}" readonly>
                                    <a href="{{ $fromtask->link }}" class="btn btn-golden-yellow px-3 d-flex align-items-center" target="_blank" title="Open Link">
                                        <i class="ri-link fs-16"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Notes</label>
                            <input type="text" class="form-control" value="{{ $fromtask->note }}" readonly>
                        </div>

                        <hr class="my-4 border-light">

                        <h5 class="fw-bold mb-3" style="color: var(--bs-dark-green);">
                            <i class="ri-shield-check-line me-2"></i> Reviewer Sign-Off Status
                        </h5>

                        <!-- Reviewer 1 (Primary) -->
                        <div class="reviewer-row row align-items-center g-2">
                            <div class="col-md-7">
                                <label class="form-label text-muted fs-11 mb-1">Reviewer 1</label>
                                <input value="{{ $fromtask->rv1 }}" class="form-control bg-white" readonly />
                            </div>
                            <div class="col-md-5">
                                <label class="form-label text-muted fs-11 mb-1">Status</label>
                                <input value="{{ $fromtask->status1 }}" class="form-control bg-white fw-bold text-success" readonly />
                            </div>
                        </div>

                        <!-- Reviewer 2 -->
                        <div class="reviewer-row row align-items-center g-2" id="row_r2">
                            <div class="col-md-7">
                                <label class="form-label text-muted fs-11 mb-1">Reviewer 2</label>
                                <input value="{{ $fromtask->rv2 }}" id="r2" class="form-control bg-white" readonly />
                            </div>
                            <div class="col-md-5">
                                <label class="form-label text-muted fs-11 mb-1">Status</label>
                                <input value="{{ $fromtask->status2 }}" id="s2" class="form-control bg-white fw-bold" readonly />
                            </div>
                        </div>

                        <!-- Reviewer 3 -->
                        <div class="reviewer-row row align-items-center g-2" id="row_r3">
                            <div class="col-md-7">
                                <label class="form-label text-muted fs-11 mb-1">Reviewer 3</label>
                                <input value="{{ $fromtask->rv3 }}" id="r3" class="form-control bg-white" readonly />
                            </div>
                            <div class="col-md-5">
                                <label class="form-label text-muted fs-11 mb-1">Status</label>
                                <input value="{{ $fromtask->status3 }}" id="s3" class="form-control bg-white fw-bold" readonly />
                            </div>
                        </div>

                        <!-- Reviewer 4 -->
                        <div class="reviewer-row row align-items-center g-2" id="row_r4">
                            <div class="col-md-7">
                                <label class="form-label text-muted fs-11 mb-1">Reviewer 4</label>
                                <input value="{{ $fromtask->rv4 }}" id="r4" class="form-control bg-white" readonly />
                            </div>
                            <div class="col-md-5">
                                <label class="form-label text-muted fs-11 mb-1">Status</label>
                                <input value="{{ $fromtask->status4 }}" id="s4" class="form-control bg-white fw-bold" readonly />
                            </div>
                        </div>

                        <!-- Reviewer 5 -->
                        <div class="reviewer-row row align-items-center g-2" id="row_r5">
                            <div class="col-md-7">
                                <label class="form-label text-muted fs-11 mb-1">Reviewer 5</label>
                                <input value="{{ $fromtask->rv5 }}" id="r5" class="form-control bg-white" readonly />
                            </div>
                            <div class="col-md-5">
                                <label class="form-label text-muted fs-11 mb-1">Status</label>
                                <input value="{{ $fromtask->status5 }}" id="s5" class="form-control bg-white fw-bold" readonly />
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Sidebar Obligation Details Card -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header obligation-header py-3 px-4">
                        <i class="ri-wallet-3-line me-2"></i> Obligation Details
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label">Allocated From</label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted fs-11">Fund Source</label>
                            <input class="form-control bg-white" value="{{ $fromtask->fundName }}" readonly>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted fs-11">OBEX / MOOE</label>
                            <input class="form-control bg-white" value="{{ $fromtask->mooeName }}" readonly>
                        </div>

                        <hr class="border-light my-4">

                        <div class="mb-2">
                            <label class="form-label">Obligated Amount</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light fw-bold text-success">₱</span>
                                <input class="form-control bg-white text-end fw-bold fs-16 text-dark" value="{{ number_format($fromtask->obligatedbudget, 2) }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
    const pairs = [
        { row: "row_r2", r: "r2", s: "s2", status: @json($fromtask->status2) },
        { row: "row_r3", r: "r3", s: "s3", status: @json($fromtask->status3) },
        { row: "row_r4", r: "r4", s: "s4", status: @json($fromtask->status4) },
        { row: "row_r5", r: "r5", s: "s5", status: @json($fromtask->status5) },
    ];

    pairs.forEach(item => {
        const row = document.getElementById(item.row);
        const r = document.getElementById(item.r);
        const s = document.getElementById(item.s);
        const status = (item.status ?? "").trim();

        if (!row || !r || !s) return;

        if (status === "Not Applicable" || r.value === "Not Applicable" || r.value === "") {
            row.style.display = "none";
        }
    });
</script>

@endsection