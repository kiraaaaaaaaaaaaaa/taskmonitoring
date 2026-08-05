<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Task Assignment</title>
</head>
<body>

<h2>New Task Assignment</h2>

<p>Hello,</p>

<p>You have been assigned a new task.</p>

<table>
    <tr>
        <td><strong>PAP:</strong></td>
        <td>{{ $task['paps'] }}</td>
    </tr>

    <tr>
        <td><strong>Task:</strong></td>
        <td>{{ $task['task'] }}</td>
    </tr>

    <tr>
        <td><strong>Target Date of Completion:</strong></td>
        <td>{{ $task['duedate'] }}</td>
    </tr>

    
</table>

<p>Please log in to the BRO Task Monitoring System to review your assignment.</p>
<p>https://task.mfbmbro.cloud/</p>

</body>
</html>