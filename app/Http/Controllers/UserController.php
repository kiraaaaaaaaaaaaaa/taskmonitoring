<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        return view('users.userpage',['user'=>$user]);
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
        ]);
    } else {

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'position' => 'required|string',
            'usertype' => 'required|string',
            'password' => $request->id ? 'nullable' : 'required'
        ]);
        // CREATE
        User::create([ 
            'name' => $request->name,
            'email' => $request->email,
            'position' => $request->position,
            'usertype' => $request->usertype,
            'password' => bcrypt($request->password),
        ]);
    }

        return redirect()-> route('user management');
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
