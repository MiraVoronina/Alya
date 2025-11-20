@extends('admin.layout')

@section('title', 'Редактировать акцию')

@section('content')
    <h2>Редактировать акцию</h2>
    <form method="POST" action="{{ route('admin.promotions.update', $promotion->ID_Promotion) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <label for="Title">Название</label>
            <input type="text" name="Title" id="Title" value="{{ $promotion->Title }}" required>
        </div>
        <div>
            <label for="Description">Описание</label>
            <textarea name="Description" id="Description" required>{{ $promotion->Description }}</textarea>
        </div>
        <div>
            <label for="Image_file">Изображение</label>
            <input type="file" name="Image_file" id="Image_file" accept="image/*">
            @if($promotion->Image_url)
                <div>Текущее <img src="{{ $promotion->Image_url }}" style="max-width:100px;"></div>
            @endif
        </div>
        <button type="submit" class="btn">Сохранить</button>
    </form>
@endsection
