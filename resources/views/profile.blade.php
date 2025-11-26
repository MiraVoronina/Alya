<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль пользователя - Груминг салон</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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
            <div class="panel" style="max-width: 700px; margin: 0 auto;">
                <h2>Профиль пользователя</h2>
                <div style="display: flex; gap: 32px;">
                    <div style="text-align: center;">
                        @if($user->Avatar_url)
                            <img src="{{ asset('storage/' . $user->Avatar_url) }}" alt="Аватар" style="width:130px; height:130px; object-fit:cover; border-radius:50%;">
                        @else
                            <div style="width:130px; height:130px; background:#f4f4f4; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#888;">
                                Аватар
                            </div>
                        @endif
                        <br>
                        <form action="{{ route('profile.editUser') }}" method="POST" enctype="multipart/form-data" style="margin-top:10px;">
                            @csrf
                            <input type="hidden" name="field" value="Avatar_url">
                            <input type="file" name="Avatar_url" accept="image/*" style="margin-bottom:7px;">
                            <button type="submit" class="btn-sm">Обновить аватар</button>
                        </form>
                    </div>
                    <div>
                        <h4>Личные данные</h4>
                        <div>
                            <strong>Логин:</strong> {{ $user->Login }}
                            <form action="{{ route('profile.editUser') }}" method="POST" style="margin-top:5px;">
                                @csrf
                                <input type="hidden" name="field" value="Login">
                                <input type="text" name="Login" value="{{ $user->Login }}" required>
                                <button type="submit" class="btn-sm">Сохранить</button>
                            </form>
                        </div>
                        <div>
                            <strong>Email:</strong> {{ $user->Email }}
                            <form action="{{ route('profile.editUser') }}" method="POST" style="margin-top:5px;">
                                @csrf
                                <input type="hidden" name="field" value="Email">
                                <input type="email" name="Email" value="{{ $user->Email }}" required>
                                <button type="submit" class="btn-sm">Сохранить</button>
                            </form>
                        </div>
                        <div>
                            <strong>Пароль:</strong> ••••••••
                            <form action="{{ route('profile.editUser') }}" method="POST" style="margin-top:5px;">
                                @csrf
                                <input type="hidden" name="field" value="Password">
                                <input type="password" name="Password" placeholder="Новый пароль" required>
                                <input type="password" name="Password_confirmation" placeholder="Повторите пароль" required>
                                <button type="submit" class="btn-sm">Сменить пароль</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="panel" style="margin-top:32px;">
                    <h3>Ваши питомцы</h3>
                    @if(isset($pets) && count($pets) > 0)
                        <ul>
                            @foreach($pets as $pet)
                                <li>
                                    <strong>Кличка:</strong> {{ $pet->Name }},
                                    <strong>Порода:</strong> {{ $pet->Breed }},
                                    <strong>Размер:</strong> {{ $pet->breed_category }}
                                    <form method="POST" action="{{ route('profile.deletePet', $pet->ID) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Удалить питомца?')" class="btn-sm">Удалить</button>
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
            </div>
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
