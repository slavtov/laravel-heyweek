<!doctype html>
<html lang="{{ str_replace('_', '-', app()->currentLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

@hasSection('title')
  <title>
    @yield('title')
    {{'| ' . config('app.name') }}
  </title>
@else
  <title>{{ config('app.name') }}</title>
@endif

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
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
      <div class="container">
        <a class="navbar-brand" href="{{ route('main') }}">
          <img
            src="{{ asset('img/logo.png') }}"
            width="90"
            class="d-inline-block align-top"
            style="border-radius: 30px;"
            alt=""
          >
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

        <div class="collapse navbar-collapse text-center small" id="navbarText">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('main') }}">
                {{ __('interface.main') }}
              </a>
            </li>
            <li class="nav-item mb-2 mb-sm-0">
              <a class="nav-link" href="{{ route('contact') }}">
                {{ __('interface.contact') }}
              </a>
            </li>
          </ul>

          @guest
            <a class="btn btn-sm btn-purple mr-2" href="{{ route('login') }}">
              {{ __('interface.login') }}
            </a>

            @if (Route::has('register'))
              <a class="btn btn-sm btn-success" href="{{ route('register') }}">
                {{ __('interface.register') }}
              </a>
            @endif
          @else
            <a href="{{ route('post.create') }}" class="btn btn-sm btn-outline-success mr-2">
              {{ __('interface.create', ['name' => __('interface.post')]) }}
            </a>

            @if (Auth::user()->roles->isNotEmpty())
              <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-primary mr-2">
                {{ __('interface.admin') }}
              </a>
            @endif

            <a href="{{ route('logout') }}" class="btn btn-sm btn-danger" 
              onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
              {{ __('interface.logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          @endguest
        </div>
      </div>
    </nav>

    <main class="py-4">
      @yield('content')
    </main>
  </div>

  @include('includes.footer')
  @include('includes.scripts')
</body>
</html>
