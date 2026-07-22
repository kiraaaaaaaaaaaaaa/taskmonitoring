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

    .form-control, .form-select {
        border-radius: 0.5rem;
        border: 1px solid #ced4da;
        padding: 0.65rem 0.9rem;
        font-size: 0.925rem;
        background-color: #f8f9fa;
        color: #495057;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--bs-accent-green);
        box-shadow: 0 0 0 0.25rem rgba(25, 111, 71, 0.15);
        background-color: #ffffff;
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

    /* Circular Progress Customizer */
    .circular-progress {
        position: relative;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: conic-gradient(var(--bs-golden-yellow) calc(var(--value) * 1%), #e2e8f0 0);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .circular-progress::before {
        content: "";
        position: absolute;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: white;
    }

    /* Stat Cards Styling */
    .stat-card {
        border-left: 4px solid var(--bs-dark-green);
        transition: transform 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-3px);
    }

    /* Table custom headers */
    .table-dark-green {
        background-color: var(--bs-dark-green) !important;
        color: #ffffff !important;
    }
</style>

<div class="container-fluid py-4">

    <!-- Top Metric Cards -->
    <div class="row g-4 mb-4">
        
        <!-- Total Budget Card -->
        <div class="col-md-4">
            <div class="card stat-card shadow-sm border-0 rounded-4">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <p class="fw-bold text-muted mb-1 fs-11 text-uppercase letter-spacing-1">TOTAL BUDGET (FY {{ date('Y') }})</p>
                        <h3 class="fw-bold mb-0 text-dark" style="color: var(--bs-dark-green) !important;">
                            ₱ {{ number_format($totalmooe[0]->grandtotal ?? 0, 2) }}
                        </h3>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="avatar-title rounded-circle fs-3 p-3 text-white shadow-sm" style="background-color: var(--bs-dark-green);">
                            <i class="ri-bank-fill"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overall Utilization Rate Card -->
        <div class="col-md-4">
            @php
                $totalOb = $totalobligation[0]->totalobligation ?? 0;
                $grandTotal = $totalmooe[0]->grandtotal ?? 0;
                $utilRate = ($grandTotal != 0) ? ($totalOb / $grandTotal) * 100 : 0;
            @endphp
            <div class="card stat-card shadow-sm border-0 rounded-4" style="border-left-color: var(--bs-golden-yellow);">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <p class="fw-bold text-muted mb-1 fs-11 text-uppercase letter-spacing-1">OVERALL UTILIZATION RATE</p>
                        <h3 class="fw-bold mb-0 text-dark">
                            {{ number_format($utilRate, 2) }}%
                        </h3>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="circular-progress shadow-sm" style="--value: {{ number_format($utilRate, 2) }}">
                            <span class="position-relative fs-10 fw-bold" style="color: var(--bs-dark-green);">{{ round($utilRate) }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Remaining for Catch-up Card -->
        <div class="col-md-4">
            <div class="card stat-card shadow-sm border-0 rounded-4" style="border-left-color: var(--bs-accent-green);">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <p class="fw-bold text-muted mb-1 fs-11 text-uppercase letter-spacing-1">REMAINING FOR CATCH-UP</p>
                        <h3 class="fw-bold mb-0 text-dark">
                            ₱ {{ number_format($grandTotal - $totalOb, 2) }}
                        </h3>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="avatar-title rounded-circle fs-3 p-3 text-white shadow-sm" style="background-color: var(--bs-accent-green);">
                            <i class="ri-pie-chart-2-fill"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Main Report Table Card -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-transparent d-flex flex-wrap justify-content-between align-items-center py-3 px-4 border-bottom">
            <h5 class="fw-bold mb-0" style="color: var(--bs-dark-green);">
                <i class="ri-file-chart-line me-2"></i> Budget Utilization Report {{ date('Y') }}
            </h5>

            <div class="d-flex gap-2 mt-2 mt-md-0">
                <button type="button" class="btn btn-dark-green btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#allocatemodal">
                    <i class="ri-add-fill align-middle me-1"></i> Allocate Budget
                </button>
                <button type="button" class="btn btn-golden-yellow btn-sm rounded-pill px-3 shadow-sm" onclick="printReport()">
                    <i class="ri-printer-fill align-middle me-1"></i> Print Report
                </button>
            </div>
        </div>

        <div class="card-body p-4">
            <div class="listjs-table" id="report-printable">
                <div class="table-responsive table-card">
                    <table class="table align-middle table-hover table-bordered table-sm mb-0">
                        <thead class="table-dark-green text-uppercase fs-11">
                            <tr>
                                <th class="d-none">ID</th>
                                <th class="py-2 px-3">Program / Sub-Program / OBEX</th>
                                <th class="py-2 px-3 text-end">Approp. Allotment</th>
                                <th class="py-2 px-3 text-end">Adjusted Approp.</th>
                                <th class="py-2 px-3 text-end">Obligation</th>
                                <th class="py-2 px-3 text-end">Total Indicative</th>
                                <th class="py-2 px-3 text-end">Utilization %</th>
                                <th class="py-2 px-3 text-end">Remaining Budget</th>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all">
                        
                            @foreach($program as $programs)
                            @if($programs->FY == now()->year)

                            <tr class="table-light fw-bold fs-11" style="background-color: #f1f5f3 !important;">
                                <td class="d-none">{{$programs->id}}</td>
                                <td class="customer_name py-2 px-3 text-dark" style="color: var(--bs-dark-green) !important;">
                                    <i class="ri-folder-open-line me-1"></i> {{$programs->programname}}
                                </td>
                                
                                @foreach($totalbudgetperprogram as $budgets)
                                    @if($budgets->id === $programs->id)
                                        <td class="text-end py-2 px-3">{{number_format($budgets->total_amount,2)}}</td>
                                    @endif
                                @endforeach

                                <td class="text-end py-2 px-3">--</td>
                                <td class="text-end py-2 px-3">--</td>
                                <td class="text-end py-2 px-3">--</td>

                                @foreach($totalobligationperprogram as $totalobligationperprograms)
                                    @php
                                        $budget = $totalbudgetperprogram->firstWhere('id', $totalobligationperprograms->secID);
                                        $total = $budget->total_amount ?? 0;
                                        $percent = ($total > 0) ? ($totalobligationperprograms->totalobligatedperprogram / $total) * 100 : 0;
                                        $remaining = $total - $totalobligationperprograms->totalobligatedperprogram;
                                    @endphp

                                    @if($totalobligationperprograms->secID === $programs->id)
                                        <td class="text-end py-2 px-3 text-success fw-bold">{{number_format($percent,2)}}%</td>
                                        <td class="text-end py-2 px-3">{{number_format($remaining,2)}}</td>
                                    @endif
                                @endforeach
                            </tr>
                            @endif

                            @foreach($subprogram as $subprograms)
                                @if($subprograms->programID === $programs->id && $subprograms->FY == now()->year)
                                <tr class="table-secondary fs-11 text-muted">
                                    <td class="d-none">{{$subprograms->id}}</td>
                                    <td class="customer_name px-4 py-2 fw-semibold" colspan="7">
                                        <i class="ri-git-branch-line me-1"></i> {{$subprograms->subprogramname}}
                                    </td>
                                </tr>

                                <!-- MOOE SECTION -->
                                <tr class="fs-10">
                                    <td class="customer_name px-4 table-warning p-2 fw-bold text-uppercase" colspan="8">
                                        <i class="ri-funds-line me-1"></i> MOOE Components
                                    </td>
                                </tr>

                                @foreach($mooe as $mooes)
                                    @if($mooes->subprogramID === $subprograms->id && $mooes->type === 0 && $mooes->FY == now()->year)
                                        @php
                                            $budget = $totalbudgetperobex->firstWhere('allocatedbudget', $mooes->mooeID);
                                            $total = $budget->totalbudget ?? 0;
                                            $percent = $mooes->adjustedbudget > 0 ? ($total / $mooes->adjustedbudget) * 100 : 0;
                                            $remaining = $mooes->adjustedbudget - $total;
                                        @endphp

                                        <tr class="fs-11">
                                            <td class="d-none">{{$mooes->mooeID}}</td>
                                            <td class="customer_name px-5 py-2">{{$mooes->mooeName}}</td>
                                            <td class="text-end py-2">{{number_format($mooes->budgetallotment,2)}}</td>
                                            <td class="text-end py-2">
                                                <a href="javascript:void(0);" class="text-decoration-underline fw-semibold" style="color: var(--bs-accent-green);" data-bs-toggle="modal" data-bs-target="#adjustedmodal" data-subprogramname="{{$subprograms->subprogramname}}" data-programname="{{$programs->programname}}" data-mooename="{{$mooes->mooeName}}" data-mooeID="{{$mooes->mooeID}}" data-programID="{{$programs->id}}" data-subprogramID="{{$subprograms->id}}">
                                                    {{$mooes->budgetallotment !== $mooes->adjustedbudget ? number_format($mooes->adjustedbudget,2) : '--'}}
                                                </a>
                                            </td>

                                            @if($budget)
                                                <td class="text-end py-2">
                                                    <a href="javascript:void(0);" class="text-decoration-underline fw-semibold text-dark" data-bs-toggle="modal" data-bs-target="#obligationmodal" data-mooeID="{{$mooes->mooeID}}">
                                                        {{ number_format($total,2) }}
                                                    </a>
                                                </td>
                                                <td class="text-end py-2">--</td>
                                                <td class="text-end text-success fw-bold py-2">{{ number_format($percent,2) }}%</td>
                                                <td class="text-end py-2">{{ number_format($remaining,2) }}</td>
                                            @else
                                                <td class="text-end py-2">--</td>
                                                <td class="text-end py-2">--</td>
                                                <td class="text-end py-2">--</td>
                                                <td class="text-end py-2">--</td>
                                            @endif
                                        </tr>
                                    @endif
                                @endforeach

                                <!-- Total MOOE row -->
                                @foreach($totalmooeperprogram as $totalmooeperprograms)
                                    @if($totalmooeperprograms->subprogramID === $subprograms->id && $totalmooeperprograms->type === 0)
                                        <tr class="fs-11 fw-bold" style="background-color: #fef9e7;">
                                            <td class="d-none"></td>
                                            <td class="customer_name px-4 py-2 text-dark">Total MOOE</td>
                                            <td class="text-end py-2">{{number_format($totalmooeperprograms->grandtotal,2)}}</td>
                                            <td class="text-end py-2">--</td>
                                            @foreach($totalobligationmooeperprogram as $totalobligationmooeperprograms)
                                                @if($totalobligationmooeperprograms->subID === $totalmooeperprograms->subprogramID && $totalobligationmooeperprograms->type === 0)
                                                    <td class="text-end py-2">{{number_format($totalobligationmooeperprograms->totalobligatedperprogram,2)}}</td>
                                                    <td class="text-end py-2">--</td>
                                                    <td class="text-end py-2 text-success">{{number_format($totalobligationmooeperprograms->totalobligatedperprogram / ($totalmooeperprograms->grandtotal > 0 ? $totalmooeperprograms->grandtotal : 1) * 100,2)}}%</td>
                                                    <td class="text-end py-2">{{number_format($totalmooeperprograms->grandtotal - $totalobligationmooeperprograms->totalobligatedperprogram,2)}}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endif
                                @endforeach

                                <!-- CO SECTION -->
                                <tr class="fs-10">
                                    <td class="customer_name px-4 table-warning p-2 fw-bold text-uppercase" colspan="8">
                                        <i class="ri-building-line me-1"></i> Capital Outlay (CO) Components
                                    </td>
                                </tr>

                                @foreach($mooe as $mooes)
                                    @if($mooes->subprogramID === $subprograms->id && $mooes->type === 1)
                                        @php
                                            $budget = $totalbudgetperobex->firstWhere('allocatedbudget', $mooes->mooeID);
                                            $total = $budget->totalbudget ?? 0;
                                            $percent = $mooes->adjustedbudget > 0 ? ($total / $mooes->adjustedbudget) * 100 : 0;
                                            $remaining = $mooes->adjustedbudget - $total;
                                        @endphp

                                        <tr class="fs-11">
                                            <td class="d-none">{{$mooes->mooeID}}</td>
                                            <td class="customer_name px-5 py-2">{{$mooes->mooeName}}</td>
                                            <td class="text-end py-2">{{number_format($mooes->budgetallotment,2)}}</td>
                                            <td class="text-end py-2">
                                                <a href="javascript:void(0);" class="text-decoration-underline fw-semibold" style="color: var(--bs-accent-green);" data-bs-toggle="modal" data-bs-target="#adjustedmodal" data-subprogramname="{{$subprograms->subprogramname}}" data-programname="{{$programs->programname}}" data-mooename="{{$mooes->mooeName}}" data-mooeID="{{$mooes->mooeID}}" data-programID="{{$programs->id}}" data-subprogramID="{{$subprograms->id}}">
                                                    {{$mooes->budgetallotment !== $mooes->adjustedbudget ? number_format($mooes->adjustedbudget,2) : '--'}}
                                                </a>
                                            </td>

                                            @if($budget)
                                                <td class="text-end py-2">
                                                    <a href="javascript:void(0);" class="text-decoration-underline fw-semibold text-dark" data-bs-toggle="modal" data-bs-target="#obligationmodal" data-mooeID="{{$mooes->mooeID}}">
                                                        {{ number_format($total,2) }}
                                                    </a>
                                                </td>
                                                <td class="text-end py-2">--</td>
                                                <td class="text-end text-success fw-bold py-2">{{ number_format($percent,2) }}%</td>
                                                <td class="text-end py-2">{{ number_format($remaining,2) }}</td>
                                            @else
                                                <td class="text-end py-2">--</td>
                                                <td class="text-end py-2">--</td>
                                                <td class="text-end py-2">--</td>
                                                <td class="text-end py-2">--</td>
                                            @endif
                                        </tr>
                                    @endif
                                @endforeach

                                <!-- Total CO row -->
                                @foreach($totalmooeperprogram as $totalmooeperprograms)
                                    @if($totalmooeperprograms->subprogramID === $subprograms->id && $totalmooeperprograms->type === 1)
                                        <tr class="fs-11 fw-bold" style="background-color: #fef9e7;">
                                            <td class="d-none"></td>
                                            <td class="customer_name px-4 py-2 text-dark">Total CO</td>
                                            <td class="text-end py-2">{{number_format($totalmooeperprograms->grandtotal,2)}}</td>
                                            <td class="text-end py-2">--</td>
                                            @foreach($totalobligationmooeperprogram as $totalobligationmooeperprograms)
                                                @if($totalobligationmooeperprograms->subID === $totalmooeperprograms->subprogramID && $totalobligationmooeperprograms->type === 1)
                                                    <td class="text-end py-2">{{number_format($totalobligationmooeperprograms->totalobligatedperprogram,2)}}</td>
                                                    <td class="text-end py-2">--</td>
                                                    <td class="text-end py-2 text-success">{{number_format($totalobligationmooeperprograms->totalobligatedperprogram / ($totalmooeperprograms->grandtotal > 0 ? $totalmooeperprograms->grandtotal : 1) * 100,2)}}%</td>
                                                    <td class="text-end py-2">{{number_format($totalmooeperprograms->grandtotal - $totalobligationmooeperprograms->totalobligatedperprogram,2)}}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endif
                                @endforeach

                                @endif
                            @endforeach
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- =========================
    ADJUSTMENT MODAL
========================= -->
<div class="modal fade" id="adjustedmodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4 shadow">

            <form method="POST" action="{{ route('adjustbudget') }}">
                @csrf

                <div class="modal-header border-bottom px-4 py-3" style="background-color: var(--bs-dark-green); color: #fff;">
                    <h5 class="modal-title fw-bold"><i class="ri-edit-box-line me-2"></i> Adjust Budget Allocation</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4">

                    <!-- Program / Sub-program / OBEX Display -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Program</label>
                            <input id="programID" hidden>
                            <input class="form-control bg-light" id="adjustprogramname" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Sub-program</label>
                            <input id="subprogramID" hidden>
                            <input class="form-control bg-light" id="adjustsubprogramname" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">OBEX</label>
                            <input id="obex" name="toobex" hidden>
                            <input class="form-control bg-light" id="obexname" readonly>
                        </div>
                    </div>

                    <!-- Adjustment Input Fields -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Adjusted Amount</label>
                            <input type="number" step="0.01" name="allocatedbudget" class="form-control" placeholder="0.00" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Fiscal Year</label>
                            <input type="text" name="FY" class="form-control" value="{{ date('Y') }}">
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Reallocation Source Target -->
                    <div class="row g-3 mb-4">
                        <div class="col-12"><label class="fw-bold fs-13 text-dark">Allocate Budget From:</label></div>
                        <div class="col-md-4">
                            <label class="form-label">Program Source</label>
                            <select name="program" id="allocateprograms" class="form-select">
                                <option value="">--Select Program--</option>
                                @foreach($program as $pap)
                                <option value="{{$pap->id}}">{{$pap->programname}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Sub-program Source</label>
                            <select name="subprogram" id="allocatesubprograms" class="form-select">
                                <option value="">--Select Sub-program--</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">OBEX Source</label>
                            <select name="fromobex" id="allocateobexs" class="form-select">
                                <option value="">--Select OBEX--</option>
                            </select>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Adjustment History Section -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0" style="color: var(--bs-dark-green);">Adjustment History</h6>
                        <button type="button" class="btn btn-golden-yellow btn-sm rounded-pill px-3 shadow-sm" onclick="printReportadjsuted()">
                            <i class="ri-printer-fill align-middle me-1"></i> Print History
                        </button>
                    </div>

                    <div class="table-responsive border rounded-3 p-2 bg-light" id="adjustment-print">
                        <table class="table table-sm table-bordered align-middle mb-0 bg-white">
                            <thead class="table-light">
                                <tr class="fs-11">
                                    <th>From Source</th>
                                    <th class="text-end">Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach($adjustmenthistory as $adjust)
                                <tr class="fs-11 adjust-row" data-obex="{{$adjust->toobexID}}">
                                    <td>
                                        {{$adjust->from_program}} - {{$adjust->from_subprogram}} - <span class="fw-semibold text-success">{{$adjust->from_mooe}}</span>
                                    </td>
                                    <td class="text-end fw-bold">{{ number_format($adjust->adjustedamount,2) }}</td>
                                    <td>{{ date('M d, Y', strtotime($adjust->created_at)) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-dark-green rounded-pill px-4">Save Adjustment</button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- =========================
    OBLIGATION PER TASK MODAL
========================= -->
<div class="modal fade" id="obligationmodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom px-4 py-3" style="background-color: var(--bs-dark-green); color: #fff;">
                <h5 class="modal-title fw-bold"><i class="ri-file-list-3-line me-2"></i> Obligation Breakdown per Task</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0" style="color: var(--bs-dark-green);">Obligation Tasks</h6>
                    <button type="button" class="btn btn-golden-yellow btn-sm rounded-pill px-3 shadow-sm" onclick="printReportObligation()">
                        <i class="ri-printer-fill align-middle me-1"></i> Print Breakdown
                    </button>
                </div>

                <div class="table-responsive border rounded-3 p-2 bg-light" id="obligation-print">
                    <table class="table table-sm table-bordered align-middle mb-0 bg-white">
                        <thead class="table-light">
                            <tr class="fs-11">
                                <th>Activity</th>
                                <th>Task</th>
                                <th>OBEX</th>
                                <th class="text-end">Obligated Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all">
                            @foreach($budgetperobex as $adjust)
                            <tr class="fs-11 adjust-row" data-obex="{{$adjust->allocatedbudget}}">
                                <td>{{$adjust->pap}}</td>
                                <td><span class="fw-semibold">{{$adjust->tasks}}</span></td>
                                <td><span class="text-success fw-semibold">{{$adjust->mooeName}}</span></td>
                                <td class="text-end fw-bold">{{ number_format($adjust->obligatedbudget,2) }}</td>
                                <td>{{ date('M d, Y', strtotime($adjust->activitydate)) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- =========================
    ALLOCATE BUDGET MODAL
========================= -->
<form method="post" action="{{route('budget store')}}">
    @csrf
    <div class="modal fade" id="allocatemodal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-bottom px-4 py-3" style="background-color: var(--bs-dark-green); color: #fff;">
                    <h5 class="modal-title fw-bold"><i class="ri-coins-line me-2"></i> Allocate Budget</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Program</label>
                        <select name="program" id="allocateprogram" class="form-select">
                            <option value="">--Select Program--</option>
                            @foreach($program as $pap)
                            <option value="{{$pap->id}}">{{$pap->programname}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sub-program</label>
                        <select name="subprogram" id="allocatesubprogram" class="form-select">
                            <option value="">--Select Sub-program--</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">OBEX</label>
                        <select name="obex" id="allocateobex" class="form-select">
                            <option value="">--Select OBEX--</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Budget Amount</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold text-success">₱</span>
                            <input type="text" name="allocatedbudget" class="form-control" placeholder="Enter Amount" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-dark-green rounded-pill px-4">Save Allocation</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var userModal = document.getElementById("adjustedmodal");
        userModal.addEventListener("show.bs.modal", function(event) {
            var button = event.relatedTarget;
            document.getElementById("obex").value = button.getAttribute("data-mooeID");
            document.getElementById("programID").value = button.getAttribute("data-programID");
            document.getElementById("subprogramID").value = button.getAttribute("data-subprogramID");
            document.getElementById("adjustprogramname").value = button.getAttribute("data-programname");
            document.getElementById("adjustsubprogramname").value = button.getAttribute("data-subprogramname");
            document.getElementById("obexname").value = button.getAttribute("data-mooename");
        });

        const inputprogram = document.getElementById('allocateprogram');
        const inputsubprogram = document.getElementById('allocatesubprogram');
        const inputmooe = document.getElementById('allocateobex');

        const inputprograms = document.getElementById('allocateprograms');
        const inputsubprograms = document.getElementById('allocatesubprograms');
        const inputmooes = document.getElementById('allocateobexs');

        const program = {!! json_encode($program) !!};
        const subprogram = {!! json_encode($subprogram) !!};
        const mooe = {!! json_encode($mooe) !!};

        if(inputprogram) {
            inputprogram.addEventListener('change', function () {
                const programID = this.value;
                inputsubprogram.innerHTML = '<option value="">--Select Subprogram--</option>';
                subprogram.forEach(sub => {
                    if(sub.programID == programID){
                        let option = document.createElement('option');
                        option.value = sub.id;
                        option.textContent = sub.subprogramname;
                        inputsubprogram.appendChild(option);
                    }
                });
                inputmooe.innerHTML = '<option value="">--Select OBEX--</option>';
            });
        }

        if(inputsubprogram) {
            inputsubprogram.addEventListener('change', function () {
                const subprogramID = this.value;
                inputmooe.innerHTML = '<option value="">--Select OBEX--</option>';
                mooe.forEach(ob => {
                    if(ob.subprogramID == subprogramID){
                        let option = document.createElement('option');
                        option.value = ob.mooeID;
                        option.textContent = ob.mooeName;
                        inputmooe.appendChild(option);
                    }
                });
            });
        }

        if(inputprograms) {
            inputprograms.addEventListener('change', function () {
                const programID = this.value;
                inputsubprograms.innerHTML = '<option value="">--Select Subprogram--</option>';
                subprogram.forEach(sub => {
                    if(sub.programID == programID){
                        let option = document.createElement('option');
                        option.value = sub.id;
                        option.textContent = sub.subprogramname;
                        inputsubprograms.appendChild(option);
                    }
                });
                inputmooes.innerHTML = '<option value="">--Select OBEX--</option>';
            });
        }

        if(inputsubprograms) {
            inputsubprograms.addEventListener('change', function () {
                const subprogramID = this.value;
                inputmooes.innerHTML = '<option value="">--Select OBEX--</option>';
                mooe.forEach(ob => {
                    if(ob.subprogramID == subprogramID){
                        let option = document.createElement('option');
                        option.value = ob.mooeID;
                        option.textContent = ob.mooeName;
                        inputmooes.appendChild(option);
                    }
                });
            });
        }

        var adjModal = document.getElementById("adjustedmodal");
        adjModal.addEventListener("show.bs.modal", function(event){
            var button = event.relatedTarget;
            var obexID = button.getAttribute("data-mooeID");
            document.querySelectorAll("#adjustment-print .adjust-row").forEach(row => {
                if(row.dataset.obex == obexID){
                    row.style.display = "";
                }else{
                    row.style.display = "none";
                }
            });
        });

        var obModal = document.getElementById("obligationmodal");
        obModal.addEventListener("show.bs.modal", function(event){
            var button = event.relatedTarget;
            var obexID = button.getAttribute("data-mooeID");
            document.querySelectorAll("#obligation-print .adjust-row").forEach(row => {
                if(row.dataset.obex == obexID){
                    row.style.display = "";
                }else{
                    row.style.display = "none";
                }
            });
        });
    });

    function printReport() {
        const content = document.getElementById('report-printable').innerHTML;
        const printWindow = window.open('', '', 'width=900,height=650');
        printWindow.document.write(`<html><head><title>Budget Utilization Report</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"><style>body { padding: 20px; font-family: sans-serif; } table { width: 100%; border-collapse: collapse; } th, td { border: 1px solid #333; padding: 6px; font-size: 11px; } th { background-color: #0a3622 !important; color: #fff; }</style></head><body><h4 class="mb-4">Budget Utilization Report</h4>${content}</body></html>`);
        printWindow.document.close();
        printWindow.focus();
        setTimeout(() => { printWindow.print(); printWindow.close(); }, 500);
    }

    function printReportadjsuted() {
        const content = document.getElementById('adjustment-print').innerHTML;
        const printWindow = window.open('', '', 'width=900,height=650');
        printWindow.document.write(`<html><head><title>Adjustment History</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"><style>body { padding: 20px; font-family: sans-serif; } table { width: 100%; border-collapse: collapse; } th, td { border: 1px solid #333; padding: 6px; font-size: 11px; }</style></head><body><h4 class="mb-4">Adjustment History</h4>${content}</body></html>`);
        printWindow.document.close();
        printWindow.focus();
        setTimeout(() => { printWindow.print(); printWindow.close(); }, 500);
    }

    function printReportObligation() {
        const content = document.getElementById('obligation-print').innerHTML;
        const printWindow = window.open('', '', 'width=900,height=650');
        printWindow.document.write(`<html><head><title>Obligation per Task</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"><style>body { padding: 20px; font-family: sans-serif; } table { width: 100%; border-collapse: collapse; } th, td { border: 1px solid #333; padding: 6px; font-size: 11px; }</style></head><body><h4 class="mb-4">Obligation per Task</h4>${content}</body></html>`);
        printWindow.document.close();
        printWindow.focus();
        setTimeout(() => { printWindow.print(); printWindow.close(); }, 500);
    }
</script>

@endsection