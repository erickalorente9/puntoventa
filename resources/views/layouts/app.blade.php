<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        /* Navbar Moderno */
        .navbar {
            background-color: #f5f5f5; /* Mantener color blanco hueso */
            border-bottom: 1px solid #ddd;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .navbar-nav .nav-link {
            font-size: 1rem;
            font-weight: 500;
            color: #333;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #007bff; /* Azul moderno */
        }

        .navbar-toggler {
            border-color: #ddd;
        }

        .dropdown-menu {
            border-radius: 0.25rem;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        #sidebar {
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: #f5f5f5;
            width: 250px;
            padding-top: 60px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        #sidebar a {
            display: block;
            padding: 10px 20px;
            color: #333;
            text-decoration: none;
            font-weight: 500;
        }

        #sidebar a:hover {
            background-color: #e0e0e0;
        }

        #sidebar i {
            margin-right: 10px; /* Espaciado entre ícono y texto */
        }

        #content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-md shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fas fa-store"></i>{{ config('app.name', 'Laravel') }} <!-- Ícono para la marca -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto"></ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt"></i>{{ __('Login') }} <!-- Ícono de login -->
                                </a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fas fa-user-circle"></i>{{ Auth::user()->name }} <!-- Ícono de usuario -->
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i>{{ __('Logout') }} <!-- Ícono de logout -->
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>


        <!-- Sidebar -->
        <div id="sidebar">
        <a href="{{ route('dashboard.index') }}">
                <i class="fas fa-tachometer-alt me-2"></i>Inicio <!-- Ícono de clientes -->
            </a>
            <a href="{{ route('clients.index') }}">
                <i class="fas fa-users"></i>Clientes <!-- Ícono de clientes -->
            </a>
            <a href="{{ route('providers.index') }}">
                <i class="fas fa-truck"></i>Proveedores <!-- Ícono de proveedores -->
            </a>
            <a href="{{ route('categories.index') }}">
                <i class="fas fa-tags"></i>Categorías <!-- Ícono de categorías -->
            </a>
            <a href="{{ route('products.index') }}">
                <i class="fas fa-box me-2"></i>Productos <!-- Ícono de categorías -->
            </a>
            <a href="#administracionSubmenu" data-bs-toggle="collapse">
                <i class="fas fa-cogs"></i>Administración <!-- Ícono de administración -->
            </a>
            <div id="administracionSubmenu" class="collapse submenu">
                <a href="{{ route('users.index') }}"><i class="fas fa-users-cog"></i>Usuarios</a>
            </div>
            <a href="{{ route('purchases.index') }}">
                <i class="fas fa-shopping-cart"></i>Compras <!-- Ícono de compras -->
            </a>
            <a href="{{ route('sales.index') }}">
                <i class="fas fa-credit-card"></i>Ventas <!-- Ícono de ventas -->
            </a>
            <a href="#">
                <i class="fas fa-cogs"></i>Ajustes <!-- Ícono de ajustes -->
            </a>
        </div>

        <!-- Main Content -->
        <div id="content">
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
