@extends('layouts.app')

@section('title', __('interface.register'))

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          {{ __('interface.register') }}
        </div>

        <div class="card-body">
          <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group row">
              <label for="name" class="col-md-4 col-form-label text-md-right">
                {{ __('home.username') }}
              </label>

              <div class="col-md-6">
                <input
                  type="text"
                  class="form-control @error('name') is-invalid @enderror"
                  id="name"
                  name="name"
                  value="{{ old('name') }}"
                  required
                  autocomplete="name"
                  autofocus
                >

                @error('name')
                  @include('includes.error')
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="email" class="col-md-4 col-form-label text-md-right">
                {{ __('home.email') }}
              </label>

              <div class="col-md-6">
                <input
                  type="email"
                  class="form-control @error('email') is-invalid @enderror"
                  id="email"
                  name="email"
                  value="{{ old('email') }}"
                  required
                  autocomplete="email"
                >

                @error('email')
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
                  autocomplete="new-password"
                >

                @error('password')
                  @include('includes.error')
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label
                for="password-confirm"
                class="col-md-4 col-form-label text-md-right"
              >
                {{ __('home.confirm_password') }}
              </label>

              <div class="col-md-6">
                <input
                  type="password"
                  class="form-control"
                  id="password-confirm"
                  name="password_confirmation"
                  required
                  autocomplete="new-password"
                >
              </div>
            </div>

            <p class="small text-center text-muted">
              {!! __('interface.register_next', [
                'privacy' => route('privacy'),
                'terms' => route('terms')
              ]) !!}
            </p>

            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  {{ __('interface.register') }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <p class="small text-center mt-3">
        {{ __('interface.register_text') }}
        <a href="{{ route('login') }}">
          {{ __('interface.login') }}
        </a>
      </p>
    </div>
  </div>
</div>
@endsection
