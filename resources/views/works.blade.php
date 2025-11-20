<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Отзывы - Груминг салон</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
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
                        <button type="submit" style="background:none; border:none; padding:0; color:inherit; cursor:pointer;">Выход</button>
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
            <h2 class="title">Отзывы</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            @auth
                <div class="panel">
                    <h3>Оставить отзыв</h3>
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="service_id">Услуга</label>
                            <select name="Services_ID" id="service_id" class="form-control" required>
                                @foreach($services as $service)
                                    <option value="{{ $service->ID_Services }}">{{ $service->Title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="rating">Оценка</label>
                            <select name="Rating" id="rating" class="form-control" required>
                                <option value="5">★★★★★</option>
                                <option value="4">★★★★☆</option>
                                <option value="3">★★★☆☆</option>
                                <option value="2">★★☆☆☆</option>
                                <option value="1">★☆☆☆☆</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="content">Ваш отзыв</label>
                            <textarea name="Content" id="content" class="form-control" rows="4" required></textarea>
                        </div>

                        <button type="submit" class="btn">Отправить отзыв</button>
                    </form>
                </div>
            @endauth

            <div class="reviews">
                @forelse($reviews as $review)
                    <div class="review">
                        <div class="review-avatar">{{ substr($review->user->Login ?? 'A', 0, 1) }}</div>
                        <div class="review-content">
                            <h4>{{ $review->user->Login ?? '—' }}</h4>
                            <div><strong>{{ $review->service->Title ?? '' }}</strong></div>
                            <div class="review-rating">
                                @for($i=0; $i < $review->Rating; $i++)
                                    ★
                                @endfor
                            </div>
                            <p>{{ $review->Content }}</p>
                            <small>{{ optional($review->created_at)->format('d.m.Y H:i') ?? '—' }}</small>
                        </div>
                    </div>
                @empty
                    <p>Пока нет отзывов</p>
                @endforelse
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
