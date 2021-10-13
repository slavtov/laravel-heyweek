@extends('layouts.admin')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-4 order-md-2 mb-3">
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

    <div class="col-md-8 order-md-1">
      <div class="card mb-4">
        <h5 class="card-header">
          {{ __('home.users') }}
        </h5>

        <div class="card-body">
          @if ($users->isNotEmpty())
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>{{ __('home.user') }}</th>
                    <th>Email</th>
                    <th class="text-center">Date</th>
                    @canany(['update-users', 'delete-users'])
                      <th class="text-center">Action</th>
                    @endcanany
                  </tr>
                </thead>
                <tbody>
                  @foreach ($users as $user)
                    <tr>
                      @can('update-users')
                        <th class="text-nowrap">
                          <a href="{{ route('users.show', $user->id) }}" class="text-dark">
                            {{ $user->name }}
                          </a>

                          @foreach ($user->roles as $role)
                            <span
                              class="@if ($role->name == 'admin') text-danger @else text-muted @endif"
                              style="font-weight: normal"
                            >
                              {{ Str::ucfirst($role->name) }}
                            </span>
                          @endforeach
                        </th>
                      @else
                        <td class="text-nowrap">
                          {{ $user->name }}
                          @if ($user->roles->isNotEmpty())
                            @foreach ($user->roles as $role)
                              <span
                                class="@if ($role->name == 'admin') text-danger @else text-muted @endif"
                                style="font-weight: normal"
                              >
                                {{ Str::ucfirst($role->name) }}
                              </span>
                            @endforeach
                          @endif
                        </td>
                      @endcan
                      <td>{{ $user->email }}</td>
                      <td class="text-nowrap text-center">
                        {{ $user->created_at->format('H:i - d M Y') }}
                      </td>
                      @canany(['update-users', 'delete-users'])
                        <td>
                          <div class="d-flex justify-content-center my-2">
                            @can('update-users')
                              <a
                                href="{{ route('users.edit', $user->id) }}"
                                class="btn btn-sm btn-light mr-2 border"
                              >
                                {{ __('interface.edit') }}
                              </a>
                            @endcan
                            @can('delete-users')
                              <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                @method('DELETE')
                                @csrf

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
  </div>
</div>
@endsection
