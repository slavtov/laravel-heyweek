@extends('layouts.admin')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8">
      @include('includes.success')

      <div class="card mb-4">
        <h5 class="card-header">
          Add role
        </h5>

        <div class="card-body">
          @include('includes.errors')

          <form action="{{ route('roles.add', $role->id) }}" method="post">
            @csrf
            <div class="form-group">
              <label for="name">Username</label>
              <input
                type="text"
                class="form-control form-control-lg @error('name') is-invalid @enderror"
                id="name"
                name="name"
                required
              >
            </div>

            <button type="submit" class="btn btn-lg btn-block btn-primary">
              Submit
            </button>
          </form>

          <div class="mt-3">
            <a href="{{ route('roles.show', $role->id) }}">
              {{ __('interface.return_back') }}
            </a>
          </div>
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
            @include('includes.admin.buttons', ['active' => 'home.roles'])
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
