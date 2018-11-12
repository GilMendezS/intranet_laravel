<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Resquests\CreateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->lastname = $request->lastname ?? '';
        $user->phone = $request->phone ?? '';
        $user->email  = $request->email;
        if($request->password){
            $user->password = bcrypt($request->password);
        }
        try {
            $user->save();
            return response()->json(['success' => TRUE, 'message' => 'User created.'], 200);
        }
        catch(\Exception $e){
            return response()->json(['success' => FALSE, 'message' => 'Error creating the user.'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $user = User::with(['roles'])->findOrFail($id);
            return response()->json(['success' => TRUE, 'data' => $user]);
        }
        catch(\Exception $e){
            return response()->json(['success' => FALSE, 'message' => 'User not found'], 404);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = new User();
        $user->name = $request->name;
        $user->lastname = $request->lastname ?? '';
        $user->phone = $request->phone ?? '';
        $user->email  = $request->email;
        if($request->password){
            $user->password = bcrypt($request->password);
        }
        try {
            $user->save();
            return response()->json(['success' => TRUE, 'message' => 'User created.'], 200);
        }
        catch(\Exception $e){
            return response()->json(['success' => FALSE, 'message' => 'Error creating the user.'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
}
