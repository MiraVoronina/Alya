@extends('admin.layout')

@section('title', 'Редактировать услугу')

@section('content')
    <h2>Редактировать услугу</h2>
    <form method="POST" action="{{ route('admin.services.update', $service->ID_Services) }}">
        @csrf
        @method('PUT')
        <div>
            <label for="Title">Название</label>
            <input type="text" name="Title" id="Title" value="{{ $service->Title }}" required>
        </div>
        <div>
            <label for="Price">Цена</label>
            <input type="number" name="Price" id="Price" value="{{ $service->Price }}" min="0" step="0.01" required>
        </div>
        <div>
            <label for="Breed_category">Категория</label>
            <input type="text" name="Breed_category" id="Breed_category" value="{{ $service->Breed_category }}">
        </div>
        <button type="submit" class="btn">Сохранить</button>
    </form>
@endsection
