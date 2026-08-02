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

    /* Container & Board Layout */
    .kanban-wrapper {
        padding: 10px 0 30px 0;
    }

    .board-container {
        overflow-x: auto;
        padding-bottom: 15px;
    }

    .board {
        display: flex;
        gap: 24px;
        min-width: 950px;
    }

    .column {
        flex: 1;
        min-width: 330px;
        background: #ffffff;
        border: 1px solid rgba(10, 54, 34, 0.08);
        padding: 20px;
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1.25rem rgba(10, 54, 34, 0.03);
        transition: all 0.3s ease;
    }

    .column-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f1f3f5;
    }

    .column-title {
        font-weight: 700;
        font-size: 1.05rem;
        color: var(--bs-dark-green);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .column-badge {
        font-size: 0.75rem;
        padding: 5px 12px;
        border-radius: 50rem;
        font-weight: 600;
    }

    /* Column Specific Theme Accents */
    .column-pending .column-badge {
        background-color: var(--bs-golden-yellow-light);
        color: #8c7310;
        border: 1px solid var(--bs-golden-yellow-border);
    }

    .column-ongoing .column-badge {
        background-color: #e8f4fd;
        color: #0d6efd;
        border: 1px solid rgba(13, 110, 253, 0.2);
    }

    .column-done .column-badge {
        background-color: #e8f5e9;
        color: #2e7d32;
        border: 1px solid rgba(46, 125, 50, 0.2);
    }

    .column.drag-over {
        background: #f3f8f5;
        border-color: var(--bs-accent-green);
        box-shadow: 0 0.75rem 2rem rgba(10, 54, 34, 0.08);
    }

    /* Task Card Enhancements */
    .task-card {
        transition: all 0.25s ease;
        border-radius: 0.75rem !important;
        border: 1px solid #edf2f7 !important;
    }

    .task-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.75rem 1.5rem rgba(10, 54, 34, 0.08) !important;
        border-color: rgba(212, 175, 55, 0.4) !important;
    }

    /* Modal Polish */
    .modal-content {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.15);
    }

    .view-all-link {
        color: var(--bs-dark-green);
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: color 0.2s ease;
    }

    .view-all-link:hover {
        color: var(--bs-golden-yellow);
    }

    /* Custom Pagination Styling */
    .pagination .page-item .page-link {
        color: var(--bs-dark-green);
        border-color: #dee2e6;
    }

    .pagination .page-item.active .page-link {
        background-color: var(--bs-dark-green);
        border-color: var(--bs-dark-green);
        color: #ffffff;
    }
</style>

<div class="kanban-wrapper">
    <!-- Page Header Intro -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1" style="color: var(--bs-dark-green) !important;">Task Board</h4>
           
        </div>
    </div>

    <div class="board-container">
        <div class="board">

            <!-- PENDING -->
            <div class="column column-pending" data-status="pending">
                <div class="column-header">
                    <h5 class="column-title">
                        <i class="ri-time-line text-warning"></i> Pending
                    </h5>
                    <span class="column-badge">
                        {{ $groupedTasks->filter(fn($t) => $t->progressScore == 0)->count() }} Tasks
                    </span>
                </div>

                <div class="d-flex flex-column gap-3">
                    @foreach ($groupedTasks as $task)
                        @if($task->progressScore == 0)
                            @include('components.taskcard', ['task' => $task, 'status' => 'pending'])
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- ONGOING -->
            <div class="column column-ongoing" data-status="ongoing">
                <div class="column-header">
                    <h5 class="column-title">
                        <i class="ri-loader-4-line text-primary"></i> Ongoing
                    </h5>
                    <span class="column-badge">
                        {{ $groupedTasks->filter(fn($t) => $t->progressScore > 0 && $t->progressScore < 1)->count() }} Tasks
                    </span>
                </div>

                <div class="d-flex flex-column gap-3">
                    @foreach ($groupedTasks as $task)
                        @if($task->progressScore > 0 && $task->progressScore < 1)
                            @include('components.taskcard', ['task' => $task, 'status' => 'ongoing'])
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- DONE -->
            <div class="column column-done" data-status="done">
                <div class="column-header">
                    <h5 class="column-title">
                        <i class="ri-checkbox-circle-line text-success"></i> Done
                    </h5>
                    <span class="column-badge">
                        {{ $completedtasks->filter(fn($t) => $t->progressScore >= 1 && \Carbon\Carbon::parse($t->duedate)->isSameMonth(now()))->count() }} Tasks
                    </span>
                </div>

                <div class="d-flex flex-column gap-3 mb-3">
                    <label class="text-muted fs-11 mb-1">*Tasks that are reviewed this month</label>

                    @foreach ($completedtasks as $task)
                        @if($task->progressScore >= 1 && \Carbon\Carbon::parse($task->duedate)->isSameMonth(now()))
                            @include('components.taskcard', ['task' => $task, 'status' => 'done'])
                        @endif
                    @endforeach
                </div>

                <div class="pt-3 border-top text-center">
                    <a href="#" class="view-all-link fs-13" data-bs-toggle="modal" data-bs-target="#allReviewModal">
                        <i class="ri-eye-line"></i> View All Reviewed Tasks
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- All Reviewed Modal -->
<div class="modal fade" id="allReviewModal" tabindex="-1" aria-labelledby="allReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="allReviewModalLabel" style="color: var(--bs-dark-green);">All Reviewed Tasks History</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <div class="table-responsive rounded-3 border">
                    <table class="table align-middle table-hover mb-0" id="taskTable">
                        <thead class="table-light fs-11 text-uppercase font-monospace text-muted">
                            <tr>
                                <th class="py-3 px-3">PAP</th>
                                <th class="py-3 px-3">Task</th>
                                <th class="py-3 px-3">Activity Date</th>
                                <th class="py-3 px-3 text-end">Action</th>
                            </tr>
                        </thead>

                        <tbody class="fs-12">
                            @foreach ($completedtasks as $task)
                                @if($task->progressScore >= 1)
                                <tr>
                                    <td class="px-3 fw-medium text-dark">{{ $task->pap }}</td>
                                    <td class="px-3 text-muted">{{ $task->task }}</td>
                                    <td class="px-3 text-nowrap font-monospace text-muted">{{ $task->activitydate }}</td>
                                    <td class="px-3 text-end">
                                        <a href="/Task/viewtask/{{$task->id}}" class="btn btn-sm btn-outline-success rounded-pill px-3 py-1">
                                            View
                                        </a>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <nav class="mt-4">
                    <ul class="pagination justify-content-center mb-0" id="pagination"></ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const rowsPerPage = 10;
        const table = document.getElementById("taskTable");
        const rows = table.querySelectorAll("tbody tr");
        const pagination = document.getElementById("pagination");

        if (rows.length > 0) {
            let currentPage = 1;
            const totalPages = Math.ceil(rows.length / rowsPerPage);

            function displayRows(page) {
                rows.forEach((row, index) => {
                    row.style.display =
                        (index >= (page - 1) * rowsPerPage &&
                            index < page * rowsPerPage) ?
                    "" :
                    "none";
                });
            }

            function setupPagination() {
                pagination.innerHTML = "";
                for (let i = 1; i <= totalPages; i++) {
                    const li = document.createElement("li");
                    li.className = `page-item ${i === currentPage ? 'active' : ''}`;

                    const a = document.createElement("a");
                    a.className = "page-link shadow-none";
                    a.href = "#";
                    a.innerText = i;

                    a.addEventListener("click", function(e) {
                        e.preventDefault();
                        currentPage = i;
                        displayRows(currentPage);
                        setupPagination();
                    });

                    li.appendChild(a);
                    pagination.appendChild(li);
                }
            }

            displayRows(currentPage);
            setupPagination();
        }
    });
</script>

{{-- Drag and drop script retained for future integration if needed --}}
{{-- <script>
document.querySelectorAll('.task-card').forEach(card => {
    card.addEventListener('dragstart', function(e) {
        e.dataTransfer.setData('text/plain', card.dataset.id);
        setTimeout(() => card.style.display = 'none', 0);
    });

    card.addEventListener('dragend', function() {
        card.style.display = 'block';
    });
});

document.querySelectorAll('.column').forEach(column => {
    column.addEventListener('dragover', function(e) {
        e.preventDefault();
        column.classList.add('drag-over');
    });

    column.addEventListener('dragleave', function() {
        column.classList.remove('drag-over');
    });

    column.addEventListener('drop', function(e) {
        e.preventDefault();
        const id = e.dataTransfer.getData('text/plain');
        const card = document.querySelector(`[data-id='${id}']`);
        column.appendChild(card);
        column.classList.remove('drag-over');

        fetch(`/task/update-status/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                status: column.dataset.status
            })
        });
    });
});
</script> --}}

@endsection