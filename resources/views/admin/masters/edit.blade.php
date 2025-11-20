@extends('admin.layout')

@section('title', 'Редактировать мастера')

@section('content')
    <h2>Редактировать мастера</h2>
    <form method="POST" action="{{ route('admin.masters.update', $master->ID_Master) }}">
        @csrf
        @method('PUT')
        <div>
            <label for="name">Имя</label>
            <input type="text" name="name" id="name" value="{{ $master->name }}" required>
        </div>
        <button type="submit" class="btn">Сохранить</button>
    </form>
@endsection
