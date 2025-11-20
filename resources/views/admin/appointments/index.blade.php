@extends('admin.layout')

@section('title', 'Записи')

@section('content')
    <h2 class="title">Записи</h2>

    {{-- ФИЛЬТРЫ --}}
    <form method="GET" class="mb-3" style="display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;">
        {{-- Фильтр по мастеру --}}
        <div>
            <label for="filter_master" style="display: block; margin-bottom: 5px; font-weight: bold;">Мастер:</label>
            <select name="filter_master" id="filter_master" style="padding: 8px 12px; border-radius: 4px; border: 1px solid #ccc;">
                <option value="">-- Все мастера --</option>
                @foreach($masters as $master)
                    <option value="{{ $master->ID_Master }}" {{ request('filter_master') == $master->ID_Master ? 'selected' : '' }}>
                        {{ $master->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Фильтр по дате --}}
        <div>
            <label for="filter_date" style="display: block; margin-bottom: 5px; font-weight: bold;">Дата:</label>
            <input type="date" name="filter_date" id="filter_date"
                   value="{{ request('filter_date') }}"
                   style="padding: 8px 12px; border-radius: 4px; border: 1px solid #ccc;">
        </div>

        {{-- Сортировка по дате --}}
        <div>
            <label for="sort" style="display: block; margin-bottom: 5px; font-weight: bold;">Сортировка:</label>
            <select name="sort" id="sort" style="padding: 8px 12px; border-radius: 4px; border: 1px solid #ccc;">
                <option value="desc" {{ ($sort ?? 'desc') == 'desc' ? 'selected' : '' }}>Сначала новые</option>
                <option value="asc" {{ ($sort ?? 'desc') == 'asc' ? 'selected' : '' }}>Сначала старые</option>
            </select>
        </div>

        {{-- Кнопки --}}
        <button type="submit" class="btn" style="padding: 8px 16px;">Применить</button>
        <a href="{{ route('admin.appointments.index') }}" class="btn" style="padding: 8px 16px; background-color: #999; text-decoration: none; color: white; border-radius: 4px; display: inline-block;">Сбросить</a>
    </form>

    {{-- КАРТОЧКИ ЗАПИСЕЙ --}}
    <div class="appointments" style="display: grid; gap: 20px; grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));">
        @forelse($appointments as $appointment)
            <div class="appointment-card panel">
                <h4>Клиент: {{ $appointment->user->Login ?? '-' }}</h4>
                <div>Питомец: {{ $appointment->pet->Name ?? '-' }}</div>

                {{-- Услуги --}}
                <div>Услуги:
                    @if($appointment->appointmentServices && $appointment->appointmentServices->count() > 0)
                        <ul style="margin: 5px 0; padding-left: 20px;">
                            @foreach($appointment->appointmentServices as $as)
                                <li>
                                    {{ $as->service->Title ?? '-' }}
                                    @if($as->service && $as->service->Price)
                                        ({{ number_format($as->service->Price, 2) }} ₽)
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <span style="color: #999;">Нет услуг</span>
                    @endif
                </div>

                {{-- Итого --}}
                @php
                    $total = 0;
                    if($appointment->appointmentServices && $appointment->appointmentServices->count() > 0) {
                        foreach($appointment->appointmentServices as $as) {
                            if($as->service && $as->service->Price) {
                                $total += $as->service->Price;
                            }
                        }
                    }
                @endphp
                <div>Итого: <b>{{ number_format($total, 2) }} ₽</b></div>

                <div>Дата: {{ $appointment->Date }}</div>
                <div>Время: {{ $appointment->Time }}</div>
                <div>Мастер: {{ $appointment->master->name ?? '-' }}</div>
            </div>
        @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #999;">
                Записей не найдено
            </div>
        @endforelse
    </div>

    {{-- ПАГИНАЦИЯ --}}
    {{ $appointments->links() }}
@endsection
