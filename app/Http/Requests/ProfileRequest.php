<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'user_firstname' => ['required', 'string', 'max:255'],
            'user_lastname' => ['required', 'string', 'max:255'],
            'user_patronymic' => ['nullable', 'string', 'max:255'],
            'user_email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'studgroup_id' => ['nullable', 'integer'],
            'groups' => ['nullable', 'array']
        ];
    }
}
