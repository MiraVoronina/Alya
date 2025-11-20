@extends('admin.layout')

@section('title', 'Добавить акцию')

@section('content')
    <h2>Добавить акцию</h2>
    <form method="POST" action="{{ route('admin.promotions.store') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="Title">Название</label>
            <input type="text" name="Title" id="Title" required>
        </div>
        <div>
            <label for="Description">Описание</label>
            <textarea name="Description" id="Description" required></textarea>
        </div>
        <div>
            <label for="Image_file">Изображение</label>
            <input type="file" name="Image_file" id="Image_file" accept="image/*" required>
        </div>
        <button type="submit" class="btn">Сохранить</button>
    </form>
@endsection
