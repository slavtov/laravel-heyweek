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
            @include('includes.admin.buttons', ['active' => 'home.categories'])
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-8 order-md-1">
      @include('includes.success')

      <div class="card mb-4">
        <h5 class="card-header d-flex align-items-center justify-content-between">
          {{ __('home.categories') }}
          <a href="{{ route('categories.create') }}" class="btn btn-sm btn-success">
            {{ __('interface.add', ['name' => __('interface.category')]) }}
          </a>
        </h5>

        <div class="card-body">
          @if ($categories->isNotEmpty())
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Color</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                      <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->{'name_' . app()->currentLocale()} }}</td>
                        <td>{{ $category->color }}</td>
                        <td>
                          <div class="d-flex justify-content-center my-1">
                            <a
                              href="{{ route('categories.edit', $category->id) }}"
                              class="btn btn-sm btn-light mr-2 border"
                            >
                              {{ __('interface.edit') }}
                            </a>
                            <form
                              action="{{ route('categories.destroy', $category->id) }}"
                              method="POST"
                            >
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

            @include('includes.pagination', ['object' => $categories])
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
