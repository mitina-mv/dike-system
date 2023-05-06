<?php

namespace App\Http\Requests;

use App\Models\User;

use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Проверка на возможность вносить изменения
     * Юзер с id существует и привязан к этой организации - для админа
     * или
     * Юзер существует и авторизованный пользователь правит свой провиль
     *
     * @return bool
     */
    public function authorize()
    {
        $user = User::find([$this->route('id')])->first();

        return (
            Auth::user()->role_id == 1 
            && $user 
            && $user->org_id == Auth::user()->org_id
        ) || (
            $user
            && $user->id == Auth::user()->id
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required', 'integer'],
            'user_firstname' => ['required', 'string', 'max:255'],
            'user_lastname' => ['required', 'string', 'max:255'],
            'user_patronymic' => ['nullable', 'string', 'max:255'],
            'user_email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults(), 'min:8'],
            'studgroup_id' => ['nullable', 'integer'],
            'groups' => ['nullable', 'array'],
            'groups.*' => ['required', 'integer']
        ];
    }

    public function messages()
    {
        return [
            'password.confirmed' => 'Пароли не совпадают. Введите снова.',
            'password.min' => 'Минимальная длина пароля 8 символов',
            'studgroup_id.integer' => 'Неудачно определена группа, попробуйдет снова',
            'groups.*.integer' => 'Неудачно определены группы, попробуйдет снова'
        ];
    }

    protected function prepareForValidation()
    {
        // dd(request());
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }
}
