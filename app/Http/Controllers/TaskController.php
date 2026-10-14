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

use App\Models\mooe;

use Illuminate\Support\Str;

use App\Models\mooe as ModelsMooe;

use App\Models\Sector;

use App\Models\SectorProgram;

use App\Models\Subprogram;

use App\Models\Task;
use App\Models\taskReviewer;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

use Spatie\GoogleCalendar\Event;

use App\Services\GoogleCalendarService;

use App\Mail\TaskAssignedMail;

use Illuminate\Support\Facades\Mail;



class TaskController extends Controller

{

    private function reviewerProgressSql(): string
    {
        return "COALESCE((SELECT SUM(CASE WHEN tr.status IN ('Completed', 'Not Applicable') THEN 1 WHEN tr.status IN ('Received', 'In Progress') THEN 0.5 ELSE 0 END) / NULLIF(COUNT(*), 0) FROM task_reviewers tr WHERE tr.task_id = tasks.id), 0)";
    }

    /**

     * Display a listing of the resource.

     */



    // for task.blade

    public function index($date = null, $papM = null)

    {

        $viewpap = DB::table('papmanagement')

            ->join('paps', 'papmanagement.papID', '=', 'paps.id')

            ->leftjoin('users', 'paps.userID', '=', 'users.id')

            ->leftjoin('fundsource', 'paps.fundID', '=', 'fundsource.id')

            ->leftjoin('divisions', 'paps.divID', '=', 'divisions.id')

            ->leftjoin('outputsupported', 'paps.oosID', '=', 'outputsupported.oosID')

            ->where('papmanagement.id', $papM)

            ->select('papmanagement.*', 'paps.pap', 'users.name as focalPerson', 'fundsource.fundName as fundName', 'divisions.*', 'outputsupported.oosName', 'papmanagement.id as newID')

            ->get();











        $reviewData = DB::table('task_reviewers as tr')
            ->leftJoin('users as reviewer', 'tr.reviewer_id', '=', 'reviewer.id')
            ->select('tr.task_id')
            ->selectRaw("GROUP_CONCAT(CONCAT(tr.review_order, '. ', COALESCE(reviewer.name, 'Unknown user'), ' (', IF(tr.status = 'In Progress', 'Received', tr.status), ')') ORDER BY tr.review_order SEPARATOR ', ') as reviewers")
            ->selectRaw('COUNT(*) as reviewer_count')
            ->selectRaw("SUM(CASE WHEN tr.status IN ('Completed', 'Not Applicable') THEN 1 ELSE 0 END) as finished_count")
            ->selectRaw("SUM(CASE WHEN tr.status IN ('Received', 'In Progress') THEN 1 ELSE 0 END) as received_count")
            ->groupBy('tr.task_id');

        $tasks = DB::table('papmanagement')

            ->join('paps', 'papmanagement.papID', '=', 'paps.id')

            ->join('tasks', 'papmanagement.id', '=', 'tasks.PAP')

            ->join('paptask', 'tasks.task', '=', 'paptask.id')

            ->join('users as ASSIGNED', 'tasks.assigned', '=', 'ASSIGNED.id')

            ->leftjoin('users as focal', 'paps.userID', '=', 'focal.id')

            ->leftjoin('fundsource', 'paps.fundID', '=', 'fundsource.id')

            ->leftJoinSub($reviewData, 'review_data', function ($join) {
                $join->on('review_data.task_id', '=', 'tasks.id');
            })

            ->where('papmanagement.id', $papM)

            ->select('tasks.*', 'tasks.id as taskid', 'paps.pap', 'paptask.tasks', 'ASSIGNED.name as Assigned', 'focal.name as focalPerson', 'papmanagement.*', 'fundsource.fundName as fundName', 'ASSIGNED.avatar as avatar', 'review_data.reviewers', 'review_data.reviewer_count', 'review_data.finished_count', 'review_data.received_count')
            ->selectRaw('COALESCE((review_data.finished_count + 0.5 * review_data.received_count) / NULLIF(review_data.reviewer_count, 0), 0) as reviewer_progress')

            ->get();



        return view('Task.task', ["fromtask" => $tasks, "viewpap" => $viewpap]);
    }



    // for dashboard.blade

    public function dashboard()
    {
        $now = Carbon::now();

        $userId = Auth::user()->id;


        if (Auth::user()->usertype != "1") {

            $reviewcounttasks = DB::table('tasks')

                ->join('papmanagement', 'tasks.PAP', '=', 'papmanagement.id')

                ->join('paps', 'papmanagement.papID', '=', 'paps.id')

                ->join('paptask', 'tasks.task', '=', 'paptask.id')

                ->select(
                    'tasks.id',
                    'tasks.activitydate',
                    'tasks.duedate',
                    DB::raw($this->reviewerProgressSql() . ' as progressScore'),
                    'tasks.is_read',
                    'paps.pap',
                    'paptask.tasks as task'
                )

                ->where('tasks.reviewLevel', '>=', 1)

                ->whereExists(function ($query) use ($userId) {

                    $query->selectRaw('1')

                        ->from('task_reviewers as tr')

                        ->whereColumn('tr.task_id', 'tasks.id')

                        ->where('tr.reviewer_id', $userId)

                        ->whereIn('tr.status', ['Pending', 'Received', 'In Progress'])

                        ->whereNotExists(function ($prior) {

                            $prior->selectRaw('1')

                                ->from('task_reviewers as previous')

                                ->whereColumn('previous.task_id', 'tr.task_id')

                                ->whereColumn('previous.review_order', '<', 'tr.review_order')

                                ->whereNotIn('previous.status', ['Completed', 'Not Applicable']);
                        });
                })

                ->get();
        } else {

            $reviewcounttasks = DB::table('tasks')

                ->join('papmanagement', 'tasks.PAP', '=', 'papmanagement.id')

                ->join('paps', 'papmanagement.papID', '=', 'paps.id')

                ->join('paptask', 'tasks.task', '=', 'paptask.id')

                ->select(
                    'tasks.id',
                    'tasks.activitydate',
                    'tasks.duedate',
                    DB::raw($this->reviewerProgressSql() . ' as progressScore'),
                    'tasks.is_read',
                    'paps.pap',
                    'paptask.tasks as task'
                )

                ->where('tasks.reviewLevel', '>=', 1)

                ->whereExists(function ($query) {

                    $query->selectRaw('1')

                        ->from('task_reviewers as tr')

                        ->whereColumn('tr.task_id', 'tasks.id')

                        ->whereIn('tr.status', ['Pending', 'Received', 'In Progress']);
                })

                ->get();
        }


        $counttask = DB::table('tasks')

            ->join('papmanagement', 'tasks.PAP', '=', 'papmanagement.id')

            ->join('paps', 'papmanagement.papID', '=', 'paps.id')

            ->join('paptask', 'tasks.task', '=', 'paptask.id')

            ->select(
                'tasks.id',
                'tasks.activitydate',
                'tasks.duedate',
                DB::raw($this->reviewerProgressSql() . ' as progressScore'),
                'tasks.is_read',
                'paps.pap',
                'paptask.tasks as task'
            )

            ->where('tasks.assigned', Auth::user()->id)

            ->where(function ($query) {

                $query->whereExists(function ($reviewers) {

                    $reviewers->selectRaw('1')

                        ->from('task_reviewers as tr')

                        ->whereColumn('tr.task_id', 'tasks.id')

                        ->whereIn('tr.status', ['Pending', 'Received', 'In Progress']);
                })

                    ->orWhereNotExists(function ($reviewers) {

                        $reviewers->selectRaw('1')

                            ->from('task_reviewers as tr')

                            ->whereColumn('tr.task_id', 'tasks.id');
                    });
            })

            ->orderByDesc('tasks.activitydate')

            ->get();


        $totalmooe = DB::table('mooe')

            ->select(DB::raw('SUM(budgetallotment) as grandtotal, SUM(adjustedbudget) as totaladjusted'))

            ->get();


        $totalobligation = DB::table('tasks')

            ->select(DB::raw('SUM(tasks.obligatedbudget) AS totalobligation'))

            ->get();



        $monitoringQuery = DB::table('tasks')

            ->join('users', 'tasks.assigned', '=', 'users.id')

            ->join('papmanagement', 'tasks.PAP', '=', 'papmanagement.id')

            ->join('paps', 'papmanagement.papID', '=', 'paps.id')

            ->join('paptask', 'tasks.task', '=', 'paptask.id')

            ->leftJoin('task_reviewers as cr', function ($join) {

                $join->on('tasks.id', '=', 'cr.task_id')

                    ->whereRaw("
                    cr.id = (
                        SELECT tr.id
                        FROM task_reviewers tr
                        WHERE tr.task_id = tasks.id
                        AND tr.status IN ('Received', 'Pending')
                        ORDER BY
                            CASE
                                WHEN tr.status = 'Received' THEN 0
                                WHEN tr.status = 'Pending' THEN 1
                            END,
                            tr.review_order ASC
                        LIMIT 1
                    )
                ");
            })

            ->leftJoin(
                'users as current_reviewer_user',
                'cr.reviewer_id',
                '=',
                'current_reviewer_user.id'
            )



            ->select(
                'tasks.*',
                'users.name',
                'users.avatar',
                'paps.pap',
                'paptask.tasks',
                'current_reviewer_user.name as current_reviewer',
                'cr.status as current_status',
                'cr.review_order as current_review_order'
            )

            ->selectRaw(
                $this->reviewerProgressSql() . ' as reviewer_progress'
            );



        $allMonitoring = (clone $monitoringQuery)
            ->whereRaw("LOWER(TRIM(paptask.tasks)) IN ('apf', 'par', 'concept note', 'pr')")
            ->orderBy('tasks.duedate', 'asc')
            ->get()
            ->groupBy('PAP');







        $otherMonitoring = (clone $monitoringQuery)

            ->whereRaw("LOWER(TRIM(paptask.tasks)) NOT IN ('apf', 'par', 'concept note', 'pr')")
            ->whereMonth('tasks.duedate', $now->month)

            ->whereYear('tasks.duedate', $now->year)

            ->orderBy('tasks.duedate', 'asc')

            ->get();



        $task = createdPAP::join('paps', 'papmanagement.papID', '=', 'paps.id')

            ->select('papmanagement.*', 'paps.pap')

            ->whereMonth('papmanagement.fromdate', $now->month)

            ->whereYear('papmanagement.fromdate', $now->year)

            ->orderBy('papmanagement.fromdate', 'asc')

            ->get();



        return view('welcome', [
            "task" => $task,
            "allMonitoring" => $allMonitoring,
            "otherMonitoring" => $otherMonitoring,
            "fybudget" => $totalmooe,
            "totalobligation" => $totalobligation,
            "counttask" => $counttask,
            "reviewcounttasks" => $reviewcounttasks
        ]);
    }



    // for creating new PAP(paps.blade)

    public function savePAP(Request $request)

    {



        $gcalendar = new GoogleCalendarService();



        if ($request->editpapid) {



            createdPAP::where('id', $request->editpapid)->update([



                'description' => $request->editdescription,



                'todate' => $request->editdateend,

                'location' => strtoupper($request->editlocation),

                'fromdate' => $request->editdatefrom,

                'googlecalendareventID' => $request->googlecalendareventID

            ]);



            $gcalendar->updateEvent($request->googlecalendareventID, (object)[

                'title' => $request->editpapName,

                'description' => $request->editdescription,

                'start_date' => $request->editdatefrom,

                'end_date' => $request->editdateend,

            ]);





            return back()->with('success', 'Updated successfully');
        } else {



            $papname = Paps::where('id', $request->pap)->first();





            createdPAP::create([

                'papID' => $request->pap,

                'description' => $request->description,



                'todate' => $request->dateend,

                'location' => strtoupper($request->location),

                'fromdate' => $request->datefrom,

                'googlecalendareventID' => $gcalendar->createEvent((object)[

                    'title' => $papname->pap,

                    'description' => $request->description,

                    'start_date' => $request->datefrom,

                    'end_date' => $request->dateend,

                    'color_id' => 9

                ])





            ]);

















            return back()->with('success', 'Saved successfully');
        }
    }







    // for pap.blade

    public function forpap($year = null, $month = null)
    {
        $now = Carbon::now();

        $Year = ($year && $year > 0)
            ? $year
            : $now->year;

        $Month = ($month && $month >= 1 && $month <= 12)
            ? $month
            : $now->month;


        // Selected month
        $selectedDate = Carbon::create($Year, $Month, 1);

        $startOfMonth = $selectedDate->copy()->startOfMonth();

        $endOfMonth = $selectedDate->copy()->endOfMonth();


        $papOptions = Paps::all();


        $tasks = DB::table('tasks')
            ->join('papmanagement', 'tasks.PAP', '=', 'papmanagement.id')
            ->join('paps', 'papmanagement.papID', '=', 'paps.id')
            ->whereNotNull('tasks.activitydate')
            ->whereYear('tasks.activitydate', $Year)
            ->whereMonth('tasks.activitydate', $Month)
            ->select(
                'paps.pap',
                'tasks.PAP',
                DB::raw('MIN(tasks.activitydate) as first_activity'),
                DB::raw(
                    'AVG(' .
                        $this->reviewerProgressSql() .
                        ') as average_progress'
                )
            )
            ->groupBy(
                'tasks.PAP',
                'paps.pap'
            )
            ->get();


        $newtask = DB::table('papmanagement')
            ->join('paps', 'papmanagement.papID', '=', 'paps.id')
            ->whereYear('papmanagement.fromdate', $Year)
            ->whereMonth('papmanagement.fromdate', $Month)
            ->select(
                'papmanagement.id as newID',
                'papmanagement.*',
                'paps.pap'
            )
            ->orderBy('papmanagement.fromdate', 'asc')
            ->get();


        $yearlyTasks = DB::table('papmanagement')
            ->join('paps', 'papmanagement.papID', '=', 'paps.id')
            ->whereYear('papmanagement.fromdate', $Year)
            ->select(
                'papmanagement.id as newID',
                'papmanagement.*',
                'paps.pap'
            )
            ->orderBy('papmanagement.fromdate', 'asc')
            ->get();


        // Activities displayed in the calendar
        // Includes activities that overlap the selected month.
        $task = createdPAP::join(
            'paps',
            'papmanagement.papID',
            '=',
            'paps.id'
        )
            ->select(
                'papmanagement.*',
                'paps.pap'
            )
            ->whereDate(
                'papmanagement.fromdate',
                '<=',
                $endOfMonth
            )
            ->where(function ($query) use ($startOfMonth) {

                $query
                    ->whereDate(
                        'papmanagement.todate',
                        '>=',
                        $startOfMonth
                    )
                    ->orWhere(function ($query) use ($startOfMonth) {

                        $query
                            ->whereNull('papmanagement.todate')
                            ->whereDate(
                                'papmanagement.fromdate',
                                '>=',
                                $startOfMonth
                            );
                    });
            })

            ->orderBy(
                'papmanagement.fromdate',
                'asc'
            )
            ->get();


        return view('Task.pap', compact(
            'tasks',
            'Year',
            'Month',
            'papOptions',
            'newtask',
            'yearlyTasks',
            'task',
            'now'
        ));
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



    public function removepaptask($id)

    {

        Task::where('id', $id)->delete();

        return back()->with('success', 'Deleted successfully');
    }



    // for creating new PAP(file management)

    public function createPAP(Request $request)

    {





        if ($request->action === 'pap') {



            Paps::create([

                'pap' => $request->PAPname,

                'sectorID' => $request->sectorselect,

                'divID' => $request->divisionSelect,

                'fundID' => $request->funds,

                'userID' => $request->focalSelect,

                'oosID' => $request->oosSelect,





            ]);
        }



        if ($request->action === 'task') {

            paptask::create([

                'papID' => $request->PAP,

                'tasks' => $request->task

            ]);
        }



        if ($request->action === 'editpap') {



            Paps::where('id', $request->PAP)->update([

                'pap' => $request->editpapname,

                'sectorID' => $request->editsectorselect,

                'divID' => $request->editdivisionSelect,

                'fundID' => $request->editfunds,

                'userID' => $request->editfocalSelect,

                'oosID' => $request->editoosSelect

            ]);
        }



        if ($request->action === 'edittask') {

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

    //for deleting pap in papmanagement

    public function deletepapmanagement($id)

    {

        $gcalendar = new GoogleCalendarService();



        $createdpap = createdPAP::find($id);



        $gcalendar->deleteEvent($createdpap->googlecalendareventID);



        createdPAP::where('id', $id)->delete();

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

            ->leftjoin('mooe', 'tasks.allocatedbudget', '=', 'mooe.mooeID')

            ->leftJoin('subprogram', 'mooe.subprogramID', '=', 'subprogram.id')

            ->leftJoin('sectorprogram', 'subprogram.programID', '=', 'sectorprogram.id')

            ->leftJoin('fundsource', 'paps.fundID', '=', 'fundsource.id')

            ->select(

                'tasks.*',

                'paps.pap',

                'paptask.tasks',

                'fundsource.fundName',



                'ASSIGNED.name as Assigned',



                'mooe.mooeName',

                'mooe.mooeID',



                'subprogram.id as subprogram_id',

                'subprogram.subprogramname',



                'sectorprogram.id as program_id',

                'sectorprogram.programname'

            )

            ->where('tasks.id', $id)

            ->first();

        $reviewers = taskReviewer::query()->leftJoin('users', 'task_reviewers.reviewer_id', '=', 'users.id')
            ->where('task_reviewers.task_id', $id)
            ->orderBy('task_reviewers.review_order')
            ->select('task_reviewers.*', 'users.name as reviewer_name')->get();
        return view('Task.viewtask', ["fromtask" => $tasks, "reviewers" => $reviewers]);
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

            ->leftjoin('mooe', 'tasks.allocatedbudget', '=', 'mooe.mooeID')

            ->leftJoin('subprogram', 'mooe.subprogramID', '=', 'subprogram.id')

            ->leftJoin('sectorprogram', 'subprogram.programID', '=', 'sectorprogram.id')

            ->leftJoin('fundsource', 'paps.fundID', '=', 'fundsource.id')

            ->select(

                'tasks.*',

                'paps.pap',

                'budget.budgetPAP',

                'budgetpap.pap as budgetpapname',

                'paptask.tasks',

                'ASSIGNED.name as Assigned',

                'papmanagement.fromdate as papdate',

                'papmanagement.todate as papdateend',

                'fundsource.fundName as fundname',



                'subprogram.id as subprogram_id',

                'subprogram.subprogramname',

                'mooe.mooeID',

                'mooe.mooeName',



                'sectorprogram.id as program_id',

                'sectorprogram.programname',

                'mooe.mooeName'

            )

            ->where('tasks.id', $id)

            ->first();







        $reviewers = taskReviewer::query()->leftJoin('users', 'task_reviewers.reviewer_id', '=', 'users.id')
            ->where('task_reviewers.task_id', $id)
            ->orderBy('task_reviewers.review_order')
            ->select('task_reviewers.*', 'users.name as reviewer_name')->get();
        return view('Task.updatetask', ["fromtask" => $tasks, "reviewers" => $reviewers, "program" => $program, "subprogram" => $subprogram, "mooe" => $mooe]);
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

                DB::raw($this->reviewerProgressSql() . ' as progressScore'),

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



    // for review page(review\.blade)

    public function toreview()
    {
        $userId = Auth::id();
        $base = DB::table('tasks')
            ->join('papmanagement', 'tasks.PAP', '=', 'papmanagement.id')
            ->join('paps', 'papmanagement.papID', '=', 'paps.id')
            ->join('paptask', 'tasks.task', '=', 'paptask.id')
            ->select(
                'tasks.id',
                'tasks.activitydate',
                'tasks.duedate',
                DB::raw($this->reviewerProgressSql() . ' as progressScore'),
                'tasks.is_read',
                'paps.pap',
                'paptask.tasks as task'
            );

        if ((string) Auth::user()->usertype === '1') {
            // Preserve the administrator's overview of all tasks.
            $tasks = (clone $base)
                ->selectSub(function ($query) {
                    $query->from('task_reviewers as current_review')
                        ->selectRaw("CASE WHEN current_review.status = 'In Progress' THEN 'Received' ELSE current_review.status END")
                        ->whereColumn('current_review.task_id', 'tasks.id')
                        ->whereIn('current_review.status', ['Pending', 'Received', 'In Progress'])
                        ->orderBy('current_review.review_order')
                        ->limit(1);
                }, 'review_status')
                ->where('tasks.reviewLevel', '>=', 1)
                ->whereExists(function ($query) {
                    $query->selectRaw('1')->from('task_reviewers as tr')
                        ->whereColumn('tr.task_id', 'tasks.id')
                        ->whereIn('tr.status', ['Pending', 'Received', 'In Progress']);
                })
                ->orderByDesc('tasks.activitydate')->get();
            $completedtasks = (clone $base)
                ->selectRaw("'Completed' as review_status")
                ->where('tasks.reviewLevel', '>=', 1)
                ->whereExists(function ($query) {
                    $query->selectRaw('1')->from('task_reviewers as tr')
                        ->whereColumn('tr.task_id', 'tasks.id');
                })
                ->whereNotExists(function ($query) {
                    $query->selectRaw('1')->from('task_reviewers as tr')
                        ->whereColumn('tr.task_id', 'tasks.id')
                        ->whereIn('tr.status', ['Pending', 'Received', 'In Progress']);
                })
                ->orderByDesc('tasks.activitydate')->get();
        } else {
            // A reviewer sees the task only after staff submission and earlier sign-offs.
            $mine = (clone $base)
                ->join('task_reviewers as my_review', function ($join) use ($userId) {
                    $join->on('my_review.task_id', '=', 'tasks.id')
                        ->where('my_review.reviewer_id', '=', $userId);
                })
                ->addSelect('my_review.reviewed_at')
                ->selectRaw("CASE WHEN my_review.status = 'In Progress' THEN 'Received' ELSE my_review.status END as review_status")
                ->where('tasks.reviewLevel', '>=', 1);

            $tasks = (clone $mine)
                ->whereIn('my_review.status', ['Pending', 'Received', 'In Progress'])
                ->whereNotExists(function ($query) {
                    $query->selectRaw('1')->from('task_reviewers as prior_review')
                        ->whereColumn('prior_review.task_id', 'my_review.task_id')
                        ->whereColumn('prior_review.review_order', '<', 'my_review.review_order')
                        ->whereNotIn('prior_review.status', ['Completed', 'Not Applicable']);
                })
                ->orderByDesc('tasks.activitydate')->get();

            $completedtasks = (clone $mine)
                ->whereIn('my_review.status', ['Completed', 'Not Applicable'])
                ->orderByDesc('tasks.activitydate')->get();
        }

        return view('Task.toreview', [
            'groupedTasks' => $tasks,
            'completedtasks' => $completedtasks,
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

                    $displayColumns = array_merge($displayColumns, ['Review_statuses']);

                    break;

                case 'remarks':

                    $displayColumns = array_merge($displayColumns, ['Review_remarks']);

                    break;

                default:

                    $displayColumns[] = $col;
            }
        }











        /* Build query */

        $query = Task::join('paps', 'tasks.PAP', '=', 'paps.id')

            ->join('paptask', 'tasks.task', '=', 'paptask.id')

            ->leftJoin('users as assigned', 'tasks.assigned', '=', 'assigned.id')

            ->leftJoin('users as preparer', 'tasks.preparer', '=', 'preparer.id')

            ->select(

                'tasks.*',

                'paps.pap as pap_name',

                'paptask.tasks as task_name',

                'assigned.name as assigned_name',

                'preparer.name as preparer_name',



            )

            ->selectSub(function ($sub) {
                $sub->from('task_reviewers as tr')->join('users as ru', 'ru.id', '=', 'tr.reviewer_id')
                    ->whereColumn('tr.task_id', 'tasks.id')
                    ->selectRaw("GROUP_CONCAT(ru.name ORDER BY tr.review_order SEPARATOR ', ')");
            }, 'Reviewer')
            ->selectSub(function ($sub) {
                $sub->from('task_reviewers as tr')->whereColumn('tr.task_id', 'tasks.id')
                    ->selectRaw("GROUP_CONCAT(tr.status ORDER BY tr.review_order SEPARATOR ', ')");
            }, 'Review_statuses')
            ->selectSub(function ($sub) {
                $sub->from('task_reviewers as tr')->whereColumn('tr.task_id', 'tasks.id')
                    ->selectRaw("GROUP_CONCAT(COALESCE(tr.remarks, '') ORDER BY tr.review_order SEPARATOR ' | ')");
            }, 'Review_remarks');



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
        $data = $request->validate([
            'PAP' => ['required', 'exists:papmanagement,id'],
            'tasks' => ['required', 'array', 'min:1'],
            'tasks.*' => ['required', 'exists:paptask,id'],
            'assigned' => ['required', 'exists:users,id'],
            'activitydate' => ['required', 'date'],
            'duedate' => ['required', 'date'],
            'reviewers' => ['required', 'array', 'min:1'],
            'reviewers.*' => ['required', 'integer', 'distinct', 'exists:users,id'],
        ]);

        $created = DB::transaction(function () use ($data) {
            $ids = [];
            foreach ($data['tasks'] as $taskId) {
                $qrToken = (string) Str::uuid();
                $id = DB::table('tasks')->insertGetId([
                    'PAP' => $data['PAP'],
                    'task' => $taskId,
                    'assigned' => $data['assigned'],
                    'activitydate' => $data['activitydate'],
                    'duedate' => $data['duedate'],
                    'reviewLevel' => 0,
                    'qr_review_token' => $qrToken,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                foreach (array_values($data['reviewers']) as $index => $reviewerId) {
                    taskReviewer::create([
                        'task_id' => $id,
                        'reviewer_id' => $reviewerId,
                        'review_order' => $index + 1,
                        'status' => 'Pending',
                    ]);
                }
                $ids[] = $id;
            }
            return $ids;
        });

        $email = User::findOrFail($data['assigned']);
        $papName = DB::table('papmanagement')->join('paps', 'paps.id', '=', 'papmanagement.papID')
            ->where('papmanagement.id', $data['PAP'])->value('paps.pap');
        foreach ($data['tasks'] as $taskId) {
            $taskName = Paptask::findOrFail($taskId)->tasks;
            Mail::to($email->email)->send(new TaskAssignedMail([
                'duedate' => $data['duedate'],
                'task' => $taskName,
                'paps' => $papName,
            ]));
        }
        return redirect()->route('task disposition')->with('success', 'Task(s) created successfully.');
    }
    // for updating task (updatetask.blade)
    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => ['required', 'exists:tasks,id'],

            'action' => ['nullable', 'in:staff'],

            'note' => ['nullable', 'string'],
            'link' => ['nullable', 'url'],

            'mooe' => ['nullable'],
            'budget' => ['nullable', 'numeric'],

            'review_status' => ['nullable', 'array'],

            'review_status.*' => [
                'in:Pending,Received,Completed,Not Applicable'
            ],
        ]);


        DB::transaction(function () use ($data) {

            /*
        |--------------------------------------------------------------------------
        | Get Task
        |--------------------------------------------------------------------------
        */

            $task = Task::whereKey($data['id'])
                ->lockForUpdate()
                ->firstOrFail();


            /*
        |--------------------------------------------------------------------------
        | Update Basic Task Information
        |--------------------------------------------------------------------------
        */

            $task->update([
                'note' => $data['note'] ?? null,
                'link' => $data['link'] ?? null,
                'allocatedbudget' => $data['mooe'] ?? null,
                'obligatedbudget' => $data['budget'] ?? null,
            ]);


            /*
        |--------------------------------------------------------------------------
        | Check if logged-in user is assigned personnel
        |--------------------------------------------------------------------------
        */

            $isAssignedPersonnel =
                (int) $task->assigned === (int) Auth::id();


            /*
        |--------------------------------------------------------------------------
        | ASSIGNED PERSONNEL
        |--------------------------------------------------------------------------
        |
        | Assigned personnel can manually change the status
        | of any reviewer belonging to this task.
        |
        */

            if ($isAssignedPersonnel) {

                /*
            |--------------------------------------------------------------------------
            | Start Review Process
            |--------------------------------------------------------------------------
            */

                if ((int) $task->reviewLevel === 0) {

                    $task->update([
                        'reviewLevel' => 1,
                    ]);
                }


                /*
            |--------------------------------------------------------------------------
            | Manual Reviewer Status Updates
            |--------------------------------------------------------------------------
            */

                if (!empty($data['review_status'])) {

                    foreach ($data['review_status'] as $reviewerRowId => $status) {

                        /*
                    |--------------------------------------------------------------
                    | Security:
                    | Make sure reviewer row belongs to this task.
                    |--------------------------------------------------------------
                    */

                        $reviewer = taskReviewer::where('id', $reviewerRowId)
                            ->where('task_id', $task->id)
                            ->lockForUpdate()
                            ->first();

                        if (!$reviewer) {
                            continue;
                        }


                        /*
                    |--------------------------------------------------------------
                    | Only update when status actually changed
                    |--------------------------------------------------------------
                    */

                        if ($reviewer->status !== $status) {

                            $reviewer->update([

                                'status' => $status,

                                'reviewed_at' => in_array(
                                    $status,
                                    [
                                        'Completed',
                                        'Not Applicable'
                                    ],
                                    true
                                )
                                    ? now()
                                    : null,

                                'returned_date' => null,

                            ]);
                        }
                    }


                    /*
                |--------------------------------------------------------------------------
                | Recalculate Current Reviewer
                |--------------------------------------------------------------------------
                |
                | Find the first reviewer that is NOT:
                |
                | Completed
                | Not Applicable
                |
                */

                    $next = taskReviewer::where(
                        'task_id',
                        $task->id
                    )
                        ->whereNotIn(
                            'status',
                            [
                                'Completed',
                                'Not Applicable'
                            ]
                        )
                        ->orderBy('review_order')
                        ->first();


                    /*
                |--------------------------------------------------------------------------
                | Update reviewLevel
                |--------------------------------------------------------------------------
                */

                    if ($next) {

                        $task->update([
                            'reviewLevel' =>
                            $next->review_order
                        ]);
                    } else {

                        /*
                    |--------------------------------------------------------------
                    | All reviewers completed
                    |--------------------------------------------------------------
                    */

                        $lastReviewer = taskReviewer::where(
                            'task_id',
                            $task->id
                        )
                            ->orderByDesc('review_order')
                            ->first();


                        if ($lastReviewer) {

                            $task->update([
                                'reviewLevel' =>
                                $lastReviewer->review_order + 1
                            ]);
                        }
                    }
                }


                /*
            |--------------------------------------------------------------------------
            | Assigned Personnel Finished
            |--------------------------------------------------------------------------
            */

                return;
            }


            /*
        |--------------------------------------------------------------------------
        | NORMAL REVIEWER WORKFLOW
        |--------------------------------------------------------------------------
        |
        | Everything below retains your existing reviewer restriction.
        |
        */

            abort_unless(
                (int) $task->reviewLevel >= 1,
                403
            );


            /*
        |--------------------------------------------------------------------------
        | Find Current Reviewer
        |--------------------------------------------------------------------------
        */

            $current = taskReviewer::where(
                'task_id',
                $task->id
            )
                ->whereNotIn(
                    'status',
                    [
                        'Completed',
                        'Not Applicable'
                    ]
                )
                ->orderBy('review_order')
                ->lockForUpdate()
                ->first();


            /*
        |--------------------------------------------------------------------------
        | Only current reviewer can update
        |--------------------------------------------------------------------------
        */

            abort_unless(
                $current &&
                    (int) $current->reviewer_id ===
                    (int) Auth::id(),
                403
            );


            /*
        |--------------------------------------------------------------------------
        | Get Submitted Status
        |--------------------------------------------------------------------------
        */

            $status =
                $data['review_status'][$current->id]
                ?? null;


            abort_unless(
                $status !== null,
                422
            );


            /*
        |--------------------------------------------------------------------------
        | Update Current Reviewer
        |--------------------------------------------------------------------------
        */

            $current->update([

                'status' => $status,

                'reviewed_at' => in_array(
                    $status,
                    [
                        'Completed',
                        'Not Applicable'
                    ],
                    true
                )
                    ? now()
                    : null,

                'returned_date' => null,

            ]);


            /*
        |--------------------------------------------------------------------------
        | Move to Next Reviewer
        |--------------------------------------------------------------------------
        */

            if (
                in_array(
                    $status,
                    [
                        'Completed',
                        'Not Applicable'
                    ],
                    true
                )
            ) {

                $next = taskReviewer::where(
                    'task_id',
                    $task->id
                )
                    ->whereNotIn(
                        'status',
                        [
                            'Completed',
                            'Not Applicable'
                        ]
                    )
                    ->orderBy('review_order')
                    ->first();


                $task->update([

                    'reviewLevel' => $next
                        ? $next->review_order
                        : $current->review_order + 1

                ]);
            }
        });


        return back()->with(
            'success',
            'Task updated successfully.'
        );
    }

    // for file management page(papmanagement.blade)

    public function papmanagement()

    {

        $paps = Paps::all();

        $papOptions = Paps::all();

        $users = User::all()

            ->where('usertype', '!=', 'admin');



        $fund = fundSource::all();

        $division = divisions::all();

        $sector = Sector::all();

        $oos = ooSupported::all();



        $paptask = Paptask::all();



        $paptasks = DB::table('paptask')

            ->join('paps', 'paptask.papID', '=', 'paps.id')

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

            'paptasks',

            'papOptions',

            'users',

            'fund',

            'division',

            'sector',

            'oos'

        ));
    }



    public function taskdisposition()

    {

        $fund = fundSource::all();

        $paps = Paps::all();

        $papOptions = Paps::all();

        $users = User::all()

            ->where('usertype', '!=', 'admin');



        $fund = fundSource::all();

        $division = divisions::all();

        $sector = Sector::all();

        $oos = ooSupported::all();



        $paptask = Paptask::all();



        $newtask = DB::table('paps')

            ->select('paps.*')

            ->get();



        return view('Task.taskdisposition', compact('newtask', 'fund', 'paps', 'papOptions', 'users', 'division', 'sector', 'oos'));
    }



    public function newtask($id)

    {

        $fund = fundSource::all();

        $paps = Paps::all();

        $papOptions = Paps::all();

        $users = User::all()

            ->where('usertype', '!=', 'admin');



        $division = divisions::all();

        $sector = Sector::all();

        $oos = ooSupported::all();

        $fund = fundSource::all();



        $pap = DB::table('paps')

            ->leftjoin('users', 'paps.userID', '=', 'users.id')

            ->leftjoin('fundsource', 'paps.fundID', '=', 'fundsource.id')

            ->leftjoin('divisions', 'paps.divID', '=', 'divisions.id')

            ->leftjoin('outputsupported', 'paps.oosID', '=', 'outputsupported.oosID')

            ->where('paps.id', $id)

            ->select('paps.*', 'users.name as focalPerson', 'fundsource.fundName as fundName', 'divisions.*', 'outputsupported.oosName', 'paps.id as newID', 'paps.id as papsID')

            ->first();





        $newtask = DB::table('papmanagement')

            ->join('paps', 'papmanagement.papID', '=', 'paps.id')

            ->where('papmanagement.papID', $id)

            ->select('papmanagement.id as newID', 'papmanagement.*', 'paps.pap')

            ->get();



        $newtaskforpap = DB::table('paptask')

            ->where('paptask.papID', $id)

            ->select('paptask.*')

            ->get();



        $link = DB::table('tasks')

            ->leftjoin('papmanagement', 'tasks.PAP', '=', 'papmanagement.id')

            ->leftjoin('paps', 'papmanagement.papID', '=', 'paps.id')

            ->leftjoin('paptask', 'tasks.task', '=', 'paptask.id')

            ->leftjoin('users as ASSIGNED', 'tasks.assigned', '=', 'ASSIGNED.id')

            ->where('paps.id', $id)

            ->where('link', '!=', null)

            ->select('tasks.*', 'paptask.tasks as taskname', 'ASSIGNED.name as assignedName')

            ->orderBy('tasks.activitydate', 'asc')

            ->get()

            ->groupBy('activitydate');





        return view('Task.newtask', compact('pap', 'newtask', 'fund', 'paps', 'papOptions', 'users', 'division', 'sector', 'oos', 'newtaskforpap', 'link'));
    }

    public function qrReview($token)
    {
        // Find the task using the QR token
        $task = DB::table('tasks')
            ->join('papmanagement', 'tasks.PAP', '=', 'papmanagement.id')
            ->join('paps', 'papmanagement.papID', '=', 'paps.id')
            ->join('paptask', 'tasks.task', '=', 'paptask.id')
            ->where('tasks.qr_review_token', $token)
            ->select(
                'tasks.id',
                'tasks.qr_review_token',
                'tasks.activitydate',
                'tasks.duedate',
                'tasks.reviewLevel',
                'paps.pap',
                'paptask.tasks as task'
            )
            ->first();

        abort_if(!$task, 404);

        // Get all dynamic reviewers
        $reviewers = DB::table('task_reviewers')
            ->leftJoin('users', 'task_reviewers.reviewer_id', '=', 'users.id')
            ->where('task_reviewers.task_id', $task->id)
            ->select(
                'task_reviewers.*',
                'users.name as reviewer_name'
            )
            ->orderBy('task_reviewers.review_order')
            ->get();

        // Find the first unfinished reviewer
        $currentReviewer = $reviewers->first(function ($reviewer) {
            return !in_array(
                $reviewer->status,
                ['Completed', 'Not Applicable'],
                true
            );
        });

        return view('Task.qr-review', [
            'task' => $task,
            'reviewers' => $reviewers,
            'currentReviewer' => $currentReviewer,
        ]);
    }

    public function qrReviewUpdate(Request $request, $token)
    {
        $data = $request->validate([
            'status' => [
                'required',
                'in:Received,Signed'
            ],
        ]);

        DB::transaction(function () use ($data, $token) {

            $task = Task::where('qr_review_token', $token)
                ->lockForUpdate()
                ->firstOrFail();

            abort_unless(
                (int) $task->reviewLevel >= 1,
                403
            );

            // Current dynamic reviewer
            $current = taskReviewer::where('task_id', $task->id)
                ->whereNotIn('status', [
                    'Completed',
                    'Not Applicable'
                ])
                ->orderBy('review_order')
                ->lockForUpdate()
                ->first();

            abort_unless(
                $current,
                422,
                'No active reviewer found.'
            );

            /*
        |--------------------------------------------------------------------------
        | RECEIVED
        |--------------------------------------------------------------------------
        */

            if ($data['status'] === 'Received') {

                abort_unless(
                    in_array(
                        $current->status,
                        ['Pending', 'In Progress'],
                        true
                    ),
                    422,
                    'Document cannot be marked as received.'
                );

                $current->update([
                    'status' => 'Received',
                    'reviewed_at' => null,
                    'returned_date' => null,
                ]);

                return;
            }


            /*
        |--------------------------------------------------------------------------
        | SIGNED
        |
        | "Signed" is only the QR display/action.
        | Actual database value = Completed.
        |--------------------------------------------------------------------------
        */

            if ($data['status'] === 'Signed') {

                abort_unless(
                    in_array(
                        $current->status,
                        ['Received', 'In Progress'],
                        true
                    ),
                    422,
                    'Document must be received before it can be signed.'
                );

                $current->update([
                    'status' => 'Completed',
                    'reviewed_at' => now(),
                    'returned_date' => null,
                ]);


                /*
            |--------------------------------------------------------------------------
            | Find Next Reviewer
            |--------------------------------------------------------------------------
            */

                $next = taskReviewer::where('task_id', $task->id)
                    ->whereNotIn('status', [
                        'Completed',
                        'Not Applicable'
                    ])
                    ->orderBy('review_order')
                    ->first();


                /*
            |--------------------------------------------------------------------------
            | Keep reviewLevel synchronized
            |--------------------------------------------------------------------------
            */

                $task->update([
                    'reviewLevel' => $next
                        ? $next->review_order
                        : $current->review_order + 1
                ]);
            }
        });


        return back()->with(
            'success',
            'Document status updated successfully.'
        );
    }
} //end of class
