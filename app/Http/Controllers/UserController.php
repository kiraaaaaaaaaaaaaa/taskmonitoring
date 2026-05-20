<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use App\Models\usertype;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function redirectToGoogle()
    {

    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sector = Sector::all();
        $utypes = usertype::all();
        $divisions = DB::table('divisions')
        ->join('sector', 'sector.id', '=', 'divisions.sectorID')
        ->select('sector.*', 'divisions.*')
        ->get();

        $user = DB::table('users')
        ->join('divisions', 'users.divisionID', '=', 'divisions.id')
        ->leftjoin('usertype', 'users.usertype', '=', 'usertype.id')
        ->select('users.*', 'divisions.division_short_name', 'divisions.division_name', 'usertype.position as usertype')
        ->get();
        return view('users.userpage',['user'=>$user, 'divisions'=>$divisions, 'sector'=>$sector, 'utypes'=>$utypes]);
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
       
        if ($request->id) {
        // UPDATE
        User::where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'position' => $request->position,
            'usertype' => $request->usertype,
            'password' => bcrypt($request->password),
            'divisionID' => $request->division,
            'sectorID' => $request->sector,
        ]);
        return back()->with('success', 'User updated successfully.');
    } else {

        // CREATE
        User::create([ 
            'name' => $request->name,
            'email' => $request->email,
            'position' => $request->position,
            'usertype' => $request->usertype,
            'password' => bcrypt($request->password),
            'divisionID' => $request->division,
            'sectorID' => $request->sector,
        ]);
        $request->session()->flash('success', 'User created successfully.');
    }

        return redirect()-> route('user management');
    }

    public function newusertype(Request $request)
    {
        
        usertype::create([
            'position' => $request->newUserType,
            
        ]);
        return back()->with('success', 'New user type added successfully.');
    }

    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

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
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
