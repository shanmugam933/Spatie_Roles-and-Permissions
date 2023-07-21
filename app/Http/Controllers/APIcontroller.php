<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class APIcontroller extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            // 'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        $response['token'] = $user->createToken('Myapp')->plainTextToken;
        $response['name'] = $user->name;
        $response['roles'] = $user->roles->pluck('name');

         return response()->json($response, 200);

    }

    public function show(Request $request){

        $email = $request->input('email');
        $password = $request->input('password');

        if(Auth::attempt(['email' => $email, 'password' => $password])){
            $user = Auth::user();
            $response['token'] = $user->createToken('Myapp')->plainTextToken;
            $response['name'] = $user->name;
            $response['roles'] = $user->roles->pluck('name');

                return response()->json($response, 200);
         }else{
            return response()->json(['message'=>"invalid user"], 403);
         }
    }

    public function detail(){
            $user =   Auth::user();

            $data = [
                "name" => $user->name,
                "email" => $user->email,
                "roles" => $user->roles->pluck('name')
            ];
            $response['user'] = $data;
            return response()->json($response, 200);

    }

    public function getstaff() {
        // Check if the user is authenticated
        if (auth()->check()) {
            $user = auth()->user();

            // Retrieve user details and roles
            $data = [
                "name" => $user->name,
                "email" => $user->email,
                "roles" => $user->roles->pluck('name')
            ];

            // Retrieve staff roles and associated users
            $staffRoles = Role::where('name', 'staff')->get();
            $staffData = [];
            foreach ($staffRoles as $role) {
                $staffData[$role->name] = User::whereHas('roles', function ($query) use ($role) {
                    $query->where('name', $role->name);
                })->get()->pluck('name');
            }


            $response['user'] = $data;
            $response['staff_roles'] = $staffData;

            return response()->json($response, 200);
        } else {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
    }


}
