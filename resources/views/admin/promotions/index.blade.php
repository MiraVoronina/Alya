@extends('admin.layout')

@section('title', 'Акции')

@section('content')
    <h2 class="title">Акции</h2>
    <a href="{{ route('admin.promotions.create') }}" class="btn" style="margin-bottom:20px;">Добавить акцию</a>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Описание</th>
            <th>Картинка</th>
            <th>Дата создания</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($promotions as $promotion)
            <tr>
                <td>{{ $promotion->ID_Promotion }}</td>
                <td>{{ $promotion->Title }}</td>
                <td>{{ $promotion->Description }}</td>
                <td>
                    @if($promotion->Image_url)
                        <img src="{{ $promotion->Image_url }}" style="max-width:60px;">
                    @endif
                </td>
                <td>{{ $promotion->Created_at }}</td>
                <td>
                    <a href="{{ route('admin.promotions.show', $promotion->ID_Promotion) }}" class="btn small">Подробнее</a>
                    <a href="{{ route('admin.promotions.edit', $promotion->ID_Promotion) }}" class="btn small">Редактировать</a>
                    <form action="{{ route('admin.promotions.destroy', $promotion->ID_Promotion) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn small" onclick="return confirm('Удалить акцию?')">Удалить</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
