<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Role;
use App\Models\Discipline;
use App\Models\Test;
use Exception;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    private array $column = [
        [
            'title' => 'Название теста',
            'field' => 'test_name',
            'sorter' => 'string',
            'headerFilter' => true,
            'headerFilterPlaceholder' => "Поиск по названию",
        ],
        [
            'title' => 'Описание теста',
            'field' => 'test_description',
            'headerFilter' => false,
            'width' => '300'
        ],        
        [
            'title' => 'Кол-во вопросов',
            'field' => 'question_count',
            'sorter' => 'number',
            'width' => '150'
        ],
    ];

    private function checkRules() 
    {
        switch(Auth::user()->role_id) {
            case Role::ROLE_TEACHER:
                return true;
            default:
                return false;
        }
    }

    public function index()
    {
        if(!$this->checkRules())
        {
            $error = 'Вы не имеете достаточных прав на это действие';
            return view('tests.index', compact('error'));
        }

        $tmptests = Test::where([
            'user_id' => Auth::user()->id
        ])->get();

        $discipline = Discipline::orderBy('discipline_name', 'asc')->get()->all();
        
        $tests = [];
        foreach($tmptests as $test)
        {
            $item = $test;
            $item['question_count'] = $test->questionCount();
            $tests[$test->discipline_id][] = $item;
        }

        // удаление дисциплин, на которые не тестов
        foreach($discipline as $key => $d)
        {
            if(!isset($tests[$d->id])) 
                unset($discipline[$key]);
        }

        $columns = $this->column;

        return view('tests.index', compact('tests', 'discipline', 'columns'));
    }

    public function formCreate()
    {        
        if(!$this->checkRules())
        {
            $error = 'Вы не имеете достаточных прав на это действие';
            return view('tests.index', compact('error'));
        }

        $discipline = Discipline::orderBy('discipline_name', 'asc')
                        ->pluck('discipline_name', 'id');

        return view('tests.form', compact('discipline'));
    }

    public function read($id)
    {
        if(!$this->checkRules())
        {
            $error = 'Вы не имеете достаточных прав на это действие';
            return view('tests.index', compact('error'));
        }

        $discipline = Discipline::orderBy('discipline_name', 'asc')
                        ->pluck('discipline_name', 'id');
        $user = Auth::user();
        $test = Test::where([
            'user_id' => $user->id,
            'id' => $id
        ])->first();

        if(empty($test))
        {
            return response()->json([
                'status' => 'error',
                'message' => "Вероятно, вы запрашиваете тест, который вам не принадлежит. Не надо так, мы все видим."
            ], Response::HTTP_BAD_REQUEST);
        }


        return view('tests.form', compact('discipline', 'test'));
    }

    public function create(Request $request)
    {
        if(!$this->checkRules()){
            return response()->json([
                'status' => 'error',
                'message' => "Вы не имеете право добавления тестов. Не знаем, как вы попали сюда, но очень негодуем."
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = Auth::user();

        $test = Test::create([
            'test_description' => isset($request->desc) ? $request->desc : null,
            'test_settings' => json_encode([
                'question_count' => $request->countQuestion
            ]),
            'test_name' => $request->name,
            'org_id' => $user->org_id,
            'user_id' => $user->id,
            'discipline_id' => $request->discipline
        ]);
        
        return response()->json([
            'message' => "Запись успешно создана!",
            'id' => $test->id
        ], Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        if(!$this->checkRules()){
            return response()->json([
                'status' => 'error',
                'message' => "Вы не имеете право добавления тестов. Не знаем, как вы попали сюда, но очень негодуем."
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = Auth::user();
        $test = Test::where([
            'user_id' => $user->id,
            'id' => $id
        ])->first();

        if(empty($test))
        {
            return response()->json([
                'status' => 'error',
                'message' => "Вероятно, вы запрашиваете тест, который вам не принадлежит. Не надо так, мы все видим."
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $test->update([
                'test_description' => isset($request->desc) ? $request->desc : null,
                'test_settings' => json_encode([
                    'question_count' => $request->countQuestion
                ]),
                'test_name' => $request->name,
                'discipline_id' => $request->discipline
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => "При обновлении что-то пошло не так ("
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => "Все изменения сохранены!"
        ], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        
    }
}
