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
            return redirect()->route('question.index');
        } catch (Exception $e) {
            $error = $e->getMessage();
            return view('discipline.index', compact('error'));
        }
    }
}
