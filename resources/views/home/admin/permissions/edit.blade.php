@extends('layouts.admin')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8">
      <div class="card mb-4">
        <h5 class="card-header">
          {{ __('interface.edit_name', ['name' => __('interface.permission')]) }}
        </h5>

        <div class="card-body">
          <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-group">
              <label for="name">
                Permission name
              </label>
              <input
                type="text"
                class="form-control form-control-lg @error('name') is-invalid @enderror"
                id="name"
                name="name"
                value="{{ $permission->name }}"
                required
                autofocus
              >

              @error('name')
                @include('includes.error')
              @enderror
            </div>

            <div class="form-group">
              @foreach ($roles as $role)
                <div class="form-check form-check-inline">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="role-{{ $role->id }}" name="role[]" value="{{ $role->id }}" @if ($permission->roles->pluck('name')->contains($role->name)) checked @endif>
                    <label class="custom-control-label" for="role-{{ $role->id }}">{{ $role->name }}</label>
                  </div>
                </div>
              @endforeach
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
            @include('includes.admin.buttons', ['active' => 'home.permissions'])
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
