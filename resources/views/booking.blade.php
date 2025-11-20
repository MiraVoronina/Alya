<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Запись на услугу - Груминг салон</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .alert-success { color: green; margin-top: 1em; }
        .alert-error { color: red; margin-top: 1em; }
        .booking-form { max-width: 420px; margin: auto; }
        .time-slots label { margin-right: 10px; }
    </style>
</head>
<body>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>
@endif

<header>
    <div class="container">
        <div class="nav">
            <div class="brand">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" />
                <span>Груминг салон</span>
            </div>
            <nav>
                <a href="{{ route('home') }}">Главная</a>
                <a href="{{ route('services') }}">Услуги</a>
                <a href="{{ route('about') }}">О нас</a>
                <a href="{{ route('works') }}">Отзывы</a>
                <a href="{{ route('contacts') }}">Контакты</a>
                @auth
                    <a href="{{ route('profile') }}">Профиль</a>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" style="background:none;border:none;padding:0;cursor:pointer;">Выход</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Вход</a>
                @endauth
            </nav>
        </div>
    </div>
</header>

<main>
    <div class="container">
        <section class="section">
            <h2 class="title">Запись на услугу</h2>
            @if ($step === 1)
                <form action="{{ route('booking.size') }}" method="POST" class="booking-form">
                    @csrf
                    @if(isset($pets) && count($pets) > 0)
                        <div class="form-group">
                            <label for="pet_id">Выберите питомца</label>
                            <select name="pet_id" required>
                                @foreach($pets as $pet)
                                    <option value="{{ $pet->ID }}">{{ $pet->Name }} ({{ $pet->breed_category }})</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <!-- breed_category inputs -->
                    @endif
                    <button type="submit" class="btn">Далее</button>
                </form>
            @endif
            @if ($step === 2)
                <div class="booking-panel">
                    <form action="{{ route('booking.service.post') }}" method="POST" class="booking-form">
                        @csrf
                        <div class="panel">
                            <div class="panel-title">Выберите услуги</div>
                            <!-- Итоговая сумма -->
                            <div id="totalPrice" style="margin: 10px 0; font-weight: bold; color:#663300"></div>
                            <div class="service-options">
                                @if(!empty($services) && count($services))
                                    @foreach($services as $service)
                                        <label class="service-card">
                                            <input type="checkbox" name="services[]" value="{{ $service->ID_Services }}"
                                                   data-price="{{ $service->Price }}" />
                                            <div class="service-content">
                                                <span class="service-title">{{ $service->Title }}</span>
                                                <span class="service-price muted">от {{ number_format($service->Price, 0, '', ' ') }} ₽</span>
                                            </div>
                                        </label>
                                    @endforeach
                                @else
                                    <div class="alert alert-error">Нет доступных услуг для выбранной категории!</div>
                                @endif
                            </div>
                            <div class="panel-buttons">
                                <a href="{{ route('booking') }}" class="btn back">Назад</a>
                                <button type="submit" class="btn">Далее</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- JS калькулятор суммы -->
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        function updateTotal() {
                            let sum = 0;
                            document.querySelectorAll('input[name="services[]"]:checked').forEach(function(cb){
                                sum += parseFloat(cb.getAttribute('data-price'));
                            });
                            document.getElementById('totalPrice').innerText = sum > 0
                                ? 'Итого: ' + sum.toLocaleString('ru-RU') + ' ₽'
                                : '';
                        }
                        document.querySelectorAll('input[name="services[]"]').forEach(function(cb){
                            cb.addEventListener('change', updateTotal);
                        });
                        updateTotal();
                    });
                </script>
            @endif

            @if ($step === 3)
                <form action="{{ route('booking.time.post') }}" method="POST" class="booking-form" id="timeForm">
                    @csrf
                    <h3>Выберите дату и время</h3>
                    <div class="form-group">
                        <label for="appointment_date">Дата</label>
                        <input type="date" name="appointment_date" id="appointment_date"
                               class="form-control" required min="{{ date('Y-m-d') }}" value="{{ old('appointment_date') }}" />
                    </div>
                    <div class="form-group">
                        <label for="master">Мастер</label>
                        <select name="master" id="master" class="form-control" required>
                            @foreach($masters as $master)
                                <option value="{{ $master->ID_Master }}"{{ old('master', $selectedMaster)==$master->ID_Master?' selected':'' }}>
                                    {{ $master->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Время</label>
                        <div class="time-slots" id="timeSlots">
                            <!-- Слоты времени появятся здесь через JS -->
                            Загрузите дату и мастера для просмотра доступных слотов.
                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="agree" required />
                            Согласен с обработкой персональных данных
                        </label>
                    </div>
                    <button type="submit" class="btn">Подтвердить запись</button>
                </form>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const dateInput = document.getElementById('appointment_date');
                        const masterInput = document.getElementById('master');
                        const timeContainer = document.getElementById('timeSlots');
                        const allTimes = ['10:00','11:00','12:00','13:00','14:00','15:00'];
                        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        function loadSlots() {
                            let date = dateInput.value;
                            let master = masterInput.value;
                            if (!date || !master) {
                                timeContainer.innerHTML = 'Выберите мастера и дату';
                                return;
                            }
                            timeContainer.innerHTML = 'Загрузка...';

                            fetch('{{ route('booking.time') }}/ajax', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify({ date: date, master: master })
                            })
                                .then(res => res.json())
                                .then(data => {
                                    let busyList = data.busyTimes || [];
                                    let html = '';
                                    allTimes.forEach(function(t) {
                                        if (!busyList.includes(t)) {
                                            html += `<label><input type="radio" name="appointment_time" value="${t}" required /> ${t}</label> `;
                                        }
                                    });
                                    if (!html) html = '<span class="muted">Нет свободных слотов!</span>';
                                    timeContainer.innerHTML = html;
                                });
                        }
                        dateInput.addEventListener('change', loadSlots);
                        masterInput.addEventListener('change', loadSlots);
                        loadSlots();
                    });
                </script>
            @endif

            @if($step === 4)
                <div class="confirm-panel">
                    <h3>Заявка заполнена!</h3>
                    <p>Ваша заявка принята, ожидайте подтверждения времени от мастера.</p>
                    <form method="POST" action="{{ route('booking.store') }}">
                        @csrf
                        <button type="submit" class="btn">Подтвердить запись</button>
                    </form>
                    <a href="{{ route('home') }}" class="btn">На главную</a>
                </div>
            @endif
        </section>
    </div>
</main>

<footer>
    <div class="container">
        <div class="footer-top">
            <div>
                <h4>О нас</h4>
                <p>Профессиональный груминг салон для вашего любимца</p>
            </div>
            <div>
                <h4>Контакты</h4>
                <p>г. Томск, ул. Олега Кошевого, 66</p>
                <p>Телефон: 89138031855</p>
            </div>
            <div>
                <h4>График работы</h4>
                <p>с 9:00 до 22:00</p>
            </div>
            <div class="footer-social">
                <a href="#">VK</a>
                <a href="#">TG</a>
            </div>
        </div>
        <div class="footer-bottom">
            <nav class="footer-nav">
                <a href="{{ route('home') }}">Главная</a>
                <a href="{{ route('services') }}">Услуги</a>
                <a href="{{ route('about') }}">О нас</a>
            </nav>
        </div>
    </div>
</footer>
</body>
</html>
