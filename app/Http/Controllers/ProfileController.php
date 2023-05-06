<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Studgroup;

use Exception;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index($id)
    {
        if($id == Auth::user()->id){
            $user = Auth::user();
        } else {
            $user = User::where([
                'id' => $id,
                'org_id' => Auth::user()->org_id
            ])->first();
        }

        if(!isset($user))
        {
            $data['title'] = '404';
            $data['message'] = 'Ошибка доступа. Профиль не существует или он не принадлежит этой организации';
            $data['back_url'] = url()->previous();
            return response()->view('errors.404', compact('data'), 404);
        }

        $studgroups = Studgroup::where([
            'org_id' => Auth::user()->org_id
        ])->get()->all();

        // TODO сделать нормальную раоту с моделями к коллекции (получение атрибутов)
        if($user->role_id == 2) {
            $groups = $user
                ->studgroups()
                ->select('id')
                ->get()
                ->all();
            
            $tmp = [];

            foreach($groups as $group)
            {
                $tmp[] = $group->id;
            }

            $user['groups'] = $tmp;
        }

        return view('profile.index', compact('user', 'studgroups'));
    }

    public function update(ProfileRequest $request)
    {
        $user = User::find([$request->id])->first();


        // обновление привязок по группам
        if($request->groups) {
            // generate primary keys
            $keys = array();
            $i = 0;
            foreach($request->groups as $group)
            {
                $keys[] = [
                    'key' => $user->id . "_" . $group
                ];
            }
            
            // add bind teacher_studgroup
            // если привязка у
            try {
                $user->studgroups()->sync(
                    array_combine(
                        $request->groups,
                        $keys
                    )
                );
            } catch(Exception $e) {
                return redirect()->route('profile.index', $user->id)->withInputs()->withErrors([
                    'message' => 'Не удалось обновить пользователя. Попробуйте позже, ошибка уже в работе.'
                ]);
            }
        }

        // обновление пользователя
        $updateDataUser = $request->validated();
        unset($updateDataUser['groups']);
        unset($updateDataUser['id']);

        if(isset($updateDataUser['password']) 
            && $updateDataUser['password']
        ) {
            $updateDataUser['password'] = Hash::make($updateDataUser['password']);
        } else {
            unset($updateDataUser['password']);
        }

        try {
            $user->update($updateDataUser);
        } catch(Exception $e) {
            return redirect()->route('profile.index', $user->id)->withErrors([
                'message' => 'Не удалось обновить пользователя. Попробуйте позже, ошибка уже в работе.',
                'error' => $e->getMessage()
            ]);
        }

        return redirect()->route('profile.index', $user->id)->with('message', 'Успешно обновлено!');
    }
}
