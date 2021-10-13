@extends('layouts.admin')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8">
      @include('includes.success')

      <div class="card mb-4">
        <h5 class="card-header">
          {{ __('home.roles') }}
        </h5>

        <div class="card-body">
          <a href="{{ route('roles.create') }}" class="btn btn-success mb-3">
            {{ __('interface.add', ['name' => __('interface.role')]) }}
          </a>

          @if ($roles->isNotEmpty())
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($roles->sortBy('id') as $role)
                    <tr>
                      <td>{{ $role->id }}</td>
                      <th>
                        <a href="{{ route('roles.show', $role->id) }}" class="text-dark">
                          {{ $role->name }}
                        </a>

                        @if ($role->permissions->isNotEmpty())
                          <div>
                            @foreach ($role->permissions as $permission)
                              <span class="badge badge-primary">
                                {{ $permission->name }}
                              </span>
                            @endforeach
                          </div>
                        @endif
                      </th>
                      <td>
                        <div class="d-flex justify-content-center my-2">
                          <a
                            href="{{ route('roles.edit', $role->id) }}"
                            class="btn btn-sm btn-light mr-2 border"
                          >
                            {{ __('interface.edit') }}
                          </a>

                          <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
                            @method('DELETE')
                            @csrf

                            <button type="submit" class="btn btn-sm btn-danger delete">
                              {{ __('interface.delete') }}
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            @include('includes.pagination', ['object' => $roles])
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
