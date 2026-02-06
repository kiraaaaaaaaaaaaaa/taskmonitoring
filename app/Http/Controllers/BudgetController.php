<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Paps;
use App\Models\paptask;
use App\Models\Budget;

use App\Models\Task;
use Illuminate\Support\Facades\DB;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $budget = DB::table('budget')
        ->join('paps', 'budget.budgetPAP', '=', 'paps.id')
        ->leftJoin('tasks', 'budget.id', '=', 'tasks.allocatedbudget')
        ->select(
                'budget.*',
                'paps.pap',
                DB::raw('SUM(tasks.costing) AS total')
        )
        ->groupBy('budget.id')
        ->get();
        $paps = Paps::all();

     

        


        return view('budget', ["budget" => $budget, "paps"=>$paps]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->id)
            {
            Budget::where('id', $request->id)->update([
            'allocatedbudget' => $request->budget,
            
            ]);
            session()->flash('success', 'Budget updated successfully.');
            }
        else
            {
            $validate = $request-> validate(
            [
                'budgetPAP' => 'required|string',
                'allocatedbudget' => 'required',
                'FY' => 'required'
            ]
           
            );
            session()->flash('success', 'Budget created successfully.');
            Budget::create($validate);
        }
        

        
        return redirect()-> route('budget management');
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
