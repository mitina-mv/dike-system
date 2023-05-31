<?php

namespace App\Http\Controllers;

use App\Models\Answerlog;
use App\Models\Discipline;
use App\Models\Role;
use App\Models\Test;
use App\Models\Testlog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;
use Illuminate\Support\Str;


// use Illuminate\View\View;

class ReportController extends Controller
{
    private static function getDetailReport($testlog_id){
        $testlog = Testlog::find($testlog_id);

        if($testlog->user_id !== Auth::user()->id
            && Auth::user()->role_id !== Role::ROLE_TEACHER
        ) {
            $error = 'Вы не имеете достаточных прав на это действие';
            return compact('error');
        }

        $test = Test::find($testlog->test_id);
        $student = User::where('id', $testlog->user_id)
        ->with('studgroup')->first();

        $questions = Answerlog::where([
            'testlog_id' => $testlog->id
        ])
        ->with('get_answer')
        ->with('question')
        ->with('question.correct_answers')
        ->get()->all();

        $web = request()->route()->getName() == 'report.student';

        return compact('questions', 'testlog', 'test', 'student', 'web');
    }
    // данные для генерации страницы
    public function studentDetailReport($testlog_id)
    {
        $data = self::getDetailReport($testlog_id);
        return view('reports.student', $data);
    }

    public static function getDataStudgroupsTestReport($test_id, $date)
    {
        // данные о назначении
        $testlogs = Testlog::where([
            'teacher_id' => Auth::user()->id,
            'test_id' => $test_id,
            'testlog_date' => $date
        ])
        ->get()->all();

        if(Auth::user()->role_id !== Role::ROLE_TEACHER
            || empty($testlogs)
        ) {
            $error = 'Вы не имеете достаточных прав на это действие';
            return compact('error');
        }

        $test = Test::find($test_id);
        $discipline = Discipline::find($test->discipline_id);

        $studgroups = [];
        foreach($testlogs as $tl)
        {
            $student = $tl->user()->first();

            if(!isset($studgroups[$student->studgroup_id])) {
                $studgroup = $student->studgroup()->select('id', 'studgroup_name')->first();

                $studgroups[$studgroup->id] = [
                    'name' => $studgroup->studgroup_name,
                    'users' => []
                ];
            }

            $item['full_name'] = "{$student->user_lastname} {$student->user_firstname} {$student->user_patronymic}";
            $item['mark'] = $tl->testlog_mark;

            $studgroups[$student->studgroup_id]['users'][] = $item;
        }
     
        $web = request()->route()->getName() == 'report.studgroups';

        return compact('studgroups', 'test', 'date', 'web', 'discipline');
    }
    // страница результаты групп
    public function studgroupsTestReport($test_id, $date)
    {
        $data = self::getDataStudgroupsTestReport($test_id, $date);
        return view('reports.studgroups', $data);
    }

    // функция генерации pdf
    public function generate_testlog($testlog_id)
    {
        $data = self::getDetailReport($testlog_id);

        $html = View::make('reports.student', $data)->render();
        
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        $filename = $data['testlog']->testlog_date . " " . $data['test']->test_name . " " . $data['student']->studgroup->studgroup_name . " " . $data['student']->user_lastname . " " . uniqid();
        $mpdf->Output( Str::slug($filename, '-').".pdf", 'D');
    }

    // функция генерации pdf
    public function generate_studgroups($test_id, $date)
    {
        $data = self::getDataStudgroupsTestReport($test_id, $date);

        $html = View::make('reports.studgroups', $data)->render();
        
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        $filename = $data['date'] . " " . $data['test']->test_name . uniqid();
        $mpdf->Output( Str::slug($filename, '-').".pdf", 'D');
    }
}
