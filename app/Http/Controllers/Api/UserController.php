<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with(['roles'])->get();
        return response()->json($users);
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
            $user->assignRole(Role::find($request->role));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try{
            $user->delete();
            return response()->json(['success' => TRUE, 'message' => 'User removed.'],200);
        }
        catch(\Exception $e){
            return response()->json(['success' => FALSE, 'message' => 'Error removing the user'],200);
        }
    }
}
