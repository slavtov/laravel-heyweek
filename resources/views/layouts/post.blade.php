<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->currentLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="keywords" content="{{ __('home.keywords') }}">
  <meta name="robots" content="noarchive">

  <meta property="og:site_name" content="{{ config('app.name') }}">
  <meta property="og:title" content="@yield('title', config('app.name'))">
  <meta property='og:type' content="article">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:image" content="@yield('img')">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="twitter:card" content="summary_large_image">
  <meta property="article:published_time" content="@yield('time')">
  @yield('updated_time')

  <meta name="twitter:title" content="@yield('title', config('app.name'))">
  <meta name="twitter:image" content="@yield('img')">
  <meta name="twitter:image:width" content="1200">
  <meta name="twitter:image:height" content="630">

  <title>@yield('title', config('app.name'))</title>

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
