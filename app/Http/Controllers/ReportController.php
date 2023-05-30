<?php

namespace App\Http\Controllers;

use App\Models\Answerlog;
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
}
