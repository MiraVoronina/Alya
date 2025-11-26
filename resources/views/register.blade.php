<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - Груминг салон</title>
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
            </nav>
        </div>
    </div>
</header>

<main>
    <div class="container">
        <section class="section">
            <div class="panel" style="max-width: 600px; margin: 0 auto;">
                <h2>Регистрация</h2>
                @if($errors->any())
                    <div class="alert alert-error">
                        {{ $errors->first() }}
                    </div>
                @endif
                <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data" id="regform">
                    @csrf
                    <div class="form-group">
                        <label for="login">Имя (логин)</label>
                        <input type="text" name="login" id="login" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input type="password" name="password" id="password" class="form-control" required minlength="6">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Повторите пароль</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required minlength="6">
                    </div>
                    <div class="form-group">
                        <label for="photo">Фото профиля (необязательно)</label>
                        <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="agree" required>
                            Согласен с обработкой персональных данных
                        </label>
                    </div>
                    <button type="submit" class="btn">Зарегистрироваться</button>
                </form>
                <p style="margin-top: 16px; text-align: center;">
                    Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a>
                </p>
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
