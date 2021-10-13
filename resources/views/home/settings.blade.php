@extends('layouts.app')

@section('title', __('home.settings'))

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-4 order-md-2 mb-3">
      <div class="card">
        <div class="card-body">
          <div class="text-center mb-3">
            <a href="{{ route('home.index') }}" class="text-dark">
              <i class="fas fa-user border rounded-circle p-3"></i>
            </a>

            <h3>{{ Auth::user()->name }}</h3>
          </div>

          <div class="list-group">
            @include('includes.buttons', ['active' => 'home.settings'])
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-8 order-md-1">
      @include('includes.success')

      <div class="card">
        <div class="card-header">
          {{ __('home.settings') }}
        </div>

        <div class="card-body">
          <div class="mb-3">
            <p class="h5">
              Your account:
              {{ Auth::user()->name }}
            </p>
            <p class="h5">
              Email:
              {{ Auth::user()->email }}
            </p>
          </div>

          <a
            href="{{ route('home.email') }}"
            class="btn btn-primary mt-2 mt-sm-0 mr-2"
          >
            {{ __('home.change_email') }}
          </a>
          <a
            href="{{ route('home.username') }}"
            class="btn btn-primary mt-2 mt-sm-0 mr-2"
          >
            {{ __('home.change_username') }}
          </a>
          <a
            href="{{ route('home.password') }}"
            class="btn btn-primary mt-2 mt-sm-0"
          >
            {{ __('home.change_password') }}
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
