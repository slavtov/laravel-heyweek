<!doctype html>
<html lang="{{ str_replace('_', '-', app()->currentLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="48x48" href="/favicon-48x48.png">
  <link rel="icon" type="image/png" sizes="60x60" href="/favicon-60x60.png">
  <link rel="icon" type="image/png" sizes="120x120" href="/favicon-120x120.png">
  <link href="{{ asset('css/bundle.css') }}" rel="stylesheet">
</head>
<body>
  <div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
      <div class="container">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
          {{ __('interface.admin') }}
        </a>

        <button
          type="button"
          class="navbar-toggler"
          data-toggle="collapse"
          data-target="#navbarText"
          aria-controls="navbarText"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse text-center" id="navbarText">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('main') }}">
                {{ __('interface.return') }}
              </a>
            </li>
          </ul>

          <div class="navbar-nav mb-2 mb-sm-0">
            <a href="{{ route('home.index') }}" class="nav-link mr-1">
              <i class="far fa-user"></i>
              {{ __('home.profile') }}
            </a>
          </div>

          <a href="{{ route('logout') }}" class="btn btn-sm btn-danger" 
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            {{ __('interface.logout') }}
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      </div>
    </nav>

    <main class="py-4">
      @yield('content')
    </main>
  </div>

  @include('includes.scripts')
</body>
</html>
