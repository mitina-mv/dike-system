<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\Http\Requests\UserAddRequest;

use App\Models\Role;
use App\Models\Studgroup;
use App\Models\User;


class UsersController extends Controller
{
    public function createTeacher()
    {
        return view('users.create');
    }

    public function createStudent()
    {
        $studgroups = Studgroup::select(['id', 'studgroup_name'])
            ->where([
                'org_id' => auth()->user->org_id
            ]);

        return view('users.create', compact('studgroups'));
    }


    public function storeTeacher(Request $request)
    {
        $this->store(
            $request, 
            [
                'studgroup' => null,
                'role' => 2
            ]
        );
        
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'studgroup_id' => ['request', 'integer'],
        ]);

        $this->store(
            $request, 
            [
                'studgroup' => $request['studgroup_id'],
                'role' => 3
            ]
        );
    }

    private function store($request, $params)
    {
        User::create([
            'user_firstname' => $request->firstname,
            'user_lastname' => $request->lastname,
            'user_patronymic' => $request->patronymic,
            'user_email' => $request->user_email,
            'user_password' => Hash::make($request->password),
            'role_id' => $params['role'],
            'org_id' => auth()->user->org_id,
            'studgroup_id' => $params['studgroup']
        ]);
    }
}
