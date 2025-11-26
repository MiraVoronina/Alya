<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Запись на услугу - Груминг салон</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .alert-success { color: green; margin-top: 1em; padding: 10px; background: #e8f5e9; border-radius: 4px; }
        .alert-error { color: red; margin-top: 1em; padding: 10px; background: #ffebee; border-radius: 4px; }
        .alert-info { color: #0066cc; margin-top: 1em; padding: 10px; background: #e3f2fd; border-radius: 4px; }
        .booking-form { max-width: 420px; margin: auto; }
        .form-control { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; margin-top: 5px; }
        .time-slots label { margin-right: 15px; display: inline-block; margin-top: 5px; }
        .service-card { display: block; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; cursor: pointer; }
        .service-card:hover { background: #f5f5f5; }
        .panel-buttons { margin-top: 20px; display: flex; gap: 10px; }
        .panel-buttons .btn { flex: 1; }
    </style>
</head>
<body>

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

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            @isset($step)
                @if ($step === 1)
                    <form action="{{ route('booking.size') }}" method="POST" class="booking-form">
                        @csrf

                        @if(isset($pets) && count($pets) > 0)
                            <div class="alert alert-info">Выберите питомца или укажите размер</div>
                            <div class="form-group">
                                <label for="pet_id">Выберите питомца</label>
                                <select name="pet_id" id="pet_id" class="form-control" onchange="usePetBreed()">
                                    <option value="">-- Выберите питомца --</option>
                                    @foreach($pets as $pet)
                                        <option value="{{ $pet->ID }}" data-category="{{ $pet->breed_category }}">
                                            {{ $pet->Name }} ({{ $pet->breed_category }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="alert alert-info">
                                Укажите размер вашей собаки. <a href="{{ route('profile') }}">Или добавьте питомца в профиле</a>.
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="breed_category">Размер собаки</label>
                            <select name="breed_category" id="breed_category" class="form-control" required>
                                <option value="">-- Выберите размер --</option>
                                <option value="Маленькие породы">Маленькие породы</option>
                                <option value="Средние породы">Средние породы</option>
                                <option value="Большие породы">Большие породы</option>
                            </select>
                        </div>

                        <button type="submit" class="btn">Далее</button>
                    </form>

                    <script>
                        function usePetBreed() {
                            let select = document.getElementById('pet_id');
                            let categorySelect = document.getElementById('breed_category');
                            let selectedOption = select.options[select.selectedIndex];
                            if (selectedOption.value) {
                                categorySelect.value = selectedOption.getAttribute('data-category');
                            }
                        }
                    </script>
                @endif

                @if ($step === 2)
                    <div class="booking-panel">
                        <form action="{{ route('booking.service.post') }}" method="POST" class="booking-form">
                            @csrf
                            <div class="panel">
                                <h3 style="text-align: center; margin-bottom: 20px; color: #8B6F6F;">
                                    Выберите услуги для {{ $breed_category ?? 'Вашей собаки' }}
                                </h3>

                                <div id="totalPrice" style="margin: 15px 0; font-weight: bold; color:#663300; font-size: 16px; text-align: center;"></div>

                                <div class="service-options" style="display: flex; flex-direction: column; gap: 10px;">
                                    @if(!empty($services) && count($services))
                                        @foreach($services as $service)
                                            <label style="display: flex; align-items: center; padding: 12px; background: #9B8B7E; color: white; border-radius: 6px; cursor: pointer; margin: 0;">
                                                <input type="checkbox" name="services[]" value="{{ $service->ID_Services }}"
                                                       data-price="{{ $service->Price }}"
                                                       style="margin-right: 15px; cursor: pointer; width: 18px; height: 18px;" />
                                                <span style="flex: 1; font-size: 15px;">{{ $service->Title }}</span>
                                                <span style="font-weight: bold; margin-left: auto;">{{ number_format($service->Price, 0, '', ' ') }} ₽</span>
                                            </label>
                                        @endforeach
                                    @else
                                        <div class="alert alert-error">Нет доступных услуг для выбранной категории!</div>
                                    @endif
                                </div>

                                <div class="panel-buttons" style="margin-top: 20px; display: flex; gap: 10px;">
                                    <a href="{{ route('booking') }}" class="btn" style="flex: 1; padding: 10px; text-align: center; background: #A67C7C; color: white; border-radius: 6px; text-decoration: none;">Назад</a>
                                    <button type="submit" class="btn" style="flex: 1; padding: 10px; background: #A67C7C; color: white; border: none; border-radius: 6px; cursor: pointer;">Далее</button>
                                </div>
                            </div>
                        </form>
                    </div>

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
                                <option value="">-- Выберите мастера --</option>
                                @if(isset($masters))
                                    @foreach($masters as $master)
                                        <option value="{{ $master->ID_Master }}"{{ old('master', $selectedMaster ?? '')==$master->ID_Master?' selected':'' }}>
                                            {{ $master->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Время</label>
                            <div class="time-slots" id="timeSlots">
                                Выберите мастера и дату для просмотра доступных слотов.
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

                                fetch('{{ route('booking.time.ajax') }}', {
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
                                    })
                                    .catch(err => {
                                        timeContainer.innerHTML = 'Ошибка загрузки слотов';
                                        console.error(err);
                                    });
                            }
                            dateInput.addEventListener('change', loadSlots);
                            masterInput.addEventListener('change', loadSlots);
                            loadSlots();
                        });
                    </script>
                @endif

                @if($step === 4)
                    <div class="confirm-panel" style="text-align: center;">
                        <h3>✓ Заявка заполнена!</h3>
                        <p>Ваша заявка принята, ожидайте подтверждения времени от мастера.</p>
                        <form method="POST" action="{{ route('booking.store') }}">
                            @csrf
                            <button type="submit" class="btn">Подтвердить запись</button>
                        </form>
                        <a href="{{ route('home') }}" class="btn">На главную</a>
                    </div>
                @endif
            @else
                <div class="alert alert-error">Ошибка: переменная step не определена в контроллере!</div>
            @endisset
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
