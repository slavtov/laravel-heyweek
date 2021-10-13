@extends('layouts.admin')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8">
      @include('includes.success')

      <div class="card mb-4">
        <h5 class="card-header">
          {{ __('home.cache') }}
        </h5>

        <div class="card-body">
          <div class="table-responsive mb-2">
            <table class="table table-borderless table-hover table-dark">
              <thead>
                <tr class="align-items-center">
                  <th scope="col">Key</th>
                  <th scope="col" class="text-center">Busy</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data as $name => $key)
                  <tr>
                    <td scope="row">{{ $name }}</td>
                    <td class="bg-{{ Cache::tags($name)->has($key) ? 'danger' : 'success' }} text-center">
                      @if (Cache::tags($name)->has($key))
                        <a href="{{ route('cache.clear', [$name, $key]) }}" class="btn btn-success">
                          {{ __('interface.delete') }}
                        </a>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <a href="{{ route('cache.clear') }}" class="btn btn-lg d-block btn-primary">
            {{ __('interface.clear_cache') }}
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
            @include('includes.admin.buttons', ['active' => 'Cache'])
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
