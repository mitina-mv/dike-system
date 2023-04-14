<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Studgroup;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Http\Request;

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

    public function update(ProfileRequest $request, $id)
    {
        dd($request);
    }
}