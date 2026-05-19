@extends('components.layout')

@section('content')

<style>
.circular-progress{
    position: relative;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: conic-gradient(#0d6efd calc(var(--value) * 1%), #aec6de 0);
    display: flex;
    align-items: center;
    justify-content: center;
}

.circular-progress::before{
    content: "";
    position: absolute;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: white;
}

.progress-value{
    position: relative;
    font-size: 18px;
    font-weight: 600;
    color: #0d6efd;
}
</style>

<div class="row g-3">

<div class="col-md-4">
        <div class="card card-animate">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <p class="fw-medium text-muted mb-0 fs-11">TOTAL BUDGET FOR (FY {{ date('Y') }})</p>
                    <h2 class="mt-4 ff-secondary fw-semibold">
                        {{number_format($totalmooe[0]->grandtotal,2)}}
                    </h2>
                   
                </div>
                <div class="avatar-sm flex-shrink-0">
                    <span class="avatar-title bg-secondary rounded-circle fs-2">
                        <i class="ri-bank-fill"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

<div class="col-md-4">
        <div class="card card-animate">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <p class="fw-medium text-muted mb-0 fs-11">OVERALL UTILIZATION RATE</p>
                    <h2 class="mt-4 ff-secondary fw-semibold">
                        @if(!empty($totalobligation[0]->totalobligation) && !empty($totalmooe[0]->grandtotal) && $totalmooe[0]->grandtotal != 0)
                            {{ number_format(($totalobligation[0]->totalobligation / $totalmooe[0]->grandtotal) * 100, 2) }} %
                        @else
                            0 %
                        @endif
                                
                    </h2>
          
                    
                </div>
                <div class="avatar-sm flex-shrink-0">
                    <span class="avatar-title bg-secondary rounded-circle fs-2">
                        <div class="d-flex justify-content-center">
                            @if(!empty($totalobligation[0]->totalobligation) && !empty($totalmooe[0]->grandtotal) && $totalmooe[0]->grandtotal != 0)
                            {
                            <div class="circular-progress" style="--value:{{number_format($totalobligation[0]->totalobligation/$totalmooe[0]->grandtotal*100,2)}}">
                               
                            </div>
                            }

                            @endif

                        </div>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-animate">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <p class="fw-medium fs-11 text-muted mb-0">REMAINING FOR CATCH-UP</p>
                    <h2 class="mt-4 ff-secondary fw-semibold">
                       {{number_format($totalmooe[0]->grandtotal-$totalobligation[0]->totalobligation,2)}}
                    </h2>
                   
                </div>
                <div class="avatar-sm flex-shrink-0">
                    <span class="avatar-title bg-secondary rounded-circle fs-2">
                        <i class="ri-bank-fill"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

</div>



<div class="cols">

    <div class="card border">
        <div class="card-header d-flex justify-content-between align-items-center">

            <h6 class="card-title mb-0 fs-6">
                Budget Utilization Report {{ date('Y') }}
            </h6>

            <div>

            <button type="button" class="btn btn-success btn-sm btn-label waves-effect waves-light rounded-pill" data-bs-toggle="modal" data-bs-target="#allocatemodal">

                <i class="ri-add-fill label-icon align-middle rounded-pill fs-16 me-2"></i>
                Allocate Budget
            </button>
             <button type="button" class="btn btn-primary btn-sm btn-label waves-effect waves-light rounded-pill" onclick="printReport()">

                <i class="ri-printer-fill label-icon align-middle rounded-pill fs-16 me-2"></i>
                Print Report
            </button>
            </div>

        </div>


        <div class="card-body">
            <div class="listjs-table"  id="report-printable">

                <div class="table-responsive table-card mt-3 mb-1">
                    <table class="table align-middle table-bordered table-nowrap table-sm">
                        <thead class="table-dark">
                            <tr class=" fs-11">
                                <th class="d-none">ID</th>
                                <th class="">PROGRAM/SUB-PROGRAM/OBEX</th>
                                <th class="">APPROP. ALLOTMENT</th>
                                <th class="">ADJUSTED APPROP.</th>
                                <th class="">OBLIGATION</th>
                                <th class="">TOTAL INDICATIVE</th>
                                <th class="">UTILIZATION %</th>
                                <th class="">REMAINING BUDGET</th>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all">
                        
                            @foreach($program as $programs)
                            @if($programs->FY == now()->year)
                           

                            {{--@php
                                $percent = round( (float) $users->total / $users->allocatedbudget * 100);

                                $prog = $percent >= 80
                                ? 'bg-success'
                                : ($percent >= 50 ? 'bg-warning' : 'bg-danger');

                                $progs = $percent >= 80
                                ? 'excellent'
                                : ($percent >= 50 ? 'average' : 'poor');
                                @endphp --}}

                            <tr class="table-primary fs-11">
                                <td class="d-none">{{$programs->id}}</td>
                                <td class="customer_name">{{$programs->programname}}</td>
                                @foreach($totalbudgetperprogram as $budgets)
                                @if($budgets->id === $programs->id)
                                <td class="text-end">{{number_format($budgets->total_amount,2)}}</td>
                                @endif
                                @endforeach

                                <td class="text-end">--</td>
                                <td class="text-end">--</td>

                                <td class="text-end">--</td>
                                @foreach($totalobligationperprogram as $totalobligationperprograms)
                                    @php
                                    $budget = $totalbudgetperprogram->firstWhere('id', $totalobligationperprograms->secID);

                                    $total = $budget->total_amount ?? 0;
                                    $percent = ($totalobligationperprograms->totalobligatedperprogram / $total) * 100;
                                    $remaining = $total - $totalobligationperprograms->totalobligatedperprogram;
                                    @endphp

                                    @if($totalobligationperprograms->secID === $programs->id)
                                        <td class="text-end">{{number_format($percent,2)}} % </td>
                                        <td class="text-end">{{number_format($remaining,2)}} </td>
                                    
                                    @endif
                                    
                                @endforeach
                                
                                
                               



                            </tr>
                            @endif
                          
                           
                            @foreach($subprogram as $subprograms)

                            @if($subprograms->programID === $programs->id && $subprograms->FY == now()->year)
                            <tr class="table-secondary fs-11 ">
                                <td class="d-none">{{$subprograms->id}}</td>
                                <td class="customer_name px-4">{{$subprograms->subprogramname}}</td>
                                <td class="text-end">--</td>
                                <td class="text-end">--</td>
                                <td class="text-end">--</td>
                                <td class="text-end">--</td>
                                <td class="text-end">--</td>
                                <td class="text-end">--</td>


                            </tr>

                            <tr class=" fs-10 ">
                               
                                <td class="customer_name px-4 table-warning p-0">MOOE</td>
                                <td class="text-end"></td>
                                <td class="text-end"></td>
                                <td class="text-end"></td>
                                <td class="text-end"></td>
                                <td class="text-end"></td>
                                <td class="text-end"></td>


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
                                <td class="customer_name px-5">{{$mooes->mooeName}}</td>
                                <td class="text-end">{{number_format($mooes->budgetallotment,2)}}</td>
                                <td class="text-end">
                                    @if($mooes->budgetallotment !== $mooes->adjustedbudget)
                                    <a href="" data-bs-toggle="modal" data-bs-target="#adjustedmodal" data-subprogramname="{{$subprograms->subprogramname}}" data-programname="{{$programs->programname}}" data-mooename="{{$mooes->mooeName}}" data-mooeID="{{$mooes->mooeID}}" data-programID="{{$programs->id}}" data-subprogramID="{{$subprograms->id}}">

                                        {{number_format($mooes->adjustedbudget,2)}}
                                    </a>
                                    @else
                                    <a href="" data-bs-toggle="modal" data-bs-target="#adjustedmodal" data-subprogramname="{{$subprograms->subprogramname}}" data-programname="{{$programs->programname}}" data-mooename="{{$mooes->mooeName}}" data-mooeID="{{$mooes->mooeID}}" data-programID="{{$programs->id}}" data-subprogramID="{{$subprograms->id}}">
                                        --
                                    </a>
                                    @endif
                                    
                                @if($budget)

                                <td class="text-end">
                                    <a href=" "data-bs-toggle="modal" data-bs-target="#obligationmodal" data-mooeID="{{$mooes->mooeID}}">
                                        {{ number_format($total,2) }}
                                    </a>
                                </td>

                                <td class="text-end">--</td>

                                <td class="text-end text-success">
                                    {{ number_format($percent,2) }}%
                                </td>

                                <td class="text-end">
                                    {{ number_format($remaining,2) }}
                                </td>

                                @else

                                <td class="text-end">--</td>
                                <td class="text-end">--</td>
                                <td class="text-end">--</td>
                                <td class="text-end">--</td>

                                @endif

                            </tr>

                            

                            
                            @endif

                            {{-- end of mooe   --}}@endforeach

                            @foreach($totalmooeperprogram as $totalmooeperprograms)
                                @if($totalmooeperprograms->subprogramID === $subprograms->id && $totalmooeperprograms->type === 0)
                                    
                               
                             <tr class="table-danger fs-11">
                                <td class="d-none p-0"></td>
                                <td class="customer_name p-1">Total MOOE</td>
                                <td class="text-end p-0">{{number_format($totalmooeperprograms->grandtotal,2)}}</td>
                                <td class="text-end p-0"></td>
                                @foreach($totalobligationmooeperprogram as $totalobligationmooeperprograms)
                                    @if($totalobligationmooeperprograms->subID === $totalmooeperprograms->subprogramID && $totalobligationmooeperprograms->type === 0)
                                        <td class="text-end p-0"> {{number_format($totalobligationmooeperprograms->totalobligatedperprogram,2)}}</td>
                                    <td class="text-end p-0"> </td>
                                    <td class="text-end p-0">{{number_format($totalobligationmooeperprograms->totalobligatedperprogram / $totalmooeperprograms->grandtotal * 100,2)}} %</td>
                                    <td class="text-end p-0">{{number_format($totalmooeperprograms->grandtotal - $totalobligationmooeperprograms->totalobligatedperprogram,2)}} </td>
                                    @endif
                                    
                                @endforeach
                               
                                    
                                
                                    
                            
                             
                            </tr>
                             @endif
                            @endforeach

                             <tr class=" fs-10 ">
                               
                                <td class="customer_name px-4 table-warning p-0">CO</td>
                                <td class="text-end"></td>
                                <td class="text-end"></td>
                                <td class="text-end"></td>
                                <td class="text-end"></td>
                                <td class="text-end"></td>
                                <td class="text-end"></td>


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
                                <td class="customer_name px-5">{{$mooes->mooeName}}</td>
                                <td class="text-end">{{number_format($mooes->budgetallotment,2)}}</td>
                                <td class="text-end">
                                    @if($mooes->budgetallotment !== $mooes->adjustedbudget)
                                    <a href="" data-bs-toggle="modal" data-bs-target="#adjustedmodal" data-subprogramname="{{$subprograms->subprogramname}}" data-programname="{{$programs->programname}}" data-mooename="{{$mooes->mooeName}}" data-mooeID="{{$mooes->mooeID}}" data-programID="{{$programs->id}}" data-subprogramID="{{$subprograms->id}}">

                                        {{number_format($mooes->adjustedbudget,2)}}
                                    </a>
                                    @else
                                    <a href="" data-bs-toggle="modal" data-bs-target="#adjustedmodal" data-subprogramname="{{$subprograms->subprogramname}}" data-programname="{{$programs->programname}}" data-mooename="{{$mooes->mooeName}}" data-mooeID="{{$mooes->mooeID}}" data-programID="{{$programs->id}}" data-subprogramID="{{$subprograms->id}}">
                                        --
                                    </a>
                                    @endif
                                    
                                @if($budget)

                                <td class="text-end">
                                    <a href=" "data-bs-toggle="modal" data-bs-target="#obligationmodal" data-mooeID="{{$mooes->mooeID}}">
                                        {{ number_format($total,2) }}
                                    </a>
                                </td>

                                <td class="text-end">--</td>

                                <td class="text-end text-success">
                                    {{ number_format($percent,2) }}%
                                </td>

                                <td class="text-end">
                                    {{ number_format($remaining,2) }}
                                </td>

                                @else

                                <td class="text-end">--</td>
                                <td class="text-end">--</td>
                                <td class="text-end">--</td>
                                <td class="text-end">--</td>

                                @endif

                            </tr>

                            
                            @endif

                            {{-- end of co   --}}@endforeach

                             @foreach($totalmooeperprogram as $totalmooeperprograms)
                                @if($totalmooeperprograms->subprogramID === $subprograms->id && $totalmooeperprograms->type === 1)
                                    
                               
                             <tr class="table-danger fs-11">
                                <td class="d-none p-0"></td>
                                <td class="customer_name p-1">Total CO</td>
                                <td class="text-end p-0">{{number_format($totalmooeperprograms->grandtotal,2)}}</td>
                                <td class="text-end p-0"></td>
                                @foreach($totalobligationmooeperprogram as $totalobligationmooeperprograms)
                                    @if($totalobligationmooeperprograms->subID === $totalmooeperprograms->subprogramID && $totalobligationmooeperprograms->type === 1)
                                        <td class="text-end p-0"> {{number_format($totalobligationmooeperprograms->totalobligatedperprogram,2)}}</td>
                                    <td class="text-end p-0"> </td>
                                    <td class="text-end p-0">{{number_format($totalobligationmooeperprograms->totalobligatedperprogram / $totalmooeperprograms->grandtotal * 100,2)}} %</td>
                                    <td class="text-end p-0">{{number_format($totalmooeperprograms->grandtotal - $totalobligationmooeperprograms->totalobligatedperprogram,2)}} </td>
                                    @endif
                                    
                                @endforeach
                            @endif
                            @endforeach


                            @endif
                           
                            
                            
                            {{-- end of subprograms   --}}@endforeach

                            {{-- end of programs   --}} @endforeach

                           

                        

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- =========================
    ADJUSTMENT MODAL
========================= --}}
<div class="modal fade" id="adjustedmodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <form method="POST" action="{{ route('adjustbudget') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Adjust Budget</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    {{-- PROGRAM / SUBPROGRAM / OBEX --}}
                    <div class="row g-3 mb-3">

                        <div class="col-md-4">
                            <label class="form-label">Program</label>
                            <input id="programID" hidden>
                            <input class="form-control" id="adjustprogramname" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Sub-program</label>
                            <input id="subprogramID" hidden>
                            <input class="form-control" id="adjustsubprogramname" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">OBEX</label>
                            <input id="obex" name="toobex" hidden>
                            <input class="form-control" id="obexname" readonly>
                        </div>

                    </div>


                    {{-- ADJUSTMENT INPUT --}}
                    <div class="row g-3 mb-3">

                        <div class="col-md-6">
                            <label class="form-label">Adjusted Amount</label>
                            <input type="number" step="0.01" name="allocatedbudget" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Fiscal Year</label>
                            <input type="text" name="FY" class="form-control" value="{{ date('Y') }}">
                        </div>

                    </div>

                    <hr>

                    {{-- REALLOCATION TARGET --}}
                    <div class="row g-3 mb-3">
                        <label>Allocate the Budget from</label>
                        <div class="col-md-4">
                            <label class="form-label">Program</label>
                            <select name="program" id="allocateprograms" class="form-control">

                                <option value="">--Select Program--</option>

                                @foreach($program as $pap)
                                <option value="{{$pap->id}}">
                                    {{$pap->programname}}
                                </option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Sub-program</label>
                            <select name="subprogram" id="allocatesubprograms" class="form-control">
                                <option value="">--Select Sub-program--</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">OBEX</label>
                            <select name="obex" id="allocateobexs" class="form-control">
                                <option value="">--Select OBEX--</option>
                            </select>
                        </div>

                    </div>


                    <hr>

                    {{-- ======================
    ADJUSTMENT HISTORY
====================== --}}
                    <div class="d-flex justify-content-between align-items-center">

                    <h6 class="fw-bold mb-3">Adjustment History</h6>
                    <button type="button" class="btn btn-primary btn-sm btn-label waves-effect waves-light rounded-pill" onclick="printReportadjsuted()">

                    <i class="ri-printer-fill label-icon align-middle rounded-pill fs-16 me-2"></i>
                    Print
                    </button>
                    
                    </div>
                    <br>

                    <div class="table-responsive" id="adjustment-print">

                        <table class="table table-sm table-bordered align-middle">

                            <thead class="table-light">
                                <tr class="fs-11">
                                   
                                    <th>From</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>

                            <tbody class="list form-check-all">

                                @foreach($adjustmenthistory as $adjust)

                                <tr class="fs-11 adjust-row" data-obex="{{$adjust->toobexID}}">

                                    <td>
                                        {{$adjust->from_program}}
                                        -
                                        {{$adjust->from_subprogram}}
                                        -
                                        <span class="text-primary">{{$adjust->from_mooe}}</span>
                                    </td>

                                    

                                    <td class="text-end">
                                        {{ number_format($adjust->adjustedamount,2) }}
                                    </td>

                                    <td>
                                        {{ date('M d, Y', strtotime($adjust->created_at)) }}
                                    </td>

                                </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>


                </div>


                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary px-4">
                        Save Adjustment
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
{{-- ======OBLIGATION per task MODAL ====== --}}
<div class="modal fade" id="obligationmodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body">
            <div class="d-flex justify-content-between align-items-center">

                    <h6 class="fw-bold mb-3">Obligation per Task</h6>
                    <button type="button" class="btn btn-primary btn-sm btn-label waves-effect waves-light rounded-pill" onclick="printReportObligation()">

                    <i class="ri-printer-fill label-icon align-middle rounded-pill fs-16 me-2"></i>
                    Print
                    </button>
                    
            </div>
                    <br>

                    <div class="table-responsive" id="obligation-print">

                        <table class="table table-sm table-bordered align-middle">

                            <thead class="table-light">
                                <tr class="fs-11">
                                   
                                    <th>Activity</th>
                                    <th>Task</th>
                                    <th>OBEX</th>
                                    <th>Obligated Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>

                            <tbody class="list form-check-all">

                                @foreach($budgetperobex as $adjust)

                                <tr class="fs-11 adjust-row" data-obex="{{$adjust->allocatedbudget}}">

                                    <td>
                                        {{$adjust->pap}}
                                        
                                    </td>
                                    <td><span >{{$adjust->tasks}}</span></td>
                                    <td><span class="text-primary">{{$adjust->mooeName}}</span></td>

                                    <td class="text-end">
                                        {{ number_format($adjust->obligatedbudget,2) }}
                                    </td>

                                    <td>
                                        {{ date('M d, Y', strtotime($adjust->activitydate)) }}
                                    </td>

                                </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>


                </div>
            </div>

        </div>
    </div>
</div>


<form method="post" action="{{route('budget store')}}">
    @csrf
    <div class="modal fade" id="allocatemodal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-scrollable">
            <div class="modal-content">
                <div class="col">
                    <div class="card border">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Allocate Budget</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="card-body">
                            <form action="">
                                <div class="mb-3">
                                    <label for="employeeName" class="form-label">Program</label>
                                    <select name="program" id="allocateprogram" class="form-control">
                                        <option>--Select Program--</option>
                                        @foreach($program as $pap)
                                        <option value={{$pap->id}}>{{$pap->programname}}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="employeeName" class="form-label">Sub-program</label>
                                    <input type="hidden" value>
                                    <select name="subprogram" id="allocatesubprogram" class="form-control" readonly>
                                        <option>--Select Sub-program--</option>


                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="employeeName" class="form-label">OBEX</label>
                                    <select name="obex" id="allocateobex" class="form-control">
                                        <option>--Select OBEX--</option>

                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="employeeUrl" class="form-label">Budget</label>
                                    <input type="text" name="allocatedbudget" class="form-control" id="employeeUrl" placeholder="Enter Amount">
                                </div>
                                

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>



{{-- <form method="post" action="{{route('budget store')}}">
@csrf
<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">Manage Budget</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>


            <div class="modal-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="mb-3" id="modal-id" style="display: none;">
                    <label for="id-field" class="form-label">ID</label>
                    <input type="text" id="id-field" name="id" class="form-control" placeholder="ID" readonly="">
                </div>

                <div class="mb-3">
                    <label for="customername-field" class="form-label">PAP</label>
                    <input type="text" id="pap-field" name="pap" class="form-control" readonly>

                </div>

                <div class="mb-3">
                    <label for="phone-field" class="form-label">Bugdet</label>
                    <input type="text" id="budget-field" name="budget" class="form-control" placeholder="Enter Budget." required="">
                    <div class="invalid-feedback">Please enter a budget.</div>
                </div>


                <div class="modal-footer" style="display: block;">
                    <div class="hstack gap-2 justify-content-end">

                        <button type="submit" class="btn btn-success">Save</button>

                    </div>
                </div>

            </div>
        </div>
    </div>

    </form> --}}
<script>
        document.addEventListener("DOMContentLoaded", function() {

            var userModal = document.getElementById("adjustedmodal");

            userModal.addEventListener("show.bs.modal", function(event) {

                var button = event.relatedTarget;

                document.getElementById("obex").value =
                    button.getAttribute("data-mooeID");
                document.getElementById("programID").value =
                    button.getAttribute("data-programID");
                document.getElementById("subprogramID").value =
                    button.getAttribute("data-subprogramID");
                document.getElementById("adjustprogramname").value =
                    button.getAttribute("data-programname");
                    document.getElementById("adjustsubprogramname").value =
                    button.getAttribute("data-subprogramname");
                    document.getElementById("obexname").value =
                    button.getAttribute("data-mooename");

                
                // Password intentionally left blank for security

            });

        });

    document.addEventListener('DOMContentLoaded', () => {

    const inputprogram = document.getElementById('allocateprogram');
    const inputsubprogram = document.getElementById('allocatesubprogram');
    const inputmooe = document.getElementById('allocateobex');

    const inputprograms = document.getElementById('allocateprograms');
    const inputsubprograms = document.getElementById('allocatesubprograms');
    const inputmooes = document.getElementById('allocateobexs');

    const program = {!! json_encode($program) !!};
    const subprogram = {!! json_encode($subprogram) !!};
    const mooe = {!! json_encode($mooe) !!};


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

    var modal = document.getElementById("adjustedmodal");

modal.addEventListener("show.bs.modal", function(event){

    var button = event.relatedTarget;

    var obexID = button.getAttribute("data-mooeID");

    document.getElementById("obex").value = obexID;

    document.querySelectorAll(".adjust-row").forEach(row => {

        if(row.dataset.obex == obexID){
            row.style.display = "";
        }else{
            row.style.display = "none";
        }

    });

        });

var modal = document.getElementById("obligationmodal");

modal.addEventListener("show.bs.modal", function(event){

    var button = event.relatedTarget;

    var obexID = button.getAttribute("data-mooeID");

    document.getElementById("obex").value = obexID;

    document.querySelectorAll(".adjust-row").forEach(row => {

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

    printWindow.document.write(`
        <html>
        <head>
            <title>Print Report</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body { padding: 4px; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #000; padding: 4px; }
                th { background-color: #f2f2f2; }
            </style>
        </head>
        <body>
            ${content}
        </body>
        </html>
    `);

    printWindow.document.close();
    printWindow.focus();

    setTimeout(() => {
        printWindow.print();
        printWindow.close();
    }, 500);
}
function printReportadjsuted() {
    const content = document.getElementById('adjustment-print').innerHTML;

    const printWindow = window.open('', '', 'width=900,height=650');

    printWindow.document.write(`
        <html>
        <head>
            <title>Print Report</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body { padding: 4px; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #000; padding: 4px; }
                th { background-color: #f2f2f2; }
            </style>
        </head>
        <body>
            ${content}
        </body>
        </html>
    `);

    printWindow.document.close();
    printWindow.focus();

    setTimeout(() => {
        printWindow.print();
        printWindow.close();
    }, 500);
}

function printReportObligation() {
    const content = document.getElementById('obligation-print').innerHTML;

    const printWindow = window.open('', '', 'width=900,height=650');

    printWindow.document.write(`
        <html>
        <head>
            <title>Print Report</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body { padding: 4px; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #000; padding: 4px; }
                th { background-color: #f2f2f2; }
            </style>
        </head>
        <body>
            ${content}
        </body>
        </html>
    `);

    printWindow.document.close();
    printWindow.focus();

    setTimeout(() => {
        printWindow.print();
        printWindow.close();
    }, 500);
}

</script>


 @endsection
