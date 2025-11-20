@extends('admin.layout')

@section('title', 'Добавить услугу')

@section('content')
    <h2>Добавить услугу</h2>
    <form method="POST" action="{{ route('admin.services.store') }}">
        @csrf
        <div>
            <label for="Title">Название</label>
            <input type="text" name="Title" id="Title" required>
        </div>
        <div>
            <label for="Price">Цена</label>
            <input type="number" name="Price" id="Price" min="0" step="0.01" required>
        </div>
        <div>
            <label for="Breed_category">Категория</label>
            <input type="text" name="Breed_category" id="Breed_category">
        </div>
        <button type="submit" class="btn">Сохранить</button>
    </form>
@endsection
