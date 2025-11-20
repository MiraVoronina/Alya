<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная - Груминг салон</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        .promo-cards-flex {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 32px;
        }
        .card {
            box-shadow: 0 2px 16px rgba(0,0,0,0.06);
        }
        /* Чтобы слайды не сжимались, даже если там меньше трех карточек */
        .carousel-item {
            min-height: 355px;
        }
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
                @auth
                    <a href="{{ route('booking') }}">Записаться</a>
                    <a href="{{ route('profile') }}">Профиль</a>
                    @if(Auth::user()->role == 'admin' || Auth::user()->ID_User_Role == 1)
                        <a href="{{ route('admin.index') }}">Админ-панель</a>
                    @endif
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
            <div class="band">
                <div>
                    <h2>Программа лояльности «Заботливый хозяин»</h2>
                    <p>Ухоженные питомцы, с гладкой шерстью и красивой стрижкой, как дорогая известная картина, которой любуется весь мир.</p>
                    <a href="{{ route('booking') }}" class="btn">Записаться</a>
                </div>
                <div>
                    <img src="{{ asset('images/hero-dog.jpg') }}" alt="Груминг">
                </div>
            </div>
        </section>

        <section class="section">
            <h2 class="title">Наши акции</h2>
            @php
                $promoList = $promotions->take(3);
            @endphp

            @if($promotions->count() > 3)
                <!-- Карусель: в каждом слайде максимум 3 акции -->
                <div id="promoCarousel" class="carousel slide mb-4" data-ride="carousel" data-interval="false">
                    <div class="carousel-inner">
                        @foreach($promotions->chunk(3) as $idx => $chunk)
                            <div class="carousel-item {{ $idx == 0 ? 'active' : '' }}">
                                <div class="promo-cards-flex">
                                    @foreach($chunk as $promotion)
                                        <div class="card" style="max-width: 300px;">
                                            @if($promotion->Image_url)
                                                <img src="{{ $promotion->Image_url }}" class="card-img-top" alt="{{ $promotion->Title }}">
                                            @endif
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $promotion->Title }}</h5>
                                                <p class="card-text">{{ $promotion->Description }}</p>
                                                <span class="text-muted" style="font-size: 0.85em;">{{ $promotion->Created_at }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#promoCarousel" role="button" data-slide="prev" style="filter: invert(1);">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Назад</span>
                    </a>
                    <a class="carousel-control-next" href="#promoCarousel" role="button" data-slide="next" style="filter: invert(1);">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Вперёд</span>
                    </a>
                </div>
            @else
                <div class="promo-cards-flex mb-4">
                    @foreach($promoList as $promotion)
                        <div class="card" style="max-width: 300px;">
                            @if($promotion->Image_url)
                                <img src="{{ $promotion->Image_url }}" class="card-img-top" alt="{{ $promotion->Title }}">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $promotion->Title }}</h5>
                                <p class="card-text">{{ $promotion->Description }}</p>
                                <span class="text-muted" style="font-size: 0.85em;">{{ $promotion->Created_at }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
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

        <section class="section">
            <div class="band right-image">
                <div>
                    <img src="{{ asset('images/cta-image.jpg') }}" alt="Запись">
                </div>
                <div>
                    <h3>Запишитесь прямо сейчас!</h3>
                    <p>Мы верим, что регулярный груминг — это не только вопрос эстетики, но и важный аспект здоровья и благополучия ваших любимцев.</p>
                    <a href="{{ route('booking') }}" class="btn cta">Записаться</a>
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
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
