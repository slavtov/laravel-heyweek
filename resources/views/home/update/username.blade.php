@extends('layouts.app')

@section('title', __('home.change_username'))

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          {{ __('home.settings') }}
        </div>

        <div class="card-body">
          @include('includes.errors')

          <h5>
            {{ __('home.username') }}:
            {{ Auth::user()->name }}
          </h5>

          <form method="post">
            @csrf

            <div class="form-group">
              <input
                type="text"
                class="form-control"
                name="name"
                placeholder="New username"
                required
              >
            </div>

            <button type="submit" class="btn btn-lg btn-primary btn-block my-3">
              Submit
            </button>
          </form>

          <a href="{{ route('home.settings') }}">
            {{ __('interface.return_back') }}
          </a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <div class="text-center mb-3">
            <a href="{{ route('home.index') }}" class="text-dark">
              <i class="fas fa-user p-3 border rounded-circle"></i>
            </a>

            <h3>{{ Auth::user()->name }}</h3>
          </div>

          <div class="list-group">
            @include('includes.buttons', ['active' => 'home.settings'])
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
