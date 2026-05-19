<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Paps;
use App\Models\Paptask;
use App\Models\Budget;
use App\Models\createdPAP;
use App\Models\divisions;
use App\Models\fundSource;
use App\Models\ooSupported;
use app\Models\mooe;
use App\Models\mooe as ModelsMooe;
use App\Models\Sector;
use App\Models\SectorProgram;
use App\Models\Subprogram;
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

    // for task.blade
    public function index($date = null, $papM = null)
    {
        $viewpap = DB::table('papmanagement')
            ->join('paps', 'papmanagement.papID', '=', 'paps.id')
            ->join('users', 'papmanagement.focal', '=', 'users.id')
            ->join('fundsource', 'papmanagement.fundsource', '=', 'fundsource.id')
            ->join('divisions', 'papmanagement.divisionID', '=', 'divisions.id')
            ->join('outputsupported', 'papmanagement.oosID', '=', 'outputsupported.oosID')
            ->where('papmanagement.id', $papM)
            ->select('papmanagement.*', 'paps.pap', 'users.name as focalPerson', 'fundsource.fundName as fundName', 'divisions.*', 'outputsupported.oosName')
            ->get();

      


       
        $tasks = DB::table('papmanagement')
            ->join('paps', 'papmanagement.papID', '=', 'paps.id')
            ->join('tasks', 'papmanagement.id', '=', 'tasks.PAP')
            ->join('paptask', 'tasks.task', '=', 'paptask.id')
            ->join('users as ASSIGNED', 'tasks.assigned', '=', 'ASSIGNED.id')
            ->join('users as focal', 'papmanagement.focal', '=', 'focal.id')
            ->join('fundsource', 'papmanagement.fundsource', '=', 'fundsource.id')
            ->where('papmanagement.id', $papM)
            ->select('tasks.*','tasks.id as taskid', 'paps.pap', 'paptask.tasks', 'ASSIGNED.name as Assigned', 'focal.name as focalPerson', 'papmanagement.*', 'fundsource.fundName as fundName')
            ->get();

        return view('Task.task', ["fromtask" => $tasks , "viewpap" => $viewpap]);
    }

    // for dashboard.blade
    public function dashboard()
    {
        $now = Carbon::now();

        $totalmooe = DB::table('mooe')
            ->select(DB::raw('SUM(budgetallotment) as grandtotal, SUM(adjustedbudget) as totaladjusted'))
            ->get();
        $totalobligation = DB::table('tasks')
        ->select(DB::raw('SUM(tasks.obligatedbudget) AS totalobligation'))
        ->get();

        $monthtask = DB::table('tasks')
            ->join('users', 'tasks.assigned', '=', 'users.id')
            ->join('papmanagement', 'tasks.PAP', '=', 'papmanagement.id')
            ->join('paps', 'papmanagement.papID', '=', 'paps.id')
            ->join('paptask', 'tasks.task', '=', 'paptask.id')
            ->whereMonth('tasks.activitydate', $now->month)
            ->select('tasks.*', 'users.name', 'paps.pap', 'paptask.tasks', 'users.avatar')
            ->get();



        // $budget = DB::table('budget')
        //     ->join('paps', 'budget.budgetPAP', '=', 'paps.id')
        //     ->leftJoin('tasks', 'budget.id', '=', 'tasks.allocatedbudget')
        //     ->select(
        //         'budget.*',
        //         'paps.pap',
        //         DB::raw('SUM(tasks.costing) AS total')
        //     )
        //     ->groupBy('budget.id')
        //     ->get();

        $task = createdPAP::join('paps', 'papmanagement.papID', '=', 'paps.id')
            ->select('papmanagement.*', 'paps.pap')
            ->whereMonth('papmanagement.fromdate', $now->month)
            ->get();


        return view('welcome', ["task" => $task, "monthtask" => $monthtask, "fybudget" => $totalmooe, "totalobligation" => $totalobligation]);
    }

    // for creating new PAP(papmangement.blade)
    public function savePAP(Request $request) 
    {
       
  
        if ($request->editpapid) {

        createdPAP::where('id', $request->editpapid)->update([
            'papID' => $request->editpapids,
            'description' => ucfirst(strtolower($request->editdescription)),
            'focal' => $request->editfocalSelect,
            'todate' => $request->editdateend,
            'location' => strtoupper($request->editlocation),
            'fromdate' => $request->editdatefrom,
            'fundsource' => $request->editfunds,
            'divisionID' => $request->editdivisionSelect,
            'oosID' => $request->editoosSelect,
        ]);
        return back()->with('success', 'Updated successfully');
        }
        else{

            
            createdPAP::create([
                'papID' => $request->pap,
                'description' => ucfirst(strtolower($request->description)),
                'focal' => $request->focalSelect,
                'todate' => $request->dateend,
                'location' => strtoupper($request->location),
                'fromdate' => $request->datefrom,
                'fundsource' => $request->funds,
                'divisionID' => $request->divisionSelect,
                'sectorID' => $request->sectorselect,
                'oosID' => $request->oosSelect,
            ]);

        return back()->with('success', 'Saved successfully');
        }
    }



    // for pap.blade
    public function forpap($year = null, $month = null)
    {
        $now = Carbon::now();
        $papOptions = Paps::all();
        $users = User::all()
        ->where('usertype', '!=', 'admin');

        $fund = fundSource::all();
        $division = divisions::all();
        $sector = Sector::all();
        $oos = ooSupported::all();
        


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

            $newtask = DB::table('papmanagement')
            ->join('paps', 'papmanagement.papID', '=', 'paps.id')
            ->join('users', 'papmanagement.focal', '=', 'users.id')
            ->join('fundsource', 'papmanagement.fundsource', '=', 'fundsource.id')
            ->join('divisions', 'papmanagement.divisionID', '=', 'divisions.id')
            ->join('outputsupported', 'papmanagement.oosID', 'outputsupported.oosID')
            ->whereYear('papmanagement.fromdate', $Year)
            ->whereMonth('papmanagement.fromdate', $Month)
            ->select('papmanagement.id as newID','papmanagement.*', 'paps.pap', 'users.name as focalPerson', 'fundsource.fundName as fundName', 'divisions.*', 'outputsupported.oosName')
            ->get();

    



        return view('Task.pap', compact('tasks', 'Year', 'Month', 'papOptions', 'newtask', 'users', 'fund', 'division', 'sector', 'oos'));
    }


    // view for creating task page
    // public function create()
    // {
    //     $paps = Paps::all();
    //     $users = User::all();
    //     $paptask = PapTask::all();

    //     $tasksByPap = $paptask
    //         ->groupBy('papID')
    //         ->map(function ($tasks) {
    //             return $tasks->map(function ($task) {
    //                 return [
    //                     'id' => $task->id,
    //                     'tasks' => $task->tasks
    //                 ];
    //             });
    //         });
       
    //     return view('/Task.createtask', compact(
    //         'paps',
    //         'users',
    //         'paptask',
    //         'tasksByPap'
    //     ));
    // }

    //  for creating specific PAP task(createtask.blade)
    public function newcreate($id)
    {
        $paps = Paps::all();
        $users = User::all();
        $paptask = Paptask::all();
        

        $newpap = DB::table('papmanagement')
            ->join('paps', 'papmanagement.papID', '=', 'paps.id')
            ->select('papmanagement.*', 'paps.pap')
            ->where('papmanagement.id', $id)
            ->first();

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
            'tasksByPap',
            'newpap'
        ));
    }

    // for creating new PAP(file management)
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

        if($request->action === 'editpap')
            {
                  Paps::where('id', $request->PAP)->update([
            'pap' => $request->task,
                  ]);
            }

        if($request->action === 'edittask')
            {
                  paptask::where('id', $request->PAP)->update([
            'tasks' => $request->task,
                  ]);
            }
            



        return back()->with('success', 'Saved successfully');
    }

    // for deleting pap(file management)
    public function deletePAP($id)
    {
        Paps::where('id', $id)->delete();
        return back()->with('success', 'Deleted successfully');
    }
    public function deleteTasks($id)
    {
        paptask::where('id', $id)->delete();
        return back()->with('success', 'Deleted successfully');
    }

    // viewing of individual task(viewtask.blade)
    public function viewTask($id)
    {
        $tasks = DB::table('tasks')
    ->leftjoin('papmanagement', 'tasks.PAP', '=', 'papmanagement.id')
    ->leftjoin('paps', 'papmanagement.papID', '=', 'paps.id')
    ->leftjoin('paptask', 'tasks.task', '=', 'paptask.id')
    ->leftjoin('users as ASSIGNED', 'tasks.assigned', '=', 'ASSIGNED.id')
    ->leftJoin('users as r1', 'tasks.reviewer1', '=', 'r1.id')
    ->leftJoin('users as r2', 'tasks.reviewer2', '=', 'r2.id')
    ->leftJoin('users as r3', 'tasks.reviewer3', '=', 'r3.id')
    ->leftJoin('users as r4', 'tasks.reviewer4', '=', 'r4.id')
    ->leftJoin('users as r5', 'tasks.reviewer5', '=', 'r5.id')
    ->leftjoin('mooe', 'tasks.allocatedbudget', '=', 'mooe.mooeID')
    ->leftJoin('subprogram', 'mooe.subprogramID', '=', 'subprogram.id')
    ->leftJoin('sectorprogram', 'subprogram.programID', '=', 'sectorprogram.id')
    ->select(
        'tasks.*',
        'paps.pap',
        'paptask.tasks',

        'ASSIGNED.name as Assigned',
        'r1.name as rv1',
        'r2.name as rv2',
        'r3.name as rv3',
        'r4.name as rv4',
        'r5.name as rv5',

        'mooe.mooeName',
        'mooe.mooeID',

        'subprogram.id as subprogram_id',
        'subprogram.subprogramname',

        'sectorprogram.id as program_id',
        'sectorprogram.programname'
    )
    ->where('tasks.id', $id)
    ->first();
        return view('Task.viewtask', ["fromtask" => $tasks]);
    }

    // for viewing the update task page(updatetask.blade)
    public function viewupdateTask($id)
    {

       
        $program = SectorProgram::all();
        $subprogram = Subprogram::all();
        $mooe = ModelsMooe::all();

        $tasks = DB::table('tasks')
            ->leftjoin('papmanagement', 'tasks.PAP', '=', 'papmanagement.id')
            ->leftjoin('paps', 'papmanagement.papID', '=', 'paps.id')
            ->leftjoin('budget', 'tasks.allocatedbudget', '=', 'budget.id')
            ->leftjoin('paps as budgetpap', 'budget.budgetPAP', '=', 'budgetpap.id')
            ->leftjoin('paptask', 'tasks.task', '=', 'paptask.id')
            ->leftjoin('users as ASSIGNED', 'tasks.assigned', '=', 'ASSIGNED.id')
            ->leftJoin('users as r1', 'tasks.reviewer1', '=', 'r1.id')
            ->leftJoin('users as r2', 'tasks.reviewer2', '=', 'r2.id')
            ->leftJoin('users as r3', 'tasks.reviewer3', '=', 'r3.id')
            ->leftJoin('users as r4', 'tasks.reviewer4', '=', 'r4.id')
            ->leftJoin('users as r5', 'tasks.reviewer5', '=', 'r5.id')
            ->leftjoin('mooe', 'tasks.allocatedbudget', '=', 'mooe.mooeID')
            ->leftJoin('subprogram', 'mooe.subprogramID', '=', 'subprogram.id')
            ->leftJoin('sectorprogram', 'subprogram.programID', '=', 'sectorprogram.id')
            ->select(
                'tasks.*',
                'paps.pap',
                'budget.budgetPAP',
                'budgetpap.pap as budgetpapname',
                'paptask.tasks',
                'ASSIGNED.name as Assigned',
                'r1.name as rv1',
                'r2.name as rv2',
                'r3.name as rv3',
                'r4.name as rv4',
                'r5.name as rv5',
                'papmanagement.fromdate as papdate',
                'papmanagement.todate as papdateend',

                'subprogram.id as subprogram_id',
                'subprogram.subprogramname',
                'mooe.mooeID',

                'sectorprogram.id as program_id',
                'sectorprogram.programname',
                'mooe.mooeName'
            )
            ->where('tasks.id', $id)
            ->first();

           
       
        return view('Task.updatetask', ["fromtask" => $tasks, "program" => $program, "subprogram"=>$subprogram, "mooe"=>$mooe]);
    }

    // for my task page(mytask.blade)
    public function mytask()
    {

        $tasks = DB::table('tasks')
            ->join('papmanagement', 'tasks.PAP', '=', 'papmanagement.id')
            ->join('paps', 'papmanagement.papID', '=', 'paps.id')
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
            ->where('tasks.assigned', Auth::user()->id)
            ->orderByDesc('tasks.activitydate')
            ->get();

        /* GROUP BY DATE (LIKE C# GroupBy) */
        $groupedTasks = $tasks->groupBy(function ($task) {
            return Carbon::parse($task->activitydate)->toDateString();
        });

        return view('Task.mytask', [
            'groupedTasks' => $tasks
        ]);
    }

    // for review page(review.blade)
    public function toreview()
    {

        if (Auth::user()->usertype != "admin") {

            $tasks = DB::table('tasks')
                ->join('papmanagement', 'tasks.PAP', '=', 'papmanagement.id')
            ->join('paps', 'papmanagement.papID', '=', 'paps.id')
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
                ->where(function ($query) {
                    $query->where('tasks.reviewer1', Auth::user()->id)
                        ->orWhere('tasks.reviewer2', Auth::user()->id)
                        ->orWhere('tasks.reviewer3', Auth::user()->id)
                        ->orWhere('tasks.reviewer4', Auth::user()->id)
                        ->orWhere('tasks.reviewer5', Auth::user()->id);
                })
                ->orderByDesc('tasks.activitydate')
                ->get();


            $groupedTasks = $tasks->groupBy(function ($task) {
                return Carbon::parse($task->activitydate)->toDateString();
            });
        } else {
            $tasks = DB::table('tasks')
                ->join('papmanagement', 'tasks.PAP', '=', 'papmanagement.id')
            ->join('paps', 'papmanagement.papID', '=', 'paps.id')
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
            'groupedTasks' => $tasks
        ]);
    }

    // for reports page(reports.blade)
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

    // for generating report based on filter(reports.blade)
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
         $totals = [
            'budget'    => 0,
            'costing'   => 0,
            'remaining' => 0,
        ];

        if (in_array('budget', $displayColumns)) {
            $totals['budget'] = $reportData->sum('budget');
        }

        if (in_array('costing', $displayColumns)) {
            $totals['costing'] = $reportData->sum('costing');
        }

        if (in_array('remaining', $displayColumns)) {
            $totals['remaining'] = $reportData->sum('remaining');
        }



        return view('reports', compact(
            'users',
            'mpap',
            'cath',
            'reportData',
            'displayColumns',
            'totals'
        ));
    }




    // for creating task (createtask.blade)
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
                // 'preparer' => $request->preparer,
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
        return redirect()->route('task disposition')->with('success', 'Task(s) created successfully.');
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

    // for updating task(updatetask.blade)
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
            'allocatedbudget' => $request->mooe,
            
            'obligatedbudget' => $request->budget,
        ]);



        
             return redirect()->route('my task')->with('success', 'Task updated successfully.');
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // for file management page(papmangement.blade)
    public function papmanagement()
    {
        $paps = Paps::all();
        
        $paptask = Paptask::all();

        $paptasks = DB::table('paptask')
        ->join('paps', 'paptask.papID','=','paps.id')
        ->select(['paptask.*', 'paps.pap'])
        ->get();

       
      
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
            
        return view('papmangement', compact(
            'paps',
           
            'paptask',
            'tasksByPap',
            'paptasks'
        ));
    }
}
