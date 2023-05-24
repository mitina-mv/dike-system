<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

use App\Models\Role;

use Illuminate\Support\Str;

class DisciplineRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
                'string', 'max:255'
            ], 
            'code' => ['required', 'string', 'unique:disciplines,code']
        ];
    }
    public function messages()
    {
        return [
            '*.required' => 'Поле :attribute обязательно',
            'code.unique' => 'Дисциплина с таким названием уже существует!'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'code' => Str::slug(request()->get('name'), '')
        ]);
    }
}
