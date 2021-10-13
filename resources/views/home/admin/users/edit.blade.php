@extends('layouts.admin')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8">
      @include('includes.success')

      <div class="card mb-4">
        <h5 class="card-header">User #{{ $user->id }}</h5>

        <div class="card-body">
          <form action="{{ route('users.update', $user->id) }}" method="POST">
            @method('PUT')
            @csrf

            <div class="form-group">
              <label for="name">Name</label>
              <input
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                id="name"
                name="name"
                value="{{ $user->name }}"
                required
                autofocus
              >

              @error('name')
                @include('includes.error')
              @enderror
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                id="email"
                name="email"
                value="{{ $user->email }}"
                required
              >

              @error('email')
                @include('includes.error')
              @enderror
            </div>

            <button type="submit" class="btn btn-lg btn-block btn-primary">
              {{ __('interface.edit') }}
            </button>
          </form>
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
