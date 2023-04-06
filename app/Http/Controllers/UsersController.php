<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\UserAddRequest;

use App\Models\Role;
use App\Models\Studgroup;
use App\Models\User;


class UsersController extends Controller
{
    public function createTeacher()
    {
        $studgroups = Studgroup::select(['id', 'studgroup_name'])
            ->where([
                'org_id' => Auth::user()->org_id
            ])
            ->get();

        return view('users.create_teacher', compact('studgroups'));
    }

    public function createStudent()
    {
        $studgroups = Studgroup::select(['id', 'studgroup_name'])
            ->where([
                'org_id' => Auth::user()->org_id
            ])
            ->get();

        return view('users.create_student', compact('studgroups'));
    }

    public function storeTeacher(Request $request)
    {
        dd($request);
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
            'items' => 'array|required',
            'items.*.studgroup' => ['integer', 'required'],
            'items.*.lastname' => ['required', 'string', 'max:255'],
            'items.*.firstname' => ['required', 'string', 'max:255'],
            'items.*.patronymic' => ['string', 'max:255'],
            'items.*.user_email' => ['required', 'string', 'email', 'max:255', 'unique:users']
        ]);

        foreach($request->items as $item)
        {
            User::create([
                'user_firstname' => $item['firstname'],
                'user_lastname' => $item['lastname'],
                'user_patronymic' => $item['patronymic'] ?: null,
                'user_email' => $item['user_email'],
                'password' => Hash::make($item['user_email']),
                'role_id' => 3,
                'org_id' => Auth::user()->org_id,
                'studgroup_id' => $item['studgroup']
            ]);
        }

        return view('users.create_student');
    }
}
