@extends('admin.layout')

@section('title', 'Записи')

@section('content')
    <h2 class="title">Записи</h2>

    {{-- ФИЛЬТРЫ --}}
    <form method="GET" class="mb-3" style="display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;">
        <!-- ... ваши фильтры как есть ... -->
    </form>

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

                {{-- КНОПКА СМЕНЫ СТАТУСА --}}
                <div>
                    <form action="{{ route('admin.appointments.status', $appointment->ID_Appointments) }}" method="POST" style="display:flex; gap:10px; align-items:center;">
                        @csrf
                        <select name="ID_status">
                            <option value="1" @if($appointment->ID_status == 1) selected @endif>Новая</option>
                            <option value="2" @if($appointment->ID_status == 2) selected @endif>Завершен</option>
                        </select>
                        <button type="submit" class="btn-sm">Обновить статус</button>
                    </form>
                </div>
            </div>
        @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #999;ф">
                Записей не найдено
            </div>
        @endforelse
    </div>

    {{ $appointments->links() }}
@endsection
