@extends('components.layout')

@section('content')

<style>
    .board {
        display: flex;
        gap: 20px;
        overflow-x: auto;
    }

    .column {
        flex: 1;
        min-width: 300px;
        background: #f4f6f9;
        padding: 15px;
        border-radius: 12px;
    }

    .column h4 {
        text-align: center;
        margin-bottom: 15px;
    }


    .task-card:hover {

        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }



    .column.drag-over {
        background: #e2e6ea;
    }

</style>

<div class="board">

    <!-- PENDING -->
    <div class="column" data-status="pending">

        <h4>🟡 Pending</h4>

        @foreach ($groupedTasks as $task)
        @if($task->progressScore == 0)
        @include('components.taskcard', ['task' => $task, 'status' => 'pending'])
        @endif
        @endforeach
    </div>

    <!-- ONGOING -->
    <div class="column" data-status="ongoing">
        <h4>🔵 Ongoing</h4>

        @foreach ($groupedTasks as $task)
        @if($task->progressScore > 0 && $task->progressScore < 1) @include('components.taskcard', ['task'=> $task, 'status' => 'ongoing'])
            @endif
            @endforeach
    </div>

    <!-- DONE -->
    <div class="column" data-status="done">
        <h4>🟢 Done</h4>
        <label class="text-muted fs-11">*Tasks that are reviewed this month</label>

        @foreach ($groupedTasks as $task)
        @if($task->progressScore >= 1 && \Carbon\Carbon::parse($task->duedate)->isSameMonth(now()))
        @include('components.taskcard', ['task' => $task, 'status' => 'done'])
        @endif
        @endforeach
        <br>
        <a href="#" class=" mb-2 fs-12" data-bs-toggle="modal" data-bs-target="#allReviewModal">View All Reviewed Tasks</a>
    </div>

</div>

<!-- all review modal -->

<div class="modal fade" id="allReviewModal" tabindex="-1" aria-labelledby="allReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="allReviewModalLabel">All Reviewed Tasks</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


                <div class="card mb-3">
                    <table class="table align-middle table-bordered table-nowrap table-sm" id="taskTable">
                        <thead>
                            <tr class="fs-11">
                                <th>PAP</th>
                                <th>Task</th>
                                <th>Activity Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($groupedTasks as $task)

                            @if($task->progressScore >= 1)
                            <tr class="fs-11">
                                <td>{{ $task->pap }}</td>
                                <td>{{ $task->task }}</td>
                                <td>{{ $task->activitydate }}</td>
                                <td>
                                    <a href="/Task/viewtask/{{$task->id}}" class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>
                                </td>
                            </tr>
                            @endif

                            @endforeach
                        </tbody>
                    </table>

                    <nav>
                        <ul class="pagination justify-content-center" id="pagination"></ul>
                    </nav>
                </div>


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
                li.className = "page-item";

                if (i === currentPage) {
                    li.classList.add("active");
                }

                const a = document.createElement("a");
                a.className = "page-link";
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

    });

</script>

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

        // OPTIONAL: send AJAX to update status in DB
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
