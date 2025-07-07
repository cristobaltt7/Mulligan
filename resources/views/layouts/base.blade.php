<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">

<head>
    <meta charset="utf-8" />
    <!-- Título de la página, dinámico según la sección -->
    <title>@yield('titulo')</title>
    <!-- Favicon de la página -->
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <!-- Iconos de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
    <!-- jQuery -->
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <!-- Script personalizado para elegir ruta -->
    <script src="{{ asset('js/elegirRuta.js') }}"></script>
    <!-- Sección para agregar scripts adicionales desde otras vistas -->
    @stack('scripts')
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <!-- Botón para colapsar la barra de navegación en dispositivos pequeños -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01"
                aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span>
                    <!-- Logo del toggler -->
                    <img class="navbar-logo rounded-circle" src="{{ asset('img/logoToggler.png') }}" alt="icono">
                    <!-- Ícono de flecha hacia abajo -->
                    <i class="bi bi-caret-down-fill"></i>
                </span>
            </button>
            <!-- Contenido de la barra de navegación -->
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <!-- Logo de la página -->
                <a class="navbar-brand" href="/"><img class="navbar-logo" src="{{ asset('img/logo.png') }}"
                        alt="logo"></a>
                <!-- Lista de enlaces de navegación -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Enlace a la página de inicio -->
                    <li class="nav-item">
                        <a id="link-inicio" class="nav-link" href="/">Inicio <i
                                class="bi bi-house-fill"></i></a>
                    </li>
                    <!-- Enlace a la página de mazos -->
                    <li class="nav-item">
                        <a id="link-mazos" class="nav-link" href="{{ route('decks.all') }}">Mazos <i class="bi bi-folder-fill"></i></a>
                    </li>
                    <!-- Enlace a la página de carta aleatoria -->
                    <li class="nav-item">
                        <a id="link-aleatorio" class="nav-link" href="{{ route('cartaAleatoria') }}">Carta Aleatoria <i
                                class="bi bi-shuffle"></i></a>
                    </li>
                    <!-- Menú desplegable para el perfil del usuario -->
                    <li class="nav-item dropdown">
                        @if(Auth::check()) <!-- Verifica si el usuario está autenticado -->
                            <a id="link-perfil" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Hola {{ Auth::user()->username }} <i class="bi bi-person-fill"></i> <!-- Muestra el nombre del usuario -->
                            </a>
                            <ul class="dropdown-menu">
                                <!-- Enlace para ver el perfil -->
                                <li><a class="dropdown-item" href="/ver-perfil">Ver perfil</a></li>
                                <!-- Enlace para gestionar usuarios (solo para administradores) -->
                                @if(Auth::user()->role === 'admin')
                                    <li><a class="dropdown-item" href="/usuarios/gestionar">Gestionar usuarios</a></li>
                                @endif
                                <!-- Formulario para cerrar sesión -->
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Cerrar Sesión</button>
                                    </form>
                                </li>
                            </ul>
                        @else
                            <!-- Enlace para iniciar sesión si el usuario no está autenticado -->
                            <a class="nav-link" href="{{ route('login') }}">Iniciar sesión <i
                                    class="bi bi-person-fill"></i></a>
                        @endif
                    </li>
                </ul>
                <!-- Barra de búsqueda (excepto en la página de inicio y resultados de búsqueda) -->
                @if($_SERVER['PHP_SELF'] != "/index.php" && !Request::is('buscar/resultados'))
                    <form class="d-flex" action="{{ route('buscarResultados') }}" method="get">
                        <div class="input-group mb-3">
                            <input class="form-control" type="text" name="q" placeholder="Buscar una carta..." aria-label="Search">
                            <button class="btn btn-search" type="submit">Buscar</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </nav>

    <!-- Sección principal del contenido -->
    <section class="mb-4">
    @yield('content') <!-- Contenido dinámico según la vista -->
    </section>

    <!-- Pie de página -->
    <footer class="mt-auto d-flex flex-column align-items-center justify-content-center">
        <!-- Texto del pie de página -->
        <div class="footer-texto">Visita nuestras redes sociales</div>
        <!-- Iconos de redes sociales -->
        <div class="iconos-redes-sociales d-flex flex-wrap align-items-center justify-content-center">
            <a class="" href="https://youtube.com" target="_blank" ref="nooperner noreferrer">
            <i class="bi bi-youtube"></i> <!-- Ícono de YouTube -->
            </a>
            <a class="" href="https://twitter.com" target="_blank" ref="nooperner noreferrer">
                <i class="bi bi-twitter"></i> <!-- Ícono de Twitter -->
            </a>
            <a class="" href="https://facebook.com" target="_blank" ref="nooperner noreferrer">
                <i class="bi bi-facebook"></i> <!-- Ícono de Facebook -->
            </a>
            <a class="" href="https://instagram.com" target="_blank" ref="nooperner noreferrer">
                <i class="bi bi-instagram"></i> <!-- Ícono de Instagram -->
            </a>
            <a href="mailto:micorreo@mail.es" target="_blank" ref="nooperner noreferrer">
                <i class="bi bi-envelope-fill"></i> <!-- Ícono de correo electrónico -->
            </a>
        </div>
        <!-- Texto de derechos de autor -->
        <div class="footer-texto">
            Creado por Victor Delgado, Hugo Jiménez, Cristóbal Trujillo<br>Todos los derechos reservados &#169 2025</div>
    </footer>

</body>

</html>