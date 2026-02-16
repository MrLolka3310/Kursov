<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Система управления складом')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header>
        <div class="container">
            <h2>Система управления складом</h2>

            @auth
                <nav>
                    <a href="/dashboard">Главная</a>

                    @if(auth()->user()->role->name === 'admin')
                        <a href="/categories">Категории</a>
                        <a href="/products">Товары</a>
                        <a href="/warehouses">Склады</a>
                        <a href="/suppliers">Поставщики</a>
                    @endif

                    @if(auth()->user()->role->name === 'storekeeper')
                        <a href="/incomes">Приход</a>
                        <a href="/expenses">Расход</a>
                        <a href="/stocks">Остатки</a>
                        <a href="/reports/stocks">Отчет по остаткам</a>
                        <a href="/reports/movements">Движение товаров</a>
                    @endif

                    @if(in_array(auth()->user()->role->name, ['admin', 'manager']))
                        <a href="/reports/stocks">Отчеты</a>
                    @endif

                    <form method="POST" action="/logout" style="display: inline;">
                        @csrf
                        <button type="submit">Выход</button>
                    </form>
                </nav>
            @endauth
        </div>
    </header>

    <main class="container">
        <div class="content-wrapper">
            @yield('content')
        </div>
    </main>
</body>
</html>
