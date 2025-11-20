<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Админ-панель')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .admin-menu {
            margin-bottom: 20px;
        }
        .admin-menu a {
            display: inline-block;
            margin-right: 10px;
            padding: 10px 16px;
            background: #3498db;
            color: white;
            border-radius: 4px;
            text-decoration: none;
        }
        .admin-menu a:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
<nav class="admin-tabs">
    <a href="{{ route('admin.services.index') }}" class="btn tab-btn {{ request()->is('admin/services*') ? 'active' : '' }}">Услуги</a>
    <a href="{{ route('admin.masters.index') }}" class="btn tab-btn {{ request()->is('admin/masters*') ? 'active' : '' }}">Мастера</a>
    <a href="{{ route('admin.promotions.index') }}" class="btn tab-btn {{ request()->is('admin/promotions*') ? 'active' : '' }}">Акции</a>
    <a href="{{ route('admin.appointments.index') }}" class="btn tab-btn {{ request()->is('admin/appointments*') ? 'active' : '' }}">Записи</a>
</nav>
<div class="container">
    @yield('content')
</div>
</body>
</html>
