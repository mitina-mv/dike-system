<?php

namespace App\Http\Controllers;

use App\Models\Answerlog;
use App\Models\Question;
use App\Models\Role;
use App\Models\Studgroup;
use App\Models\Test;
use App\Models\Testlog;
use App\Models\User;
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
        ->whereYear('testlog_date', $year)
        // ->where(DB::raw("to_char(testlog_date, 'YYYY')"), '=', $year)
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
        ])
        ->select('id', 'test_name')
        ->pluck('test_name', 'id');

        // получение групп, у которых преподаем
        // и их студентов
        $tmpstudgroups = $user->studgroups()
            ->with('students')
            ->get()->toArray();
        
        if(empty($tmpstudgroups) || empty($tests))
        {
            $error = 'У вас пока нет тестов или не привязаны группы. Создайте шаблоны тестов. Если проблема не решается, обратитесь к администратору от организации.';
            return view('assignment.form', compact('studgroups', 'tests'));
        }

        $studgroups = [];
        foreach($tmpstudgroups as $studgroup)
        {
            $item = [];
            $item['name'] = $studgroup['studgroup_name'];

            foreach($studgroup['students'] as $student)
            {
                $item['students']["_" . $student['id']] = "{$student['user_lastname']} {$student['user_firstname']} {$student['user_patronymic']}";
            }

            $studgroups[$studgroup['id']] = $item;
        }

        // dd($studgroups);
        return view('assignment.form', compact('studgroups', 'tests'));
    }

    public function create(Request $request)
    {
        try {
            DB::transaction(function() use ($request) {
                // получаем пользователей по id
                $students = User::where([
                    'id' => $request->users,
                    'role_id' => Role::ROLE_STUDENT
                ])->get()->all();

                if(empty($students)){
                    throw new Exception("Пользователи не определены.");
                }
    
                // информация о тесте
                $test = Test::find($request->test);
                // $countQuestion = json_decode($test->test_settings, false)->question_count;
                $countQuestion = 2;

                foreach($students as $user)
                {
                    // по дисциплине и количеству вопросов забираем
                    // рандомные <countQuestion> вопросов
                    $questions = Question::where([
                        ['question_private',  "=",  false],
                        ['discipline_id',  "=", $test->discipline_id],
                    ])
                    ->orWhere([
                        ['question_private',  "=",  true],
                        ['discipline_id',  "=", $test->discipline_id],
                        ['user_id',  "=", Auth::user()->id],
                    ])
                    ->inRandomOrder()
                    ->limit($countQuestion)
                    ->get()->all();
        
                    if(($count = count($questions)) !== $countQuestion)
                    {
                        throw new Exception("Подготовьте банк вопросов на эту тему. На текущий момент требуется {$countQuestion} из них найдено {$count}");
                    }
        
                    // создаем testlog
                    $testLog = Testlog::create([
                        'testlog_date' => new DateTime($request->date),
                        'user_id' => $user->id,
                        'test_id' => $test->id,
                        'teacher_id' => Auth::user()->id,
                    ]);
        
                    // создаем answerlog
                    foreach($questions as $q)
                    {
                        $answerLog = Answerlog::create([
                            'question_id' => $q->id,
                            'testlog_id' => $testLog->id
                        ]);
                    }
                }
            });
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Все добавлено!'
        ], Response::HTTP_OK);
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
