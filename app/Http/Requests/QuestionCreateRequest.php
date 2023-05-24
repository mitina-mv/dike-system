<?php

namespace App\Http\Requests;

use App\Models\Discipline;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as ValidationRule;


class QuestionCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string', 'max:511'
            ],
            'private' => ['required', 'boolean'],
            'discipline' => [
                'required', 
                'integer', 
                ValidationRule::in(Discipline::select('id')->pluck('id'))
            ],
            'mark' => ['required', 'numeric', 'min:1'],
            'type' => ['required', 'string', 'in:single,multiple,text'],
            'answers' => ['required', 'array']
        ];
    }
}
