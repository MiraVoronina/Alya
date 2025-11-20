@extends('admin.layout')

@section('title', 'Информация о мастере')

@section('content')
    <h2>Информация о мастере</h2>
    <div>
        <div><b>ID: {{ $master->ID_Master }}</b></div>
        <div>Имя: {{ $master->name }}</div>
        <div>Дата создания: {{ $master->Created_at }}</div>
        <a href="{{ route('admin.masters.edit', $master->ID_Master) }}" class="btn small">Редактировать</a>
        <a href="{{ route('admin.masters.index') }}" class="btn small">Назад</a>
    </div>
@endsection
