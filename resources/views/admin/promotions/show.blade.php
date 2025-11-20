@extends('admin.layout')

@section('title', 'Информация об акции')

@section('content')
    <h2>Информация об акции</h2>
    <div>
        <div><b>ID: {{ $promotion->ID_Promotion }}</b></div>
        <div>Название: {{ $promotion->Title }}</div>
        <div>Описание: {{ $promotion->Description }}</div>
        <div>Картинка:
            @if($promotion->Image_url)
                <img src="{{ $promotion->Image_url }}" style="max-width:120px;">
            @endif
        </div>
        <div>Дата создания: {{ $promotion->Created_at }}</div>
        <a href="{{ route('admin.promotions.edit', $promotion->ID_Promotion) }}" class="btn small">Редактировать</a>
        <a href="{{ route('admin.promotions.index') }}" class="btn small">Назад</a>
    </div>
@endsection
