<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use App\Models\Testlog;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

            $tl['active_test'] = (new DateTime()) > $dateTest ? false : true;
            $tl['get_report'] = (new DateTime()) > $dateTest ? true : false;

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
}
