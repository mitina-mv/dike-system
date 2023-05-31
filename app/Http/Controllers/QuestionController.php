<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionCreateRequest;
use App\Models\Answer;
use App\Models\Discipline;
use App\Models\Question;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Exception;
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
            
            $tmpQuestions = [];
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

            $questions = [];
            foreach($tmpQuestions as $question)
            {
                $questions[$question->discipline_id][] = $question;
            }

            // удаление дисциплин, на которые нет вопросов
            foreach($discipline as $key => $d)
            {
                if(!isset($questions[$d->id])) 
                    unset($discipline[$key]);
            }

            return view('question.index', compact('questions', 'discipline'));

        } else {
            $error = 'Вы не имеете достаточных прав на это действие';
            return view('question.index', compact('error'));
        }
    }

    public function formCreate()
    {
        if($this->checkRules())
        {
            $title = 'Добавление вопроса';
            $discipline = Discipline::orderBy('discipline_name', 'asc')
                ->pluck('discipline_name', 'id');
            
            return view('question.form', compact('title', 'discipline'));
        } else {
            $error = 'Вы не имеете достаточных прав на это действие';
            return view('question.index', compact('error'));
        }
    }

    // get data for edit form
    public function read($id)
    {
        if($this->checkRules())
        {
            $discipline = Discipline::orderBy('discipline_name', 'asc')
                ->pluck('discipline_name', 'id');
            $title = 'Редактирование вопроса';

            $user = Auth::user();
            
            $question = Question::where([
                'id' => $id,
                'org_id' => $user->org_id,
                // 'user_id' => $user->id
            ])->select([
                'question_private', 
                'question_text', 
                'question_settings', 
                'mark', 
                'discipline_id',
                'id'
            ])->with('answers')->first();

            if(!empty($question))
                return view('question.form', compact('title', 'discipline', 'question'));
            else {
                $error = 'Вы не имеете достаточных прав на это действие';
                return view('question.index', compact('error')); 
            }
        } else {
            $error = 'Вы не имеете достаточных прав на это действие';
            return view('question.index', compact('error'));
        }
    }

    public function create(QuestionCreateRequest $request)
    {
        if($this->checkRules())
        {
            $user = Auth::user();

            // добавление вопроса
            $question = Question::create([
                "question_text" => $request->name,
                "question_private" => $request->private,
                "discipline_id" => $request->discipline,
                "mark" => $request->mark,
                "question_settings" => json_encode([ // TODO расширить (?)
                    'type' => $request->type,
                ]),
                'org_id' => $user->org_id,
                'user_id' => $user->id 
            ]);

            // добавление ответов
            foreach($request->answers as $reqAns)
            {
                $this->answerService($reqAns, $question);
            }

            return response()->json([
                'message' => "Сохранено",
                'question' => $question,
                'answers' => $question->answers()->get()
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => "Вы не имеете право добавления вопросов"
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(QuestionCreateRequest $request, $id)
    {
        if($this->checkRules())
        {
            $user = Auth::user();
            $question = Question::find($id);

            if($user->id == $question->user_id)
            {
                $question->update([
                    "question_text" => $request->name,
                    "question_private" => $request->private,
                    "discipline_id" => $request->discipline,
                    "mark" => $request->mark,
                    "question_settings" => json_encode([ // TODO расширить (?)
                        'type' => $request->type,
                    ])
                ]);
    
                // добавление ответов
                foreach($request->answers as $reqAns)
                {
                    $this->answerService($reqAns, $question);
                }
                
                return response()->json([
                    'message' => "Сохранено. Обновите страницу, чтобы увидеть удаления, если они были"
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => "Вы не имеете право редактирование вопроса"
                ], Response::HTTP_BAD_REQUEST);
            }
            
        } else {
            return response()->json([
                'status' => 'error',
                'message' => "Вы не имеете право редактирование вопроса"
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id)
    {
        if($this->checkRules())
        {
            try {
                $question = Question::find($id);

                if($question->user_id == Auth::user()->id)
                {
                    foreach($question->answers()->get() as $answer){
                        try {
                            $answer->forceDelete();
                        } catch(Exception $e) {
                            $answer->delete();
                        }
                    }
                    // попытка полностью удалить вопрос
                    try {
                        $question->forceDelete();
                    } catch(Exception $e) {
                        // если не получается, то ставим флаг удаления
                        $question->delete();
                    }
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Вы не имеете право удаления этого вопроса."
                    ], Response::HTTP_BAD_REQUEST);
                }
            } catch(Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Ошибка при удалении. Возможно, вопрос был удален ранее. Обновите страницу."
                ], Response::HTTP_BAD_REQUEST);
            }

            return response()->json([
                'message' => "Вопрос удален"
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => "Вы не имеете право удаления этого вопроса."
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function answerService($answerData, $question)
    {
        
        // если новый и сразу удалили 
        if($answerData['id'] == "__new" && $answerData['isDelete'] == true)
            return;

        // если не новый и удалили
        if(is_numeric($answerData['id']) && $answerData['isDelete'] == true)
        {
            $answer = Answer::find($answerData['id']);
            
            try {
                if(isset($answer))
                    $answer->forceDelete();
            } catch(Exception $e) {
                $answer->delete();
            }

            return;
        }

        if(is_numeric($answerData['id']))
        {            
            $answer = Answer::find($answerData['id']);
            $answer->update([
                'answer_name' => $answerData['text'],
                'answer_status' => $answerData['isCorrect']
            ]);

            return;
        }

        if($answerData['id'] == '__new')
        {
            $answer = Answer::create([
                'answer_name' => $answerData['text'],
                'answer_status' => $answerData['isCorrect'],
                'question_id' => $question->id,
            ]);
            return;
        }
    }
}
