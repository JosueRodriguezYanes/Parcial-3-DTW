<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Título por defecto')</title>
    <!-- Agregar estilos globales -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.css') }}">
    @yield('content-admin-css') <!-- Para estilos específicos de cada vista -->
</head>
<body>
    <header>
        @include('backend.menus.superior') <!-- Incluir el menú superior -->
    </header>

    <main class="content-wrapper">
        @yield('content') <!-- Contenido dinámico de cada vista -->
    </main>

    <footer>
        @include('backend.menus.footerjs') <!-- Incluir el footer -->
    </footer>

    <!-- Agregar scripts globales -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/adminlte.min.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    @yield('archivos-js') <!-- Para scripts específicos de cada vista -->
</body>
</html>