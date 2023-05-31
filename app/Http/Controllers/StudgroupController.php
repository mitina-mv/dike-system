<?php

namespace App\Http\Controllers;

use App\Models\Studgroup;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class StudgroupController extends Controller
{
    public function index()
    {
        return view('studgroup.index');
    }

    public function create(Request $request)
    {
        try {
            Studgroup::create([
                'studgroup_name' => $request->name,
                'org_id' => Auth::user()->org_id
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => "Не удалось создать группу"
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => "Сохранение выполнено успешно"
        ], Response::HTTP_CREATED);
    }
}
