@extends('layouts.admin')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8">
      @include('includes.success')

      <div class="card mb-4">
        <h5 class="card-header">
          {{ __('home.permissions') }}
        </h5>

        <div class="card-body">
          <a href="{{ route('permissions.create') }}" class="btn btn-success mb-3">
            {{ __('interface.add', ['name' => __('interface.permission')]) }}
          </a>

          @if ($permissions->isNotEmpty())
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
                  @foreach ($permissions->sortBy('id') as $permission)
                    <tr>
                      <td>{{ $permission->id }}</td>
                      <td>
                        {{ $permission->name }}

                        @if ($permission->roles->isNotEmpty())
                          <div>
                            @foreach ($permission->roles as $role)
                              <a href="{{ route('roles.show', $role->id) }}" class="badge badge-primary">{{ $role->name }}</a>
                            @endforeach
                          </div>
                        @endif
                      </td>
                      <td>
                        <div class="d-flex justify-content-center my-2">
                          <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-sm btn-light mr-2 border">Edit</a>
                          <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST">
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

            @include('includes.pagination', ['object' => $permissions])
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
            @include('includes.admin.buttons', ['active' => 'home.permissions'])
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
