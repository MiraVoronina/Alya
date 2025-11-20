@extends('admin.layout')

@section('title', 'Услуги')

@section('content')
    <h2 class="title">Услуги</h2>
    <a href="{{ route('admin.services.create') }}" class="btn" style="margin-bottom:20px;">Добавить услугу</a>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Цена</th>
            <th>Категория</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($services as $service)
            <tr>
                <td>{{ $service->ID_Services }}</td>
                <td>{{ $service->Title }}</td>
                <td>{{ $service->Price }}</td>
                <td>{{ $service->Breed_category }}</td>
                <td>
                    <a href="{{ route('admin.services.show', $service->ID_Services) }}" class="btn small">Подробнее</a>
                    <a href="{{ route('admin.services.edit', $service->ID_Services) }}" class="btn small">Редактировать</a>
                    <form action="{{ route('admin.services.destroy', $service->ID_Services) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn small" onclick="return confirm('Удалить?')">Удалить</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
