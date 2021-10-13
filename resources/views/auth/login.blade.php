@extends('layouts.app')

@section('title', __('interface.login'))

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          {{ __('interface.login') }}
        </div>

        <div class="card-body">
          <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group row">
              <label for="username" class="col-md-4 col-form-label text-md-right">
                {{ __('home.username') }}
              </label>

              <div class="col-md-6">
                <input
                  type="text"
                  class="form-control @error('username') is-invalid @enderror"
                  id="username"
                  name="username"
                  value="{{ old('username') }}"
                  required
                  autocomplete="username"
                  autofocus
                >

                @error('username')
                  @include('includes.error')
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="password" class="col-md-4 col-form-label text-md-right">
                {{ __('home.password') }}
              </label>

              <div class="col-md-6">
                <input
                  type="password"
                  class="form-control @error('password') is-invalid @enderror"
                  id="password"
                  name="password"
                  required
                  autocomplete="current-password"
                >

                @error('password')
                  @include('includes.error')
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <div class="col-md-6 offset-md-4">
                <div class="form-check">
                  <input
                    type="checkbox"
                    class="form-check-input"
                    id="remember"
                    name="remember"
                    {{ old('remember') ? 'checked' : '' }}
                  >
                  <label for="remember" class="small form-check-label">
                    {{ __('Remember Me') }}
                  </label>
                </div>
              </div>
            </div>

            <div class="form-group row mb-0">
              <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  {{ __('interface.login') }}
                </button>

                @if (Route::has('password.request'))
                  <a class="btn btn-link" href="{{ route('password.request') }}">
                    <span class="small">
                      {{ __('home.forget_password') }}
                    </span>
                  </a>
                @endif
              </div>
            </div>
          </form>
        </div>
      </div>

      <p class="text-center small mt-3">
        {{ __('interface.login_text') }}

        <a href="{{ route('register') }}">
          {{ __('interface.register') }}
        </a>
      </p>
    </div>
  </div>
</div>
@endsection
