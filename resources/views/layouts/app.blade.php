<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Brief') }}</title>

    <link rel="shortcut icon" type="image/png" href="{{ asset('/images/logo.png') }}">
    <link rel="shortcut icon" sizes="192x192" href="{{ asset('/images/logo.png') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">

    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">


    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Artifakt&display=swap" rel="stylesheet">



    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">



    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap"



        rel="stylesheet">


        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- JQUERY Reference -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Spectrum Color Picker -->
    <script src="https://cdn.jsdelivr.net/npm/spectrum-colorpicker2/dist/spectrum.min.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/spectrum-colorpicker2/dist/spectrum.min.css">




    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/img'])
    @vite('resources/js/menuburger.js')
    @vite('resources/js/validateUserRegister.js')


    {{-- bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    
   

</head>

<body>

    {{-- <style>
        /* Agrega estilos CSS para la clase "active" */
        .sidebar-nav .sidebar-item .sidebar-link.active-link {
    color: yellow;
}

    </style> --}}

    <div class="wrapper">
        @if (Route::currentRouteName() !== 'login')
            <div class="wrapper">
                <aside id="sidebar">
                    <button class="toggle-btn" type="button">
                        <img class="flecha" src="/images/recursos/flecha.png" width="20px" height="20px"></img>
                    </button>
                    <div class="d-flex">

                        <div class="sidebar-logo">
                            <img src="../images/recursos/foto-perfil.png" alt="" class="img-fluid"
                                width="50%" height=50%>
                        </div>
                    </div>
                    <ul class="sidebar-nav">

                        @can('users.index')
                            <li class="sidebar-item">
                                <a href="{{ route('users.index') }}" class="sidebar-link">
                                    <i class="lni lni-users"></i>
                                    <span>Usuarios</span>
                                </a>
                                <hr class="hrmenu">
                            </li>
                        @endcan

                        @can('roles.index')
                            <li class="sidebar-item">
                                <a href="{{ route('roles.index') }}" class="sidebar-link">
                                    <i class="lni lni-user"></i>
                                    <span>Rol</span>
                                </a>
                                <hr class="hrmenu">
                            </li>
                        @endcan

                        <li class="sidebar-item">
                            <a href="{{ route('estados.index') }}" class="sidebar-link">
                                <i class="lni lni-reload"></i>
                                <span>Estados</span>
                            </a>
                            <hr class="hrmenu">
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('politicas.index') }}" class="sidebar-link">
                                <i class="lni lni-handshake"></i>
                                <span>Politicas</span>
                            </a>
                            <hr class="hrmenu">
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('personalizaciones.index') }}" class="sidebar-link">
                                <i class="fa-regular fa-pen-to-square"></i>
                                <span>Personalizaciones</span>
                            </a>
                            <hr class="hrmenu">
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                                data-bs-target="#eventos" aria-expanded="false" aria-controls="auth">
                                <i class="fa-regular fa-calendar-days"></i>
                                <span> Eventos</span>
                            </a>
                            <hr class="hrmenu">
                            <ul id="eventos" class="sidebar-dropdown list-unstyled collapse"
                                data-bs-parent="#sidebar">
                                <li class="sidebar-item">
                                    <a href="{{ route('categorias-eventos-especiales.index') }}"
                                        class="sidebar-link">Categoria de eventos </a>

                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('eventos-especiales-por-categorias.index') }}"
                                        class="sidebar-link">Eventos especiales </a>

                                </li>

                            </ul>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                                data-bs-target="#nodos" aria-expanded="false" aria-controls="auth">
                                <i class="fa-solid fa-location-dot"></i>
                                <span>Tecnoparques</span>
                            </a>
                            <hr class="hrmenu">
                            <ul id="nodos" class="sidebar-dropdown list-unstyled collapse"
                                data-bs-parent="#sidebar">
                                <li class="sidebar-item">
                                    <a href="{{ route('nodos.index') }}" class="sidebar-link">Nodos</a>

                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('departamentos.index') }}"
                                        class="sidebar-link">Departamentos</a>

                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('ciudades.index') }}" class="sidebar-link">Ciudades</a>

                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                                data-bs-target="#solicitudes" aria-expanded="false" aria-controls="auth">
                                <i class="fa-solid fa-envelope-open-text"></i>
                                <span>Solicitud</span>
                            </a>
                            <hr class="hrmenu">
                            <ul id="solicitudes" class="sidebar-dropdown list-unstyled collapse"
                                data-bs-parent="#sidebar">
                                <li class="sidebar-item">
                                    <a href="{{ route('solicitudes.index') }}" class="sidebar-link">Solicitudes</a>

                                </li>
                                <li class="sidebar-item">

                                    <a href="{{ route('tipos-de-solicitudes.index') }}" class="sidebar-link">Tipo de
                                        solicitudes</a>

                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('servicios-por-tipos-de-solicitudes.index') }}"
                                        class="sidebar-link">Servicios x tipo de solicitud</a>

                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('estados-de-las-solictudes.index') }}"
                                        class="sidebar-link">Estados de las solicitudes</a>

                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('datos-unicos-por-solicitudes.index') }}"
                                        class="sidebar-link">Datos únicos x solicitud</a>

                                </li>
                            </ul>
                        </li>

                        @can('tiposDeDato.index')
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                                    data-bs-target="#datos" aria-expanded="false" aria-controls="auth">
                                    <i class="fa-solid fa-magnifying-glass-chart"></i>
                                    <span>Datos</span>
                                </a>
                                <hr class="hrmenu">
                                <ul id="datos" class="sidebar-dropdown list-unstyled collapse"
                                    data-bs-parent="#sidebar">
                                    <li class="sidebar-item">
                                        <a href="{{ route('tipos-de-datos.index') }}" class="sidebar-link">Tipo de
                                            datos</a>

                                    </li>

                                </ul>
                            </li>
                        @endcan

                        {{-- <li class="sidebar-item">
                            <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                                data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
                                <i class="lni lni-layout"></i>
                                <span>solicitudes</span>
                            </a>
                            <hr class="hrmenu">
                            <ul id="multi" class="sidebar-dropdown list-unstyled collapse"
                                data-bs-parent="#sidebar">
                                <li class="sidebar-item">
                                    <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#multi-two" aria-expanded="false" aria-controls="multi-two">
                                        Tipos de solicitudes
                                    </a>
                                    <hr class="hrmenu">
                                    <ul id="multi-two" class="sidebar-dropdown list-unstyled collapse">
                                        <li class="sidebar-item">
                                            <a href="#" class="sidebar-link">Link 1</a>
                                            <hr class="hrmenu">
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="#" class="sidebar-link">Link 2</a>
                                            <hr class="hrmenu">
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li> --}}

                    </ul>
                    <div class="sidebar-footer">
                        <a href="{{ route('logout') }}" class="sidebar-link"
                            onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">

                            <i class="lni lni-exit"></i>
                            <span>{{ __('Cerrar Sesión') }}</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>

                        <div class="text-center pb-2 textFooter">
                            <h1 class="textbrief" style="color: #fff;font-size:50px;font-weight:600;">Brief</h1>
                            <p class="textbriefsol">Plataforma de solicitudes</p>
                        </div>
                    </div>

                </aside>

            </div>
        @endif

        <div class="main">
            <div class="">
                <main class="">
                    @if (Route::currentRouteName() !== 'login')
                        <header class="container-fluid  "
                            style="align-items: center; margin-top: 55px; margin-bottom: 50px">
                            <div class="row d-flex justify-content-between">
                                <!-- Carta Izquierda -->
                                <div class="col-xl-9 col-lg-7 col-md-8 col-sm-8 col-12 mb-3 ">
                                    <div class="">
                                        <div class="text-wel mx-5">
                                            <h5 class="welcoRe">BIENVENIDO</h5>
                                            <div>
                                                <h2>
                                                    <span class="primeraPalabraFlex">SUPER -</span><span
                                                        class="segundaPalabraFlex"> ADMIN</span>
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Carta Derecha -->
                                <div class="col-xl-3 col-lg-5 col-md-4 col-sm-4 col-12">
                                    @if (isset($logo))
                                        <img class="img-fluid" id="logoHeader"
                                            src="data:image/png;base64,{{ base64_encode($logo) }}"></img>
                                    @endif
                                </div>
                            </div>

                        </header>
                    @endif
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
</body>

<!-- All the shared styles will be here -->
<style>
    #sidebar {
        width: 70px;
        min-width: 70px;
        z-index: 1000;
        transition: all .25s ease-in-out;
        background: linear-gradient(to bottom, {{ $colorPrincipal }}, {{ $colorSecundario }});
        display: flex;
        flex-direction: column;
        position: relative;
    }

    /* LETRA */


    .textbriefsol {
        color: {{ $colorTerciario }};
        margin-block-start: -15px;
    }

    /*COLOR DE LETRAS */
    .primeraPalabraFlex {
        margin-right: 10px;
        color: {{ $colorSecundario }};

    }

    .segundaPalabraFlex {
        color: {{ $colorPrincipal }};
        font-weight: 900;

    }

    .hrmenu {
        background: {{ $colorTerciario }};
        border: none;
        height: 1px;
        width: 80%;
        opacity: 20;
        margin: 0 auto;

    }

    /*diseño del icono select*/

    .circle {
        margin-block-start: 80%;
        right: 50%;
        top: 50%;
        width: 120%;
        height: 120%;
        border-radius: 60%;
        background-color: {{ $colorSecundario }};
    }

    .circle-play {

        position: absolute;
        top: 50%;
        right: 10px;
        width: 24px;
        height: 24px;
        position: relative;
        transform: translateY(-50%);
    }

    .icono {
        position: absolute;
        right: 2%;
        top: 50%;
        transform: translateY(-50%);
        justify-content: center;
        align-items: center;


    }

    .triangle {
        position: absolute;
        transform: rotate(325deg);
        margin-left: 3%;
        margin-top: -8%;
        width: 8%;
        height: 14%;
        left: 9px;
        top: 9px;
        border-top: 8px solid transparent;
        border-bottom: 4px solid transparent;
        border-left: 12px solid {{ $colorPrincipal }};
    }
</style>

</html>
