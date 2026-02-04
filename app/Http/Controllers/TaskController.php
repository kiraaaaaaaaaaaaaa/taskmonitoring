<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Paps;
use App\Models\paptask;
use App\Models\Budget;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($date = null, $papM = null)
    {
        $fromtask = Task::all();

        $tasks = DB::table('tasks')
            ->join('paps', 'tasks.PAP', '=', 'paps.id')
            ->join('paptask', 'tasks.task', '=', 'paptask.id')
            ->join('users as PREPARER', 'tasks.preparer', '=', 'PREPARER.id')
            ->join('users as ASSIGNED', 'tasks.assigned', '=', 'ASSIGNED.id')
            ->whereDate('tasks.activitydate', $date)
            ->where('tasks.PAP', $papM)
            ->select('tasks.*', 'paps.pap', 'paptask.tasks', 'PREPARER.name as Preparer', 'ASSIGNED.name as Assigned')
            ->get();

        return view('Task.task', ["fromtask" => $tasks]);
    }

    public function papforthemonth() {}

    public function forpap($year = null, $month = null)
    {
        $now = Carbon::now();

        $Year = ($year && $year > 0) ? $year : $now->year;
        $Month = ($month && $month >= 1 && $month <= 12) ? $month : $now->month;

        $tasks = DB::table('tasks')
            ->join('paps', 'tasks.PAP', '=', 'paps.id')
            ->whereNotNull('tasks.activitydate')
            ->whereYear('tasks.activitydate', $Year)
            ->whereMonth('tasks.activitydate', $Month)
            ->select(
                'paps.pap',
                'tasks.PAP',
                DB::raw('MIN(tasks.activitydate) as first_activity'),
                DB::raw('AVG(tasks.progressScore) as average_progress')
            )
            ->groupBy('tasks.PAP', 'tasks.activitydate')
            ->get();


        return view('Task.pap', compact('tasks', 'Year', 'Month'));
    }


    // view for creating task page
    public function create()
    {
        $paps = Paps::all();
        $users = User::all();
        $paptask = PapTask::all();

        $tasksByPap = $paptask
            ->groupBy('papID')
            ->map(function ($tasks) {
                return $tasks->map(function ($task) {
                    return [
                        'id' => $task->id,
                        'tasks' => $task->tasks
                    ];
                });
            });

        return view('/Task.createtask', compact(
            'paps',
            'users',
            'paptask',
            'tasksByPap'
        ));
    }

    // for creating new PAP
    public function createPAP(Request $request)
    {

        if ($request->action === 'pap') {

            Paps::create([
                'pap' => $request->pap
            ]);
        }

        if ($request->action === 'task') {
            paptask::create([
                'papID' => $request->PAP,
                'tasks' => $request->task
            ]);
        }



        return back()->with('success', 'Saved successfully');
    }

    // viewing of individual task
    public function viewTask($id)
    {
        $tasks = DB::table('tasks')
            ->join('paps', 'tasks.PAP', '=', 'paps.id')
            ->join('paptask', 'tasks.task', '=', 'paptask.id')
            ->join('users as PREPARER', 'tasks.preparer', '=', 'PREPARER.id')
            ->join('users as ASSIGNED', 'tasks.assigned', '=', 'ASSIGNED.id')
            ->leftJoin('users as r1', 'tasks.reviewer1', '=', 'r1.id')
            ->leftJoin('users as r2', 'tasks.reviewer2', '=', 'r2.id')
            ->leftJoin('users as r3', 'tasks.reviewer3', '=', 'r3.id')
            ->leftJoin('users as r4', 'tasks.reviewer4', '=', 'r4.id')
            ->leftJoin('users as r5', 'tasks.reviewer5', '=', 'r5.id')
            ->select(
                'tasks.*',
                'paps.pap',
                'paptask.tasks',
                'PREPARER.name as Preparer',
                'ASSIGNED.name as Assigned',
                'r1.name as rv1',
                'r2.name as rv2',
                'r3.name as rv3',
                'r4.name as rv4',
                'r5.name as rv5',
            )
            ->where('tasks.id', $id)
            ->first();
        return view('Task.viewtask', ["fromtask" => $tasks]);
    }

    public function viewupdateTask($id)
    {

        $budgetoption = DB::table('budget')
            ->join('paps','budget.budgetPAP', '=', 'paps.id')
            ->select('budget.*', 'paps.pap')
            ->get();


        $tasks = DB::table('tasks')
            ->join('paps', 'tasks.PAP', '=', 'paps.id')
            ->leftjoin('budget', 'tasks.allocatedbudget', '=', 'budget.id')
            ->leftjoin('paps as budgetpap','budget.budgetPAP', '=', 'budgetpap.id')
            ->join('paptask', 'tasks.task', '=', 'paptask.id')
            ->join('users as PREPARER', 'tasks.preparer', '=', 'PREPARER.id')
            ->join('users as ASSIGNED', 'tasks.assigned', '=', 'ASSIGNED.id')
            ->leftJoin('users as r1', 'tasks.reviewer1', '=', 'r1.id')
            ->leftJoin('users as r2', 'tasks.reviewer2', '=', 'r2.id')
            ->leftJoin('users as r3', 'tasks.reviewer3', '=', 'r3.id')
            ->leftJoin('users as r4', 'tasks.reviewer4', '=', 'r4.id')
            ->leftJoin('users as r5', 'tasks.reviewer5', '=', 'r5.id')
            ->select(
                'tasks.*',
                'paps.pap',
                'budget.budgetPAP',
                'budgetpap.pap as budgetpapname',
                'paptask.tasks',
                'PREPARER.name as Preparer',
                'ASSIGNED.name as Assigned',
                'r1.name as rv1',
                'r2.name as rv2',
                'r3.name as rv3',
                'r4.name as rv4',
                'r5.name as rv5',
            )
            ->where('tasks.id', $id)
            ->first();

        return view('Task.updatetask', ["fromtask" => $tasks, "budgetoption" =>$budgetoption]);
    }

    public function mytask()
    {

        $tasks = DB::table('tasks')
            ->join('paps', 'tasks.PAP', '=', 'paps.id')
            ->join('paptask', 'tasks.task', '=', 'paptask.id')
            ->select(
                'tasks.id',
                'tasks.activitydate',
                'tasks.duedate',
                'tasks.progressScore',
                'tasks.is_read',
                'paps.pap',
                'paptask.tasks as task'
            )
            ->where('tasks.preparer', Auth::user()->id)
            ->orderByDesc('tasks.activitydate')
            ->get();

        /* GROUP BY DATE (LIKE C# GroupBy) */
        $groupedTasks = $tasks->groupBy(function ($task) {
            return Carbon::parse($task->activitydate)->toDateString();
        });

        return view('Task.mytask', [
            'groupedTasks' => $groupedTasks
        ]);
    }

    public function toreview()
    {

        if (Auth::user()->usertype != "admin") {

            $tasks = DB::table('tasks')
                ->join('paps', 'tasks.PAP', '=', 'paps.id')
                ->join('paptask', 'tasks.task', '=', 'paptask.id')
                ->select(
                    'tasks.id',
                    'tasks.activitydate',
                    'tasks.duedate',
                    'tasks.progressScore',
                    'tasks.is_read',
                    'paps.pap',
                    'paptask.tasks as task'
                )
                ->where('tasks.reviewer1', Auth::user()->id)
                ->orderByDesc('tasks.activitydate')
                ->get();


            $groupedTasks = $tasks->groupBy(function ($task) {
                return Carbon::parse($task->activitydate)->toDateString();
            });
        } else {
            $tasks = DB::table('tasks')
                ->join('paps', 'tasks.PAP', '=', 'paps.id')
                ->join('paptask', 'tasks.task', '=', 'paptask.id')
                ->select(
                    'tasks.id',
                    'tasks.activitydate',
                    'tasks.duedate',
                    'tasks.progressScore',
                    'tasks.is_read',
                    'paps.pap',
                    'paptask.tasks as task'
                )

                ->orderByDesc('tasks.activitydate')
                ->get();


            $groupedTasks = $tasks->groupBy(function ($task) {
                return Carbon::parse($task->activitydate)->toDateString();
            });
        }
        return view('Task.mytask', [
            'groupedTasks' => $groupedTasks
        ]);
    }

    public function reports()
    {
        return view('reports', [
            'users' => User::all(),
            'mpap' => Paps::all(),
            'cath' => paptask::all()->groupBy('papID')->map->values(), // ✅ grouped
            'reportData' => collect(),
            'displayColumns' => []
        ]);
    }

    public function generate(Request $request)
    {


        $users = User::all();
        $mpap  = Paps::all();

        // 🔹 IMPORTANT: grouped for JS
        $cath = paptask::all()->groupBy('papID')->map->values();

        $selectedColumns = $request->input('SelectedColumns', []);

        /* Expand grouped columns */
        $displayColumns = [];

        foreach ($selectedColumns as $col) {

            switch ($col) {
                case 'PAP':
                    $displayColumns = array_merge($displayColumns, ['pap_name']);
                    break;
                case 'task':
                    $displayColumns = array_merge($displayColumns, ['task_name']);
                    break;
                case 'assigned':
                    $displayColumns = array_merge($displayColumns, ['assigned_name']);
                    break;
                case 'preparer':
                    $displayColumns = array_merge($displayColumns, ['preparer_name']);
                    break;
                case 'reviewer':
                    $displayColumns = array_merge($displayColumns, ['Reviewer']);
                    break;

                case 'status':
                    $displayColumns = array_merge($displayColumns, ['status1', 'status2', 'status3', 'status4', 'status5']);
                    break;
                case 'remarks':
                    $displayColumns = array_merge($displayColumns, ['remarks1', 'remarks2', 'remarks3', 'remarks4', 'remarks5']);
                    break;
                default:
                    $displayColumns[] = $col;
            }
        }





        /* Build query */
        $query = Task::join('paps', 'tasks.PAP', '=', 'paps.id')
            ->join('paptask', 'tasks.task', '=', 'paptask.id')
            ->leftJoin('users as r1', 'tasks.reviewer1', '=', 'r1.id')
            ->leftJoin('users as r2', 'tasks.reviewer2', '=', 'r2.id')
            ->leftJoin('users as r3', 'tasks.reviewer3', '=', 'r3.id')
            ->leftJoin('users as r4', 'tasks.reviewer4', '=', 'r4.id')
            ->leftJoin('users as r5', 'tasks.reviewer5', '=', 'r5.id')
            ->leftJoin('users as assigned', 'tasks.assigned', '=', 'assigned.id')
            ->leftJoin('users as preparer', 'tasks.preparer', '=', 'preparer.id')
            ->select(
                'tasks.*',
                'paps.pap as pap_name',
                'paptask.tasks as task_name',
                'assigned.name as assigned_name',
                'preparer.name as preparer_name',

            )
            ->selectRaw("CONCAT_WS(', ', r1.name, r2.name, r3.name, r4.name, r5.name) as Reviewer");

        if ($request->filled('PAP')) {
            $query->where('tasks.PAP', $request->PAP); // assumes PAP is ID
        }

        if ($request->filled('tasks')) {
            $query->whereIn('task', $request->tasks); // ✅ FIX
        }

        if ($request->filled('preparer')) {
            $query->where('preparer', $request->preparer);
        }


        if ($request->filled('assigned')) {
            $query->where('assigned', $request->assigned);
        }

        if ($request->filled('activitydate')) {
            $query->whereDate('activitydate', $request->activitydate);
        }

        $reportData = $query->get();

        // dd($request);  



        return view('reports', compact(
            'users',
            'mpap',
            'cath',
            'reportData',
            'displayColumns'
        ));
    }




    // for creating task of employee
    public function store(Request $request)
    {
        // $validate = $request->validate([
        //     'PAP' => 'required|string',
        //     'preparer' => 'required|string',
        //     'task' => 'required|string',
        //     'assigned' => 'required|string',
        //     'activitydate' => 'required|string',
        //     'duedate' => 'required|string',
        //     'link' => 'nullable|string',
        //     'note' => 'nullable|string',
        //     'reviewer1' => 'required|string',
        //     'returneddate1' => 'nullable|string',
        //     'remarks1' => 'nullable|string',
        //     'status1' => 'nullable|string',
        //     'reviewer2' => 'nullable|string',
        //     'returneddate2' => 'nullable|string',
        //     'remarks2' => 'nullable|string',
        //     'status2' => 'nullable|string',
        //     'reviewer3' => 'nullable|string',
        //     'returneddate3' => 'nullable|string',
        //     'remarks3' => 'nullable|string',
        //     'status3' => 'nullable|string',
        //     'reviewer4' => 'nullable|string',
        //     'returneddate4' => 'nullable|string',
        //     'remarks4' => 'nullable|string',
        //     'status4' => 'nullable|string',
        //     'reviewer5' => 'nullable|string',
        //     'returneddate5' => 'nullable|string',
        //     'remarks5' => 'nullable|string',
        //     'status5' => 'nullable|string'
        // ]);

        foreach ($request->tasks as $taskId) {
            DB::table('tasks')->insert([
                'PAP' => $request->PAP,
                'task' => $taskId,
                'assigned' => $request->assigned,
                'preparer' => $request->preparer,
                'activitydate' => $request->activitydate,
                'duedate' => $request->duedate,

                // reviewers
                'reviewer1' => $request->reviewer1,
                'returneddate1' => $request->returneddate1,
                'status1' => $request->status1,

                'reviewer2' => $request->reviewer2,
                'returneddate2' => $request->returneddate2,
                'status2' => $request->status2,

                'reviewer3' => $request->reviewer3,
                'returneddate3' => $request->returneddate3,
                'status3' => $request->status3,

                'reviewer4' => $request->reviewer4,
                'returneddate4' => $request->returneddate4,
                'status4' => $request->status4,

                'reviewer5' => $request->reviewer5,
                'returneddate5' => $request->returneddate5,
                'status5' => $request->status5,

                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        // Task::create($validate);
        return redirect()->route('monitoring');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        Task::where('id', $request->id)->update([

            'note' => $request->note,
            'link' => $request->link,
            'status1' => $request->status1,
            'status2' => $request->status2,
            'status3' => $request->status3,
            'status4' => $request->status4,
            'status5' => $request->status5,
            'allocatedbudget' => $request->allocatedbugdet,
            'budget' => $request->budget,
            'costing' => $request->costing,
        ]);


        return redirect()->route('my task');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
