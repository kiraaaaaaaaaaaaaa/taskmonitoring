<?php

namespace App\Http\Controllers;

use App\Models\adjustedhistory;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Paps;
use App\Models\paptask;
use App\Models\Budget;
use App\Models\mooe;
use App\Models\SectorProgram;
use App\Models\Subprogram;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $program = SectorProgram::all();
        $subprogram = DB::table('subprogram')
            ->join('sectorprogram', 'subprogram.programID', '=', 'sectorprogram.id')
            ->select('subprogram.*', 'sectorprogram.programname')
            ->get();
        $mooe = DB::table('mooe')
            ->join('subprogram', 'mooe.subprogramID', '=', 'subprogram.id')
            ->select('mooe.*', 'subprogram.id')
            ->get();
        $capitaloutlay = DB::table('capitaloutlay')
            ->join('subprogram', 'capitaloutlay.subprogramID', '=', 'subprogram.id')
            ->select('capitaloutlay.*', 'subprogram.id')
            ->get();

        $totalbudgetperprogram = DB::table('mooe')
            ->join('subprogram', 'mooe.subprogramID', '=', 'subprogram.id')
            ->leftJoin('sectorprogram', 'subprogram.programID', '=', 'sectorprogram.id')
            ->select(
                'sectorprogram.id',
                'subprogram.subprogramname',

                'sectorprogram.programname',
                DB::raw('SUM(mooe.budgetallotment) AS total_amount')
            )
            ->groupBy(
                'sectorprogram.id',
                'subprogram.id',

            )
            ->get();

        $totalobligationperprogram = DB::table('tasks')
        ->join('mooe','tasks.allocatedbudget', '=', 'mooe.mooeID')
        ->leftJoin('subprogram', 'mooe.subprogramID', '=', 'subprogram.id')
        ->leftJoin('sectorprogram', 'subprogram.programID', '=', 'sectorprogram.id')
        ->select(
            'sectorprogram.id as secID',
            
            DB::raw('SUM(tasks.obligatedbudget) AS totalobligatedperprogram')
            )
        ->groupBy('sectorprogram.id'
                )
        ->get();

       

        $totalobligation = DB::table('tasks')
        ->select(DB::raw('SUM(tasks.obligatedbudget) AS totalobligation'))
        ->get();

        $totalbudgetperobex = DB::table('tasks')
            ->join('mooe', 'tasks.allocatedbudget', '=', 'mooe.mooeID')
            ->select(
                'tasks.allocatedbudget',
                'mooe.mooeID',

                DB::raw('SUM(tasks.obligatedbudget) AS totalbudget')
            )
            ->groupBy('mooe.mooeID')
            ->get();

        $budgetperobex = DB::table('tasks')
            ->leftJoin('mooe', 'tasks.allocatedbudget', '=', 'mooe.mooeID')
            ->leftJoin('papmanagement', 'tasks.PAP', '=', 'papmanagement.id')
            ->leftJoin('paps', 'papmanagement.papID', '=', 'paps.id')
            ->leftJoin('paptask', 'tasks.task', '=', 'paptask.id')
            ->select(
                'tasks.*',
                'mooe.mooeID',
                'mooe.mooeName',
                'paptask.tasks',
                'paps.pap',

            )
            ->get();

            



        $totalmooe = DB::table('mooe')
            ->select(DB::raw('SUM(budgetallotment) as grandtotal, SUM(adjustedbudget) as totaladjusted'))
            ->get();

        $totalmooeperprogram = DB::table('mooe')
            ->leftJoin('subprogram', 'mooe.subprogramID', '=', 'subprogram.id')
            ->leftJoin('sectorprogram', 'subprogram.programID', '=', 'sectorprogram.id')
            ->select(DB::raw('SUM(mooe.budgetallotment) as grandtotal, SUM(mooe.adjustedbudget) as totaladjusted'), 'mooe.subprogramID', 'mooe.type','sectorprogram.id', 'subprogram.id')
            ->groupBy('sectorprogram.id', 'mooe.type', 'mooe.subprogramID')
            ->get();
        
        $totalobligationmooeperprogram = DB::table('tasks')
        ->join('mooe','tasks.allocatedbudget', '=', 'mooe.mooeID')
        ->leftJoin('subprogram', 'mooe.subprogramID', '=', 'subprogram.id')
        ->leftJoin('sectorprogram', 'subprogram.programID', '=', 'sectorprogram.id')
        ->select(
            'sectorprogram.id as secID', 'subprogram.id as subID', 'mooe.type',
            
            DB::raw('SUM(tasks.obligatedbudget) AS totalobligatedperprogram')
            )
        ->groupBy('sectorprogram.id' , 'subprogram.id', 'mooe.type')
        ->get();
       

       

        $adjustmenthistory = DB::table('adjustedhistory')

            ->leftJoin('mooe as tomooe', 'adjustedhistory.toobexID', '=', 'tomooe.mooeID')
            ->leftJoin('subprogram as tosubprogram', 'tomooe.subprogramID', '=', 'tosubprogram.id')
            ->leftJoin('sectorprogram as tosectorprogram', 'tosubprogram.programID', '=', 'tosectorprogram.id')

            ->leftJoin('mooe as frommooe', 'adjustedhistory.fromobeID', '=', 'frommooe.mooeID')
            ->leftJoin('subprogram as fromsubprogram', 'frommooe.subprogramID', '=', 'fromsubprogram.id')
            ->leftJoin('sectorprogram as fromsectorprogram', 'fromsubprogram.programID', '=', 'fromsectorprogram.id')

            ->select([
                'adjustedhistory.*',

                'tomooe.mooeName as to_mooe',
                'tosubprogram.subprogramname as to_subprogram',
                'tosectorprogram.programname as to_program',

                'frommooe.mooeName as from_mooe',
                'fromsubprogram.subprogramname as from_subprogram',
                'fromsectorprogram.programname as from_program'
            ])
            ->get();

            //======for co

            $totalbudgetperobexforco = DB::table('tasks')
            ->join('capitaloutlay', 'tasks.allocatedbudget', '=', 'capitaloutlay.coID')
            ->select(
                'tasks.allocatedbudget',
                'capitaloutlay.coID',

                DB::raw('SUM(tasks.obligatedbudget) AS totalbudget')
            )
            ->groupBy('capitaloutlay.coID')
            ->get();

          


        return view(
            'budget',
            [
                'program' => $program,
                'subprogram' => $subprogram,
                'mooe' => $mooe,
                'totalbudgetperprogram' => $totalbudgetperprogram,
                'totalmooe' => $totalmooe,
                'totalbudgetperobex' => $totalbudgetperobex,
                'adjustmenthistory' => $adjustmenthistory,
                'budgetperobex' => $budgetperobex,
                'totalobligationperprogram' => $totalobligationperprogram,
                'totalobligation' => $totalobligation,
                'capitaloutlay' => $capitaloutlay,
                'totalbudgetperobexforco' => $totalbudgetperobexforco,
                'totalmooeperprogram' => $totalmooeperprogram,
                'totalobligationmooeperprogram' => $totalobligationmooeperprogram
            ]
        );
    }


    public function store(Request $request)
    {
        mooe::where('mooeID', $request->obex)->update(
            [
                'budgetallotment' => $request->allocatedbudget,
                'adjustedbudget' => $request->allocatedbudget
            ]
        );



        return back()->with('success', 'Budget alloted');
    }

    public function adjustbudget(Request $request)
    {

        DB::table('adjustedhistory')
            ->insert([
                'fromobeID' => $request->fromobex,
                'toobexID' => $request->toobex,
                'adjustedamount' => $request->allocatedbudget,
                'created_at' => now()
            ]);

        //add adjustment
        mooe::where('mooeID', $request->toobex)
            ->update(
                [
                    'adjustedbudget' => DB::raw('adjustedbudget + ' . $request->allocatedbudget)
                ]
            );

        //subtract adjustemtn
        mooe::where('mooeID', $request->fromobex)
            ->update(
                [
                    'adjustedbudget' => DB::raw('adjustedbudget - ' . $request->allocatedbudget)
                ]
            );

        return back()->with('sucess', 'Budget Adjusted');
    }
}
