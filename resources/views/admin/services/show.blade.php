@extends('admin.layout')

@section('title', 'Информация о услуге')

@section('content')
    <h2>Информация о услуге</h2>
    <div>
        <div><b>{{ $service->Title }}</b></div>
        <div>Цена: {{ $service->Price }} ₽</div>
        <div>Категория: {{ $service->Breed_category }}</div>
        <a href="{{ route('admin.services.edit', $service->ID_Services) }}" class="btn small">Редактировать</a>
        <a href="{{ route('admin.services.index') }}" class="btn small">Назад</a>
    </div>
@endsection
