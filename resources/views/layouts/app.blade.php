<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Locadora Carros API</title>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script
  src="https://code.jquery.com/jquery-3.6.4.js"
  integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
  crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js" integrity="sha512-d4KkQohk+HswGs6A1d6Gak6Bb9rMWtxjOa0IiY49Q3TeFd5xAzjWXDCBW9RS7m86FQ4RzM2BdHmdJnnKRYknxw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!-- Scripts -->
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
  <div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
      <div class="container">
        <a class="navbar-brand" href="{{ url('/home') }}">
          Rent Cars BSB
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->
          @auth
          <ul class="navbar-nav me-auto" id="views">
            <ul class="navbar-nav me-auto">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  Veiculos
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{ route('marcas') }}">Lista de Marcas</a></li>
                  <li><a class="dropdown-item" href="{{ route('modelos') }}">Lista de Modelos</a></li>
                  <li><a class="dropdown-item" href="{{ route('carros') }}">Lista de Carros</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  Locações
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{ route('clientes') }}">Lista de Clientes</a></li>
                  <li><a class="dropdown-item" href="{{ route('locacoes') }}">Lista de Locações</a></li>
                </ul>
              </li>
            </ul>
          </ul>
          @endauth

          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ms-auto" id="login">
            @auth
            <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }}
              </a>

              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                  {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
              </div>
            </li>
            @endauth
          </ul>
        </div>
      </div>
    </nav>

    @auth
    <div class="container mt-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('home')}}">Início</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ Route::currentRouteName() }}</li>
        </ol>
      </nav>
    </div>
    @endauth

    <main class="py-4">
      @yield('content')
    </main>
  </div>
</body>

</html>