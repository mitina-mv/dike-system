<?php

namespace App\Http\Controllers;

use App\Http\Requests\DisciplineRequest;
use App\Models\Discipline;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\RedirectResponse;

class DisciplineController extends Controller
{
    public function index()
    {
        return view('discipline.index');
    }

    public function create(DisciplineRequest $request)
    {
        try {
            $discipline = Discipline::create([
                'discipline_name' => $request->name,
                'code' => $request->code
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => "Не удалось создать дисциплину. Возможно, она уже существует."
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => "Сохранение выполнено успешно"
        ], Response::HTTP_CREATED);
    }
}
