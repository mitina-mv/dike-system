<?php

namespace App\Http\Controllers;

use App\Models\Studgroup;
use App\Models\Test;
use App\Models\Testlog;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class AssignmentController extends Controller
{
    public function index()
    {
        // забираем года и количество назначенных тестов
        $yearsTestLog = Testlog::where([
            'teacher_id' => Auth::user()->id,
        ])
        ->select(
            DB::raw("to_char(testlog_date, 'YYYY') as year"),
            DB::raw("count(id) as count_test"),
        )
        ->orderBy('year')
        ->groupBy(
            'year'
        )
        ->get()
        ->toArray();
        
        return view('assignment.index', compact('yearsTestLog'));
    }

    public function list($year){
        // забираем назначенные тесты
        $tmpTestLogs = Testlog::where([
            'teacher_id' => Auth::user()->id,
        ])->where(DB::raw("to_char(testlog_date, 'YYYY')"), '=', $year)
        ->select(
            'test_id',
            'testlog_date',
            'tests.test_name'
        )
        ->join('tests', 'tests.id', '=', 'testlogs.test_id')
        ->orderBy('testlog_date')
        ->groupBy(
            'testlog_date',
            'test_id',
            'tests.test_name'
        )
        ->get();

        if(empty($tmpTestLogs->all()))
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Ошибка при получении списка тестов. Для этого года тестов нет'
            ], Response::HTTP_BAD_REQUEST);
        }

        // чтобы вывести группы студентов, которым назначен тест
        $usersIdTestLogs = Testlog::where([
            'teacher_id' => Auth::user()->id,
        ])
        ->where(DB::raw("to_char(testlog_date, 'YYYY')"), '=', $year)
        ->select(
            'test_id',
            'testlog_date',
            'studgroups.studgroup_name',
        )
        ->join('users', 'users.id', '=', 'testlogs.user_id')
        ->join('studgroups', 'users.studgroup_id', '=', 'studgroups.id')
        ->get()
        ->all();

        foreach($tmpTestLogs as $testlog)
        {
            $testLogs[$testlog->test_id . "_" . $testlog->testlog_date] = $testlog->toArray();
        }

        foreach($usersIdTestLogs as $userlog)
        {
            $testLogs[$userlog->test_id . "_" . $userlog->testlog_date]['groups'][] = $userlog->studgroup_name;
        }

        $arResult = [];
        foreach($testLogs as &$testLog)
        {
            $testLog['groups'] = implode(
                ", ", 
                array_unique($testLog['groups'])
            );
            $testLog['format-date'] = (new DateTime($testLog['testlog_date']))->format('Y-m-d H:i');

            $arResult[] = $testLog;
        }

        return response()->json($arResult, Response::HTTP_OK);
    }
    
    public function read($test_id, $date){
        $testLog = Testlog::where([
            'teacher_id' => Auth::user()->id,
            'test_id' => $test_id,
            'testlog_date' => $date
        ])
        ->select(
            'users.user_firstname',
            'users.user_lastname',
            'users.user_patronymic',
            'studgroups.studgroup_name',
            'users.studgroup_id',
        ) 
        ->join('users', 'users.id', '=', 'testlogs.user_id')
        ->join('studgroups', 'users.studgroup_id', '=', 'studgroups.id')
        ->get()
        ->all();

        $testUserInfo = [];
        foreach($testLog as $user)
        {
            if(!isset($testUserInfo[$user->studgroup_id])) {
                $testUserInfo[$user->studgroup_id] = [
                    'name' => $user->studgroup_name,
                    'users' => []
                ];
            }

            $testUserInfo[$user->studgroup_id]['users'][] = $user->toArray();
        }

        return response()->json($testUserInfo, Response::HTTP_OK);
    }

    public function formCreate()
    {
        $user = Auth::user();
        
        // список доступныех тестов
        $tests = Test::where([
            'user_id' => $user->id
        ])->get()->all();

        // получение групп, у которых преподаем
        // и их студентов
        $studgroups = $user->studgroups()
            ->with('students')
            ->get()->all();

        return view('assignment.form', compact('studgroups', 'tests'));
    }

    public function create()
    {
        # code...
    }


    public function destroyAll($test_id, $date)
    {
        try {
            // удаляем все привязки
            DB::transaction(function() use ($test_id, $date) {
                $testLogs = Testlog::where([
                    'teacher_id' => Auth::user()->id,
                    'test_id' => $test_id,
                    'testlog_date' => $date
                ])->get()->all();

                foreach($testLogs as $tl)
                {
                    $answerLogs = $tl->answerlogs()->get()->all();
                    foreach($answerLogs as $al)
                    {
                        $al->delete();
                    }
                    $tl->delete();
                }
            });
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'У меня не получается удалить этот тест'
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Удаление успешно!'
        ], Response::HTTP_OK);
    }
}
