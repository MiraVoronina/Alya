<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Акции - Груминг салон</title>
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
                @auth
                    <a href="{{ route('profile') }}">Профиль</a>
                    <a href="{{ route('logout') }}">Выход</a>
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
            <h2 class="title">Программа лояльности «Заботливый хозяин»</h2>

            <div class="cards">
                <div class="card">
                    <h3>Регулярное посещение</h3>
                    <p>При посещении салона каждый месяц, фиксируем скидку 20%, если не приходите раз в 2 месяца - 10%.</p>
                    <a href="{{ route('booking') }}" class="btn small">Отлично, записывайте!</a>
                </div>
                <div class="card">
                    <h3>Приведи друга</h3>
                    <p>Дарим вам скидку 15%, а вашему другу 10% скидки.</p>
                    <a href="{{ route('booking') }}" class="btn small">Отлично, записывайте!</a>
                </div>
                <div class="card">
                    <h3>Малышам скидка</h3>
                    <p>Дарим скидку самым маленьким питомцам.</p>
                    <a href="{{ route('booking') }}" class="btn small">Отлично, записывайте!</a>
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
