<!DOCTYPE html>
<html lang="{{ app()->currentLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="keywords" content="{{ __('home.keywords') }}">
  <meta name="robots" content="noarchive">
@hasSection('desc')
  <meta name="description" content="@yield('desc')">
@endif

@hasSection('title')
  <title>
    @yield('title')
    {{'| ' . config('app.name') }}
  </title>
@else
  <title>{{ config('app.name') }}</title>
@endif

  <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="48x48" href="/favicon-48x48.png">
  <link rel="icon" type="image/png" sizes="60x60" href="/favicon-60x60.png">
  <link rel="icon" type="image/png" sizes="120x120" href="/favicon-120x120.png">
  <link href="{{ asset('css/bundle.css') }}" rel="stylesheet">
</head>
<body>
  <div id="app">
    @include('includes.navbar')

    <div class="container">
      <x-categories />

      @yield('content')
    </div>
  </div>

  @include('includes.footer')
  @include('includes.scripts')
</body>
</html>
