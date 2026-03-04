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

        @foreach ($groupedTasks as $task)
        @if($task->progressScore >= 1)
        @include('components.taskcard', ['task' => $task, 'status' => 'done'])
        @endif
        @endforeach
    </div>

</div>


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
