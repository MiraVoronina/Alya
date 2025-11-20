<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'login' => 'required|string|min:4|max:16|unique:users,Login',
            'email' => 'required|email|max:100|unique:users,Avatar_url',
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/',
            ],
            'agree' => 'accepted',
            'photo' => 'nullable|image|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'login.required' => 'Введите логин',
            'login.unique' => 'Данный логин уже занят',
            'login.min' => 'Минимум 4 символа',
            'login.max' => 'Максимум 16 символов',
            'email.required' => 'Введите email',
            'email.email' => 'Некорректный email',
            'email.unique' => 'Email уже зарегистрирован',
            'password.required' => 'Введите пароль',
            'password.confirmed' => 'Пароли не совпадают',
            'password.min' => 'Пароль минимум 6 символов',
            'password.regex' => 'Пароль должен содержать буквы и цифры',
            'agree.accepted' => 'Необходимо согласие на обработку данных',
            'photo.image' => 'Фото должно быть изображением',
            'photo.max' => 'Максимальный размер фото — 2MB',
        ];
    }
}
