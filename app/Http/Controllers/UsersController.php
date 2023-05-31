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
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

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

        // get users by role 2
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
            $user['groups'] = implode(', ', 
                array_column(
                    $user->studgroups()->select('studgroup_name')->get()->all(),
                    'studgroup_name'
                )
            );
        }
        
        $teacherColumns = [
            ['name' => 'ФИО', 'code' => 'user_firstname'],
            ['name' => 'Email', 'code' => 'user_email'],
            ['name' => 'Группы', 'code' => 'groups'],
            ['name' => 'Действия', 'code' => 'buttons'],
        ];
        
        return view('users.index', compact('arGroupsStudent', 'teachers', 'teacherColumns'));
    }
    
    public function createTeacher()
    {
        $studgroups = Studgroup::select(['id', 'studgroup_name'])
            ->where([
                'org_id' => Auth::user()->org_id
            ])
            ->orderBy('id', 'asc', 'studgroup_name')
            ->pluck('studgroup_name', 'id');

        return view('users.create_teacher', compact('studgroups'));
    }

    public function createStudent()
    {
        $studgroups = Studgroup::select(['id', 'studgroup_name'])
            ->where([
                'org_id' => Auth::user()->org_id
            ])
            ->pluck('studgroup_name', 'id');

        return view('users.create_student', compact('studgroups'));
    }

    public function storeTeacher(Request $request)
    {
        try {
            DB::transaction(function() use ($request) {
                $orgID = Auth::user()->org_id;

                $request->validate([
                    'items' => 'array|required',
                    'items.*.group' => ['array', 'required'],
                    'items.*.group.*id' => ['integer'],
                    'items.*.lastname' => ['required', 'string', 'max:255'],
                    'items.*.firstname' => ['required', 'string', 'max:255'],
                    'items.*.patronymic' => ['nullable', 'string', 'max:255'],
                    'items.*.user_email' => ['required', 'string', 'email', 'max:255', 'unique:users']
                ]);
        
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
                            $keys[]['key'] = $user->id . "_" . (int)$group;
                        }
                        
                        // add bind teacher_studgroup
                        $user->studgroups()->attach(
                            array_combine(
                                $item['group'],
                                $keys
                            )
                        );
                    }
                }
            });
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => "Ошибки при заполнении полей. В первую очередь проверьте почту - скорее всего она уже занята. Кроме того, как минимум одна группа студентов должна быть выбрана.",
            ], Response::HTTP_BAD_REQUEST);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }


        return response()->json([
            'message' => "Сохранение выполнено успешно"
        ], Response::HTTP_CREATED);
    }

    public function storeStudent(Request $request)
    {
        try {
            DB::transaction(function() use ($request) {

                $request->validate([
                    'items' => 'array|required',
                    'items.*.studgroup' => ['integer', 'required'],
                    'items.*.lastname' => ['required', 'string', 'max:255'],
                    'items.*.firstname' => ['required', 'string', 'max:255'],
                    'items.*.patronymic' => ['nullable', 'string', 'max:255'],
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
            });
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => "Сохранение выполнено успешно"
        ], Response::HTTP_CREATED);
    }

    public function destroy($id)
    {
        if($id != Auth::user()->id) {
            try {
                $user = User::find($id);
                $user->delete();
            } catch(Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Ошибка при удалении. Возможно, пользователь был удален ранее. Попробуйде обновить страницу"
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => "Себя удалять нельзя"
            ], Response::HTTP_BAD_REQUEST);
        }
    
        return response()->json([
            'message' => "Пользователь удален"
        ], Response::HTTP_OK);
    }
}
