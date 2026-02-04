@extends('components.layout')

@section('content')

<form method="POST" action="{{ route('reports-generate') }}" class="mb-4">
    @csrf

    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">
            <i class="bi bi-funnel-fill me-1"></i> Report Filters
        </div>

        <div class="card-body">
            <div class="row g-3">

                {{-- PAP --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold">PAP</label>
                    <select class="form-select" id="papselect" name="PAP">
                        <option value="">-- Choose PAP --</option>
                        @foreach($mpap as $pap)
                        <option value="{{ $pap->id }}">{{ $pap->pap }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Tasks --}}
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Task</label>
                    <select id="paptask" name="tasks[]" class="form-control" multiple></select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Activity Date</label>
                    <input type="date" class="form-control" name="activitydate">
                </div>

            </div>

            <hr class="my-3">

            {{-- Column Selection --}}
            <div class="row">
                <div class="col-md-4">
                    <h6 class="fw-bold">Basic Info</h6>
                    @foreach(['PAP','task','assigned','preparer'] as $col)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="SelectedColumns[]" value="{{ $col }}">
                        <label class="form-check-label">{{ ucfirst($col) }}</label>
                    </div>
                    @endforeach
                </div>

                <div class="col-md-4">
                    <h6 class="fw-bold">Review & Status</h6>
                    @foreach(['reviewer','status','remarks'] as $col)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="SelectedColumns[]" value="{{ $col }}">
                        <label class="form-check-label">{{ ucfirst($col) }}</label>
                    </div>
                    @endforeach
                </div>

                <div class="col-md-4">
                    <h6 class="fw-bold">Financial</h6>
                    @foreach(['budget','costing','remaining'] as $col)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="SelectedColumns[]" value="{{ $col }}">
                        <label class="form-check-label">{{ ucfirst($col) }}</label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card-footer text-end">
            <button type="submit" class="btn btn-secondary btn-label waves-effect waves-light rounded-pill mb-4" data-bs-toggle="modal" data-bs-target="#reportModal">
                <i class="ri-file-list-line label-icon align-middle rounded-pill fs-16 me-2"></i> Generate Report
            </button>

        </div>
    </div>
</form>


@if(count($reportData))
<div class="modal fade" id="reportModal" tabindex="-1" aria-hidden="true" >
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content" id="report-printable">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Generated Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" >
                <div class="table-responsive" >
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                @foreach($displayColumns as $col)
                                <th>{{ strtoupper($col) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reportData as $row)
                            <tr>
                                @foreach($displayColumns as $col)
                                <td>{{ $row->$col ?? '-' }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary btn-label waves-effect waves-light rounded-pill mb-4" onclick="window.print()">
                <i class="ri-printer-fill label-icon align-middle rounded-pill fs-16 me-2"></i> Print Report
                </button>
                
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myModal = new bootstrap.Modal(document.getElementById('reportModal'));
        myModal.show();
    });

</script>
@endif


@endsection

<style>
    @media print {

      

        body * {
            visibility: hidden;
        }

        #report-printable,
        #report-printable * {
            visibility: visible;
        }

        #report-printable {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }

        /* Hide buttons or filters when printing */
        button,
        .no-print {
            display: none !important;
        }

        table {
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
    }

</style>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {

        const papSelect = document.getElementById('papselect');
        const taskSelect = document.getElementById('paptask');

        const choices = new Choices(taskSelect, {
            removeItemButton: true
            , placeholderValue: 'Select task(s)'
            , shouldSort: false
        });

        const tasksByPap = @json($cath);

        papSelect.addEventListener('change', () => {
            const papId = papSelect.value;

            choices.clearChoices();

            if (!tasksByPap[papId]) return;

            choices.setChoices(
                tasksByPap[papId].map(task => ({
                    value: task.id
                    , label: task.tasks
                }))
                , 'value'
                , 'label'
                , true
            );
        });
    });

</script>

@endsection
