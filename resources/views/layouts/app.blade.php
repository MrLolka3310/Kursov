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
                <div style="margin-top: 10px; font-size: 0.8rem; color: rgba(255,255,255,0.7);">
                    {{ Auth::user()->role_name }}
                </div>
            </div>
            <div class="sidebar-menu">
                <ul>
                    @foreach(Auth::user()->available_sections as $section)
                        @php
                            $isActive = request()->routeIs($section['route'] . '*');
                        @endphp
                        <li>
                            <a href="{{ route($section['route']) }}" class="{{ $isActive ? 'active' : '' }}">
                                <i class="fas fa-{{ $section['icon'] }}"></i>
                                <span>{{ $section['name'] }}</span>
                            </a>
                        </li>
                    @endforeach
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
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span class="user-role">{{ Auth::user()->role_name }}</span>
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