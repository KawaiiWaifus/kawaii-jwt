<?php

namespace App\Api\V1\Controllers\Admin\Roles;

use App\Permission,
    App\Role, App\User,
    Illuminate\Http\Request,
    App\Api\V1\Controllers\Controller,
    Illuminate\Support\Facades\Auth,
    JWTAuth, Tymon\JWTAuth\Exceptions\JWTException,
    Log;

class RolesControllers extends Controller
{
    
    public function index()
    {
        return response()->json(['auth'=> Auth::user(), 'users' => User::all()]);
    }

    public function createRole(Request $request){

        $role = new Role();
        $role->name = $request->input('name');
        $role->save();

        return response()->json("created");

    }

    public function createPermission(Request $request){

        $viewUsers = new Permission();
        $viewUsers->name = $request->input('name');
        $viewUsers->save();

        return response()->json("created");

    }

    public function assignRole(Request $request){
        $user = User::where('email', '=', $request->input('email'))->first();

        $role = Role::where('name', '=', $request->input('role'))->first();
        // $user->attachRole($request->input('role'));
        $user->roles()->attach($role->id);

        return response()->json("created");
    }

    public function attachPermission(Request $request){
        $role = Role::where('name', '=', $request->input('role'))->first();
        $permission = Permission::where('name', '=', $request->input('name'))->first();
        $role->attachPermission($permission);

        return response()->json("created");
    }

    public function checkRoles(Request $request){
        $user = User::where('email', '=', $request->input('email'))->first();
        Log::info($user);
        return response()->json([
            "user" => $user,
            "owner" => $user->hasRole('owner'),
            "admin" => $user->hasRole('admin'),
            "editUser" => $user->can('edit-user'),
            "listUsers" => $user->can('list-users')
        ]);
    }

}
