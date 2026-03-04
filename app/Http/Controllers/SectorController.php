<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use App\Models\divisions;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { 
        $sector = Sector::all();
       $divisions = DB::table('divisions')
       ->join('sector', 'sector.id', '=', 'divisions.sectorID')
       ->select('sector.*', 'divisions.*')
       ->get();

       return view('sectormanagement', ['sector'=>$sector, 'divisions'=>$divisions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->id)
            {
            Sector::where('id', $request->id)->update([
            'sector_short_name' => $request->secshortname,
            'sector_long_name' => $request->secname,
            
            ]);
            return back()->with('success', 'Sector updated successfully.');
        } 
        else {
        $request->validate([
            'secname' => 'required|string',
            'secshortname' => 'required|string',
        ]);

        Sector::create([
            'sector_short_name' => $request->secshortname,
            'sector_long_name' => $request->secname,
            
        ]);

        return back()->with('success', 'Sector created successfully.');
        }
    }
    public function storeDivision(Request $request)
    {
   
       if($request->divID)
            {
            divisions::where('id', $request->divID)->update([
            'sectorID' => $request->sectorID,
            'division_name' => $request->division_names,
            'division_short_name' => $request->division_short_names,
            
            ]);
            return back()->with('success', 'Division updated successfully.');
        } 
        else {


        divisions::create([
            'sectorID' => $request->sectorID,
            'division_name' => $request->division_name,
            'division_short_name' => $request->division_short_name,
        ]);

        return back()->with('success', 'Division created successfully.');
    }
    }

    public function deleteSector($id)
    {
        
        Sector::where('id', $id)->delete();
        return back()->with('success', 'Sector deleted successfully.');
    }

    public function deleteDivision($id)
    {
        divisions::where('id', $id)->delete();
        return back()->with('success', 'Division deleted successfully.');
    }
}
