<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use App\Models\Question;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    private function checkRules() 
    {
        switch(Auth::user()->role_id) {
            case Role::ROLE_ADMIN:
            case Role::ROLE_TEACHER:
                return true;
            case Role::ROLE_STUDENT:
            default:
                return false;
        }
    }

    public function index()
    {
        if($this->checkRules())
        {
            $user = Auth::user();
            $discipline = Discipline::orderBy('discipline_name', 'asc')->get()->all();

            switch($user->role_id)
            {
                case Role::ROLE_TEACHER:
                    $tmpQuestions = Question::where([
                        'org_id' => $user->org_id,
                        'user_id' => $user->id
                    ])->get()->all();
                    break;

                case Role::ROLE_ADMIN:
                default:
                    $tmpQuestions = Question::where([
                        'org_id' => $user->org_id,
                        'question_private' => false
                    ])->get()->all();
            }


            foreach($tmpQuestions as $question)
            {
                $questions[$question->discipline_id][] = $question;
            }

            return view('question.index', compact('questions', 'discipline'));

        } else {
            $error = 'Вы не имеете достаточных прав на это действие';
            return view('question.index', compact('error'));
        }
    }
}
