<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Answerlog;
use App\Models\Discipline;
use App\Models\Question;
use App\Models\Testlog;
use DateInterval;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class StudentTestController extends Controller
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
            'title' => 'Преподаватель',
            'field' => 'teacher_name',
            'sorter' => 'string',
            'headerFilter' => true,
            'headerFilterPlaceholder' => "Поиск по ФИО",
        ],
        [
            'title' => 'Дата тестирования',
            'field' => 'format-date',
            'headerFilter' => false,
        ],
        [
            'title' => 'Затраченое время',
            'field' => 'testlog_time',
            'headerFilter' => false,
            'width' => '150'
        ],
        [
            'title' => 'Оценка',
            'field' => 'testlog_mark',
            'sorter' => 'number',
            'width' => '100'
        ],
    ];

    public function index()
    {
        $testLogs = Testlog::where([
            'testlogs.user_id' => Auth::user()->id
        ])
        ->select(
            'testlogs.*',
            'tests.test_name',
            'tests.discipline_id',
            'users.user_lastname', // препод
            'users.user_firstname',
            'users.user_patronymic',
        )
        ->join('users', 'users.id', '=', 'testlogs.teacher_id')
        ->join('tests', 'tests.id', '=', 'testlogs.test_id')
        ->orderBy('testlog_date')
        ->get()->all();
        
        if(empty($testLogs))
        {
            $error = 'Назначенных тестирований пока нет';
            return view('studenttest.index', compact('error'));
        }

        $tests = [];
        foreach($testLogs as &$tl)
        {
            $tl['teacher_name'] = "{$tl->user_lastname} {$tl->user_firstname} {$tl->user_patronymic}";
            $dateTest = new DateTime($tl['testlog_date']);
            $tl['format-date'] = $dateTest->format('Y-m-d H:i');

            $start_ts = strtotime($tl['testlog_date']);
            $end_ts = $start_ts + 1800;
            
            $now = time();
            
            if(($now >= $start_ts) && ($now <= $end_ts) && !$tl['testlog_mark'])
            {
                $tl['active_test'] = true; 
            } else if($now < $start_ts) {
                $tl['active_test'] = -1; 
            }
            else {
                $tl['active_test'] = false; 
            }
        
            $tl['get_report'] = $tl['active_test'] ? false : true;

            $tests[$tl->discipline_id][] = $tl;
        }

        $discipline = Discipline::whereIn('id', array_keys($tests))
            ->orderBy('discipline_name', 'asc')
            ->get()->all();

        $columns = $this->column;

        return view('studenttest.index', compact('tests', 'discipline', 'columns'));
    }

    public function getReport($testlog_id)
    {
        # code...
    }

    public function testing($testlog_id)
    {
        $structureTest = [];
        try {
            $structureTest = DB::transaction(function() use ($testlog_id) {
                $testlog = Testlog::where([
                    'testlogs.id' => $testlog_id,
                    'testlogs.user_id' => Auth::user()->id
                ])
                ->select(
                    'tests.test_name',
                    'testlog_date',
                    'testlogs.id',
                    'testlogs.testlog_mark'
                )
                ->join('tests', 'tests.id', '=', 'testlogs.test_id')
                ->first();
        
                // проверка существования тестирвования
                if(empty($testlog))
                {
                    throw new Exception("Это тестирование не для Вас!", 1);
                }
                // проверка на отсуствие оценки
                if($testlog['testlog_mark'])
                {
                    throw new Exception("Вы уже прошли данное тестирование", 1);
                }

                // проверка что время не прошло
                $start_ts = strtotime($testlog->testlog_date);
                $end_ts = $start_ts + 1800;
                
                $now = time();
                if(($now < $start_ts) || ($now > $end_ts))
                {
                    throw new Exception("Тестирование недоступно по времени", 1);
                }
        
                // получаем вопросы
                $questions = Answerlog::where([
                    'testlog_id' => $testlog->id
                ])
                ->select(
                    'answerlogs.id AS answerlog_id',
                    'question_text',
                    'question_settings',
                    'question_id',
                )
                ->join('questions', 'questions.id', '=', 'answerlogs.question_id')
                ->orderBy('answerlog_id')
                ->get()->all();
        
                $structureTest = [
                    'title' => $testlog->test_name,
                    'pages' => []
                ];
                // dump($anwsers);
                // получаем все ответы
                foreach($questions as $q)
                {
                    // определяем тип вопроса
                    $typeQuestion = json_decode($q->question_settings, false)->type;

                    switch($typeQuestion){
                        case 'multiple':
                            $surveyType = 'checkbox';
                            break;
                        case 'text':
                            $surveyType = 'text';
                            break;
                        case 'single':
                        default:
                            $surveyType = 'radiogroup';
                            break;
                    };
                    
                    // забираем ответы
                    $anwsers = [];
                    if($surveyType != 'text')
                    {
                        $anwsers = Answer::where([
                            ["question_id", '=', $q->question_id]
                        ])->get()->all();
                    }

                    // генерируем страницу вопроса
                    $page = [
                        'title' => $q->question_text,
                        'elements' => [[
                            'name' => (string) $q->question_id,
                            "isRequired" => true,
                            'type' => $surveyType,
                            'title' => $surveyType == 'text' ? 'Ваш ответ:' : 'Выберите ответ:'
                        ]]
                    ];

                    if($surveyType == 'checkbox' || $surveyType == 'radiogroup')
                    {
                        // dd($anwsers);
                        foreach($anwsers as $ans)
                        {
                            $page['elements'][0]['choices'][] = [
                                'value' => $ans->id,
                                'text' => $ans->answer_name
                            ];
                            $page['elements'][0]['choicesOrder'] = 'random';
                        }
                    }
                     
                    $structureTest['pages'][] = $page;
                }

                return $structureTest;
            });
        } catch (Exception $e) {
            if($e->getCode() == 1)
            {
                $error = $e->getMessage();
            } else {
                $error = 'В ходе составления теста были допущены непоправимые ошибки. Повторите запрос позднее.';
            }

            return view('testing.index', compact('error'));
        }

        return view('testing.index', compact('structureTest', 'testlog_id'));
    }

    

    public function writeResult(Request $request, $testlog_id)
    {
        // dd(array_keys($request->answers));
        try {
            $mark = DB::transaction(function() use ($testlog_id, $request) {
                // проверка существования тестирования
                if (!Testlog::where([
                        ['id', '=', $testlog_id],
                        ['user_id', '=', Auth::user()->id]
                    ])->exists()
                ) {
                    throw new Exception("Ошибка в определении назначенного тестирования. Тест, который Вы пытаетесь сохранить, назначен не на Вас.", 1);
                }

                // полный перечень вопросов теста
                $answerlogs = Answerlog::where(['testlog_id' => $testlog_id])
                    ->with('question')
                    ->with('question.correct_answers')
                    ->get()->all();

                // dd($answerlogs);
                $countCorrectAnswers = 0;
                $fullCountCorrectAnswers = 0;

                foreach($answerlogs as $alog)
                {
                    // ответ пользователя
                    $getAnswer = isset($request->answers[$alog->question_id]) ? $request->answers[$alog->question_id] : null;
                    // если ничего не пришло - фиксируем 0 оценку за ответ
                    if(!$getAnswer)
                    {
                        $alog->update(['answerlog_mark' => 0]);
                        continue;
                    }

                    // если ответ есть
                    // узнаем тип вопроса
                    $typeQuestion = json_decode($alog->question->question_settings, false)->type;

                    // решаем как оценивать
                    switch($typeQuestion) {
                        case 'multiple': {
                            // получаем все правильные ответы
                            $correctAnswers = $alog->question->correct_answers;
                            $correctIds = array_column($correctAnswers->toArray(), 'id');

                            $fullCountCorrectAnswers += count($correctIds);

                            foreach($getAnswer as $gans)
                            {
                                
                            }

                            break;
                        }
                        case 'text': {
                            $correctAnswers = $alog->question->correct_answers;
                            $correctText = array_map(
                                'mb_strtolower', 
                                array_column($correctAnswers->toArray(), 'answer_name')
                            );
                            ++$fullCountCorrectAnswers;

                            // если текстовый ответ есть
                            // если правильный
                            if($pos = (array_search(mb_strtolower($getAnswer), $correctText)) !== false)
                            {
                                ++$countCorrectAnswers;
                                $answer = $correctAnswers->all()[$pos];

                                $answer->answerlogs()->attach(
                                    $alog->id,
                                    ['key' => "{$answer->id}_{$alog->id}"]
                                );
                                $alog->update(['answerlog_mark' => $alog->question->mark]);
                            } else {
                                // добавить поле невернных текстовых ответов в testlog_id
                            }
                            break;
                        }
                        case 'single': {

                            break;
                        }
                    }
                }
                // $answerlosg = $answerlosgModel->get()->all();
                // dd($answerlosg);
                // $questions = Question::whereIn(
                //     'id', 
                //     $answerlosgModel->select('question_id')->pluck('question_id')
                // )
                // ->with('answers')
                // ->get()->all();
                // dd($questions);
                
                // if(!$questions) {
                //     throw new Exception("Вопросы определены неверно", 1);
                // }
            });
        } catch (Exception $e) {
            if($e->getCode() == 1)
            {
                $error = $e->getMessage();
            } else {
                $error = 'В процессе сохранения ответов возникла ошибка';
            }
            return response()->json([
                'status' => 'error',
                // 'message' => $error
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'mark' => $mark . "из 100",
        ], Response::HTTP_OK);
    }
}
