@extends('layouts.admin')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8">
      <div class="card mb-4">
        <h5 class="card-header">
          Change username
        </h5>

        <div class="card-body">
          <h5 class="mb-3">
            Username:
            {{ $user->name }}
          </h5>

          <form method="post">
            @csrf

            <div class="form-group">
              <input
                type="text"
                class="form-control form-control-lg @error('name') is-invalid @enderror"
                name="name"
                placeholder="New username"
                required
                autofocus
              >

              @error('name')
                @include('includes.error')
              @enderror
            </div>

            <button
              type="submit"
              class="btn btn-lg btn-primary btn-block my-3"
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
