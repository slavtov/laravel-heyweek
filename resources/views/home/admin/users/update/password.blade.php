@extends('layouts.admin')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8">
      <div class="card mb-4">
        <h5 class="card-header">
          Change password
        </h5>

        <div class="card-body">
          @include('includes.errors')

          <form method="post">
            @csrf

            <div class="form-row">
              <div class="col form-group">
                <input
                  type="password"
                  class="form-control"
                  name="password"
                  placeholder="New password"
                  required
                >
              </div>

              <div class="col form-group">
                <input
                  type="password"
                  class="form-control"
                  name="password_confirmation"
                  placeholder="Confirm password"
                  required
                >
              </div>
            </div>

            <button
              type="submit"
              class="btn btn-lg btn-primary btn-block mt-2 mb-3"
            >
              Submit
            </button>
          </form>

          <a href="{{ route('users.show', $user->id) }}">
            {{ __('interface.return_back') }}
          </a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-center align-items-center mb-3">
            <a href="{{ route('home.index') }}" class="text-dark mr-2">
              <i class="fas fa-user p-3 border rounded-circle"></i>
            </a>

            <h3>{{ Auth::user()->name }}</h3>
          </div>

          <div class="list-group">
            @include('includes.admin.buttons', ['active' => 'home.users'])
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
