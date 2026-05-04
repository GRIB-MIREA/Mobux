<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8',
            'telegram_id' => 'nullable|integer',
            'telegram_username' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'telegram_token' => 'nullable|string',
            'role' => ['required', 'integer', Rule::in([0, 1])],
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
            'password.required' => 'Это поле необходимо для заполнения',
            'password.string' => 'Это поле должно быть строкой',
        ];
    }
}
