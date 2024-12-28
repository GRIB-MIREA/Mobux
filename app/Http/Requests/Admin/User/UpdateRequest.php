<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'string|email|unique:users'.$this->user->id,
            'password' => 'string',
            'telegram_id' => 'integer',
            'telegram_username' => 'string',
            'image' => 'file',
            'telegram_token' => 'string',
            'role' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Это поле необходимо для заполнения',
            'name.string' => 'Это поле должно быть строкой',
            'email.required' => 'Это поле необходимо для заполнения',
            'email.string' => 'Это поле должно быть строкой',
            'email.email' => 'Почта должна соответствовать формату mail@domain.com',
            'email.unique' => 'Пользователь с таким email уже существует',
        ];
    }
}
