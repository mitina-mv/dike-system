<?php

namespace App\Http\Controllers;

use App\Models\Testlog;
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
            DB::raw("count(test_id) as count_test"),
        )
        ->orderBy('year')
        ->groupBy(
            DB::raw("to_char(testlog_date, 'YYYY')"),
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

        // чтобы вывести группы студентов, которым назначен тест
        $usersIdTestLogs = Testlog::where([
            'teacher_id' => Auth::user()->id,
        ])
        ->where(DB::raw("to_char(testlog_date, 'YYYY')"), '=', $year)
        ->select(
            'test_id',
            'testlog_date',
            'studgroups.studgroup_name'
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

        foreach($testLogs as &$testLog)
        {
            $testLog['groups'] = array_unique($testLog['groups']);
        }

        return response()->json($testLogs, Response::HTTP_OK);
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
        # code...
    }
    public function create()
    {
        # code...
    }
    public function destroy($id)
    {
        # code...
    }
}
