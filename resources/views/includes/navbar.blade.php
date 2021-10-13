<nav class="navbar navbar-expand-lg navbar-light">
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

    <div class="collapse navbar-collapse text-center" id="navbarText">
      <ul class="navbar-nav mr-auto small">
        <li class="nav-item {{ request()->is(app()->currentLocale() === 'en' ? 'contact' : app()->currentLocale() . '/contact') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('contact') }}">
            {{ __('interface.contact') }}
          </a>
        </li>
      </ul>

      <div class="mr-3 mt-1 mt-lg-0 mb-3 mb-lg-0">
        <div class="dropdown">
          <span class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="{{ asset('img/' . app()->currentLocale() . '.png') }}" class="border rounded" width="20" alt="">
            {{ app()->currentLocale() }}
          </span>

          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            @foreach (config('app.languages') as $lang)
              <a class="dropdown-item" href="{{ url($lang) }}">
                <img src="{{ asset('img/' . $lang . '.png') }}" class="border rounded" width="20" alt="">
                {{ __('interface.' . $lang) }}
              </a>
            @endforeach
          </div>
        </div>
      </div>

      @if (Route::has('login'))
        @auth
          <a href="{{ route('post.create') }}" class="btn btn-sm btn-outline-success mr-2">
            {{ __('interface.create', ['name' => __('interface.post')]) }}
          </a>
          @if (Auth::user()->roles->isNotEmpty())
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-primary mr-2">
              {{ __('interface.admin') }}
            </a>
          @endif
          <a href="{{ route('home.index') }}" class="btn btn-sm btn-primary">
            {{ __('home.profile') }}
          </a>
        @else
          <a href="{{ route('login') }}" class="btn btn-sm d-block btn-purple">
            {{ __('interface.login') }}
          </a>
        @endif
      @endif
    </div>
  </div>
</nav>
