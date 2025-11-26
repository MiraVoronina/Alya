<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О нас - Груминг салон</title>
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
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" style="background:none;border:none;padding:0;color:inherit;cursor:pointer;">Выход</button>
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
            <h2 class="title">О нас</h2>
            <div class="band">
                <div>
                    <img src="{{ asset('images/about.jpg') }}" alt="О салоне">
                </div>
                <div>
                    <p>Мы — команда профессионалов, увлеченных уходом за домашними животными. Наша миссия — обеспечить вашим питомцам высокий уровень заботы и комфорта, а также создать приятную атмосферу для их владельцев.</p>
                    <p>Мы верим, что регулярный груминг — это не только вопрос эстетики, но и важный аспект здоровья и благополучия ваших любимцев.</p>
                    <a href="{{ route('booking') }}" class="btn">Записаться</a>
                </div>
            </div>
        </section>

        <section class="section">
            <h2 class="title">Наши мастера</h2>
            <div class="masters">
                <div class="person">
                    <img src="{{ asset('images/master1.jpg') }}" alt="Мирослава">
                    <h4>Мирослава</h4>
                    <p class="muted">Мастер груминга «Волшебные руки» - неперевзойдённый профессионал с магическим прикосновением к каждому питомцу.</p>
                </div>
                <div class="person">
                    <img src="{{ asset('images/master2.jpg') }}" alt="Станислав">
                    <h4>Станислав</h4>
                    <p class="muted">Мастер груминга «Шерстяной волшебник» - специалист по шерсти, чьи работы становятся произведениями искусства.</p>
                </div>
                <div class="person">
                    <img src="{{ asset('images/master3.jpg') }}" alt="Ева">
                    <h4>Ева</h4>
                    <p class="muted">Мастер груминга «Заботливое сердце» - заботливый и нежный к каждому пушистому клиенту.</p>
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
