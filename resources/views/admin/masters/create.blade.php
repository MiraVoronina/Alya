@extends('admin.layout')

@section('title', 'Добавить мастера')

@section('content')
    <h2>Добавить мастера (мастера/админа)</h2>
    <form method="POST" action="{{ route('admin.masters.store') }}">
        @csrf
        <div>
            <label for="login">Логин</label>
            <input type="text" name="login" id="login" required>
        </div>
        <div>
            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div>
            <label for="name">Имя мастера</label>
            <input type="text" name="name" id="name" required>
        </div>
        <button type="submit" class="btn">Сохранить</button>
    </form>
@endsection
