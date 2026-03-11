<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Складской учет') - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">
    @stack('styles')
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h3>Складской учет <span>v1.0</span></h3>
            </div>
            <div class="sidebar-menu">
                <ul>
                    <li>
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Дашборд</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                            <i class="fas fa-box"></i>
                            <span>Товары</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
                            <i class="fas fa-tags"></i>
                            <span>Категории</span>
                        </a>
                    </li>
                    
                    <li class="menu-divider"></li>
                    
                    <li>
                        <a href="{{ route('incoming-invoices.index') }}" class="{{ request()->routeIs('incoming-invoices.*') ? 'active' : '' }}">
                            <i class="fas fa-truck"></i>
                            <span>Приход</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('outgoing-orders.index') }}" class="{{ request()->routeIs('outgoing-orders.*') ? 'active' : '' }}">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Расход</span>
                        </a>
                    </li>
                    
                    <li class="menu-divider"></li>
                    
                    <li>
                        <a href="{{ route('suppliers.index') }}" class="{{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                            <i class="fas fa-truck"></i>
                            <span>Поставщики</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('customers.index') }}" class="{{ request()->routeIs('customers.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            <span>Клиенты</span>
                        </a>
                    </li>
                    
                    <li class="menu-divider"></li>
                    
                    <li>
                        <a href="{{ route('warehouse-cells.index') }}" class="{{ request()->routeIs('warehouse-cells.*') ? 'active' : '' }}">
                            <i class="fas fa-warehouse"></i>
                            <span>Ячейки склада</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('inventory.index') }}" class="{{ request()->routeIs('inventory.*') ? 'active' : '' }}">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Инвентаризация</span>
                        </a>
                    </li>
                    
                    <li class="menu-divider"></li>
                    
                    <li>
                        <a href="{{ route('reports.stock') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
                            <i class="fas fa-chart-bar"></i>
                            <span>Отчеты</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="header">
                <div class="page-title">
                    @yield('page-title')
                </div>
                <div class="user-info">
                    <span class="user-name">{{ Auth::user()->name ?? 'Гость' }}</span>
                    <span class="user-role">
                        @if(Auth::check())
                            @switch(Auth::user()->role)
                                @case('admin')
                                    Администратор
                                    @break
                                @case('manager')
                                    Менеджер
                                    @break
                                @case('storekeeper')
                                    Кладовщик
                                    @break
                                @case('analyst')
                                    Аналитик
                                    @break
                                @default
                                    {{ Auth::user()->role }}
                            @endswitch
                        @endif
                    </span>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-outline btn-sm">
                            <i class="fas fa-sign-out-alt"></i>
                            Выход
                        </button>
                    </form>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success fade-in">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger fade-in">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Закрытие алертов через 5 секунд
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);

        // Подтверждение удаления
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            if (confirm('Вы уверены, что хотите удалить эту запись?')) {
                $(this).closest('form').submit();
            }
        });
    </script>
    @stack('scripts')
</body>
</html>