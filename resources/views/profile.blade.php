<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль - Груминг салон</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .edit-row { margin-bottom: 12px; }
        .muted { color: #888; }
        .avatar-block {
            background: #f7f6f4;
            border-radius: 32px;
            padding: 32px 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 120px;
            min-height: 220px;
            box-sizing: border-box;
        }
        .avatar-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 18px;
        }
        .inline-form { display: inline; }
    </style>
</head>
<body>
<header>
    <div class="container">
        <div class="nav">
            <div class="brand">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
                <span>Груминг салон</span>
            </div>
            <nav>
                <a href="{{ route('home') }}">Главная</a>
                <a href="{{ route('services') }}">Услуги</a>
                <a href="{{ route('about') }}">О нас</a>
                <a href="{{ route('works') }}">Отзывы</a>
                <a href="{{ route('contacts') }}">Контакты</a>
                <a href="{{ route('profile') }}">Профиль</a>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:none;border:none;padding:0;color:inherit;cursor:pointer;">Выход</button>
                </form>
            </nav>
        </div>
    </div>
</header>

<main>
    <div class="container">
        <section class="section">
            <h2 class="title">Профиль пользователя</h2>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="panel" style="display:flex; align-items:flex-start; gap:32px; margin-bottom:32px;">
                <div class="avatar-block">
                    @if($user->photo_url)
                        <img src="{{ asset('storage/'.$user->photo_url) }}" alt="avatar" class="avatar-img">
                    @else
                        <div style="width:80px;height:80px;border-radius:50%;background:#e3e3e3;margin-bottom:18px;display:flex;align-items:center;justify-content:center;">
                            <span class="muted">Аватар</span>
                        </div>
                    @endif
                    <button type="button" onclick="toggle('edit-avatar')" class="btn-sm">Редактировать</button>
                    <form action="{{ route('profile.editUser') }}" method="POST" enctype="multipart/form-data" id="edit-avatar" style="display:none;margin-top:10px;">
                        @csrf
                        <input type="hidden" name="field" value="photo_url">
                        <input type="file" name="photo_url" accept="image/*" style="margin-bottom:7px;">
                        <button type="submit" class="btn-sm">Обновить аватар</button>
                        <button type="button" onclick="toggle('edit-avatar')">Отмена</button>
                    </form>
                </div>
                <div style="flex:1;">
                    <h3>Личные данные</h3>
                    <div class="edit-row">
                        <strong>Логин:</strong> {{ $user->Login }}
                        <button type="button" onclick="toggle('edit-login')" class="btn-sm">Редактировать</button>
                        <form action="{{ route('profile.editUser') }}" method="POST" id="edit-login" style="display:none;margin-top:5px;">
                            @csrf
                            <input type="hidden" name="field" value="Login">
                            <input type="text" name="Login" value="{{ $user->Login }}" required>
                            <button type="submit" class="btn-sm">Сохранить</button>
                            <button type="button" onclick="toggle('edit-login')">Отмена</button>
                        </form>
                    </div>
                    <div class="edit-row">
                        <strong>Email:</strong> {{ $user->Avatar_url }}
                        <button type="button" onclick="toggle('edit-email')" class="btn-sm">Редактировать</button>
                        <form action="{{ route('profile.editUser') }}" method="POST" id="edit-email" style="display:none;margin-top:5px;">
                            @csrf
                            <input type="hidden" name="field" value="Avatar_url">
                            <input type="email" name="Avatar_url" value="{{ $user->Avatar_url }}" required>
                            <button type="submit" class="btn-sm">Сохранить</button>
                            <button type="button" onclick="toggle('edit-email')">Отмена</button>
                        </form>
                    </div>
                    <div class="edit-row">
                        <strong>Пароль:</strong> <span class="muted">••••••••</span>
                        <button type="button" onclick="toggle('edit-password')" class="btn-sm">Сменить</button>
                        <form action="{{ route('profile.editUser') }}" method="POST" id="edit-password" style="display:none;margin-top:5px;">
                            @csrf
                            <input type="hidden" name="field" value="Password">
                            <input type="password" name="Password" placeholder="Новый пароль" required>
                            <input type="password" name="Password_confirmation" placeholder="Повторите пароль" required>
                            <button type="submit" class="btn-sm">Сохранить</button>
                            <button type="button" onclick="toggle('edit-password')">Отмена</button>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                function toggle(id) {
                    let el = document.getElementById(id);
                    if(el) el.style.display = el.style.display === 'none' ? 'block' : 'none';
                }
            </script>

            <div class="panel">
                <h3>Ваши питомцы</h3>
                @if(isset($pets) && count($pets) > 0)
                    <ul>
                        @foreach($pets as $pet)
                            <li>
                                <strong>Кличка:</strong> {{ $pet->Name }},
                                <strong>Порода:</strong> {{ $pet->Breed }},
                                <strong>Размер:</strong> {{ $pet->breed_category }}
                                <form method="POST" action="{{ route('profile.deletePet', $pet->ID) }}" class="inline-form">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Удалить питомца?')">Удалить</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="muted">У вас пока нет питомцев.</p>
                @endif
                <h4>Добавить питомца</h4>
                <form method="POST" action="{{ route('profile.addPet') }}">
                    @csrf
                    <label>Кличка</label>
                    <input type="text" name="Name" required>
                    <label>Порода</label>
                    <input type="text" name="Breed" required>
                    <label>Размер собаки</label>
                    <select name="breed_category" required>
                        <option value="Большие породы">Большие породы</option>
                        <option value="Средние породы">Средние породы</option>
                        <option value="Мелкие породы">Мелкие породы</option>
                    </select>
                    <button type="submit">Добавить</button>
                </form>
            </div>
            <a href="{{ route('booking') }}" class="btn" style="margin-top:32px;">Записаться на услугу</a>
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
