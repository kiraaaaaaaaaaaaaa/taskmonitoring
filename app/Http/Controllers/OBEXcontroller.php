<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\mooe;
use App\Models\SectorProgram;
use App\Models\Subprogram;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class OBEXcontroller extends Controller
{
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

       return view('obexmamangement', ['program'=>$program, 'subprogram'=>$subprogram, 'mooe'=>$mooe]);
    }

    public function storeprogram(Request $request)
    {
        if($request->id)
            {
                SectorProgram::where('id', $request->id)->update([
            'programname' => $request->secname,
            
            ]);
            return back()->with('success', 'Program updated successfully.');
            }
        else
        {
            SectorProgram::create([
           
            'programname' => $request->secname,
            'FY' => now()->year
            
        ]);

        return back()->with('success', 'Program created successfully.');
        }
    }
    public function storesubprogram(Request $request)
    {
        if($request->editprogid)
            {
                Subprogram::where('id', $request->editprogid)->update([
                'subprogramname' => $request->editsubname,
                ]);
                return back()->with('success', 'Sub-program updated successfully.');
            
            }
            else
            {
                Subprogram::create([
                'subprogramname' => $request->subname,
                'programID' => $request->subid,
                'FY' => now()->year
                ]);
                return back()->with('success', 'Sub-program created successfully.');
            }
        
            
        
    }
    public function storeobex(Request $request)
    {
        if($request->editobexid)
        {
            mooe::where('mooeID', $request->editobexid)->update([
            'mooeName' => $request->editobexname,
            ]);
            return back()->with('success', 'OBEX updated successfully.');
        }
        else
        {
            mooe::create([
            'mooeName' => $request->obexname,
            'subprogramID' => $request->obexID,
            'type' => $request->type,
            'FY' => now()->year
            ]);

            return back()->with('success', 'Sub-program created successfully.');
        }
           
    }

    public function deleteprogram($id)
    {
        SectorProgram::where('id', $id)->delete();
        return back()->with('success', 'Program deleted successfully.');
    }
    public function deletesubprogram($id)
    {
        Subprogram::where('id', $id)->delete();
        return back()->with('success', 'Sub-program deleted successfully.');
    }
    public function deleteobex($id)
    {
        mooe::where('mooeID', $id)->delete();
        return back()->with('success', 'OBEX deleted successfully.');
    }
}
