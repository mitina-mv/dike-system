<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\UserAddRequest;

use App\Models\Role;
use App\Models\Studgroup;
use App\Models\User;
use Exception;

class UsersController extends Controller
{
    public function index()
    {
        $studgroups = Studgroup::select(['id', 'studgroup_name'])
            ->where([
                'org_id' => Auth::user()->org_id
            ])
            ->get();

        $arGroupsStudent = [];
        foreach($studgroups as $group)
        {
            $arGroupsStudent[] = [
                'name' => $group['studgroup_name'],
                'id' => $group['id'],
                'students' => User::select([
                        'id', 
                        'user_firstname',
                        'user_lastname',
                        'user_patronymic',
                        'user_email',
                    ])->where([
                        'studgroup_id' => $group['id'],
                        'role_id' => 3
                    ])->get()
            ];
        }

        $teachers = User::select([
            'id', 
            'user_firstname',
            'user_lastname',
            'user_patronymic',
            'user_email',
        ])->where([
            'role_id' => 2,
            'org_id' => Auth::user()->org_id
        ])->get();

        foreach($teachers as &$user)
        {
            $user['groups'] = $user->studgroups()->select('studgroup_name')->get()->all();
        }

        return view('users.index', compact('arGroupsStudent', 'teachers'));
    }
    
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
        $orgID = Auth::user()->org_id;
        
        $request->validate([
            'items' => 'array|required',
            'items.*.group' => ['array', 'required'],
            'items.*.group.*id' => ['integer'],
            'items.*.lastname' => ['required', 'string', 'max:255'],
            'items.*.firstname' => ['required', 'string', 'max:255'],
            'items.*.patronymic' => ['string', 'max:255'],
            'items.*.user_email' => ['required', 'string', 'email', 'max:255', 'unique:users']
        ]);

        try {
            foreach($request->items as $item)
            {
                $user = User::create([
                    'user_firstname' => $item['firstname'],
                    'user_lastname' => $item['lastname'],
                    'user_patronymic' => $item['patronymic'] ?: null,
                    'user_email' => $item['user_email'],
                    'password' => Hash::make($item['user_email']),
                    'role_id' => 2,
                    'org_id' => $orgID
                ]);
    
                // add relationship studgroup
                if($item['group']) {
                    // generate primary keys
                    $keys = [];
                    foreach($item['group'] as $group)
                    {
                        $keys[]['key'] = $user->id . "_" . $group['id'];
                    }
                    
                    // add bind teacher_studgroup
                    $user->studgroups()->attach(
                        array_combine(
                            array_column($item['group'], 'id'),
                            $keys
                        )
                    );
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'произошла ошибка в ходе добавления пользователей',
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);

        }

        return response()->json(['message' => 'записи успешно добавлены'], 200);
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

        return view('users.index');
    }
}
