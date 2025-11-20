@extends('admin.layout')

@section('title', 'Мастера')

@section('content')
    <h2 class="title">Мастера</h2>
    <a href="{{ route('admin.masters.create') }}" class="btn" style="margin-bottom:20px;">Добавить мастера</a>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Дата создания</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($masters as $master)
            <tr>
                <td>{{ $master->ID_Master }}</td>
                <td>{{ $master->name }}</td>
                <td>{{ $master->Created_at }}</td>
                <td>
                    <a href="{{ route('admin.masters.show', $master->ID_Master) }}" class="btn small">Подробнее</a>
                    <a href="{{ route('admin.masters.edit', $master->ID_Master) }}" class="btn small">Редактировать</a>
                    <form action="{{ route('admin.masters.destroy', $master->ID_Master) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn small" onclick="return confirm('Удалить мастера?')">Удалить</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
