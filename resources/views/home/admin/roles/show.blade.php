@extends('layouts.admin')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8">
      <div class="card mb-4">
        <h5 class="card-header">
          Role #{{ $role->id }}
        </h5>

        <div class="card-body">
          @include('includes.errors')

          <p>
            Role name:
            {{ $role->name }}
          </p>
          <p>
            {{ __('home.permissions') }}:
            @foreach ($role->permissions as $permission)
              <span class="badge badge-primary">
                {{ $permission->name }}
              </span>
            @endforeach
          </p>

          <div class="row">
            <div class="col-6">
              <a
                href="{{ route('roles.add', $role->id) }}"
                class="btn btn-lg d-block btn-info"
              >
                Add user
              </a>
            </div>
            <div class="col-6">
              <a
                href="{{ route('roles.edit', $role->id) }}"
                class="btn btn-lg d-block btn-light border"
              >
                {{ __('interface.edit') }}
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-header">
          {{  __('home.users') }}
        </div>

        <div class="card-body">
          @if ($users->isNotEmpty())
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Date</th>
                    @canany(['update-users', 'delete-users'])
                      <th class="text-center">Action</th>
                    @endcanany
                  </tr>
                </thead>
                <tbody>
                  @foreach ($users as $user)
                    <tr>
                      <th>
                        <a href="{{ route('users.show', $user->id) }}" class="text-dark">
                          {{ $user->name }}
                        </a>
                      </th>
                      <td>{{ $user->email }}</td>
                      <td>{{ $user->created_at->format('H:i - d M Y') }}</td>
                      @canany(['update-users', 'delete-users'])
                        <td>
                          <div class="d-flex justify-content-center">
                            @can('update-users')
                              <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-light mr-2 border">
                                Edit
                              </a>
                            @endcan

                            @can('delete-users')
                              <form action="{{ route('roles.delete', $user->id) }}" method="POST">
                                @method('DELETE')
                                @csrf

                                <input type="hidden" name="role" value="{{ $role->id }}">

                                <button type="submit" class="btn btn-sm btn-danger delete">
                                  {{ __('interface.delete') }}
                                </button>
                              </form>
                            @endcan
                          </div>
                        </td>
                      @endcanany
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            @include('includes.pagination', ['object' => $users])
          @else
            <span class="text-danger">
              {{ __('interface.not_found') }}
            </span>
          @endif
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
