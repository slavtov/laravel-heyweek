@extends('layouts.admin')

@section('title', __('interface.posts'))

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
            @include('includes.admin.buttons', ['active' => 'home.posts'])
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-8 order-md-1">
      <div class="card mb-4">
        <h5 class="card-header d-flex align-items-center justify-content-between">
          {{ __('home.posts') }}
          <a href="{{ route('post.create') }}" class="btn btn-sm btn-success">
            {{ __('interface.create', ['name' => __('interface.post')]) }}
          </a>
        </h5>

        <div class="card-body">
          @if ($posts->isNotEmpty())
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                    <tr>
                      <th>{{ __('home.post') }}</th>
                      <th>User</th>
                      <th class="text-center">Date</th>
                      <th class="text-center">Views</th>
                      <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($posts as $post)
                    <tr>
                      <th>
                        <a href="{{ route('post.show', $post->alias) }}" class="text-dark">
                          {{ Str::limit($post->{'title_' . app()->currentLocale()}, 30) }}
                        </a>
                      </th>
                      @can('update-users')
                        <th>
                          <a href="{{ route('users.show', $post->user->id) }}" class="text-dark">
                            {{ $post->user->name }}
                          </a>
                        </th>
                      @else
                        <td>{{ $post->user->name }}</td>
                      @endcan
                      <td class="text-nowrap text-center">
                        {{ $post->created_at->format('H:i - d M Y') }}
                      </td>
                      <td class="text-center">
                        {{ $post->views->all }}
                      </td>
                      <td>
                        @canany(['update-posts', 'update', 'delete-posts'], $post)
                          <div class="d-flex justify-content-center my-2">
                            @canany(['update', 'update-posts'], $post)
                              <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-light mr-2 border">
                                {{ __('interface.edit') }}
                              </a>
                            @endcanany

                            @can('delete-posts')
                              <form action="{{ route('post.destroy', $post->id) }}" method="POST">
                                @method('DELETE')
                                @csrf

                                <button type="submit" class="btn btn-sm btn-danger delete">
                                  {{ __('interface.delete') }}
                                </button>
                              </form>
                            @endcan
                          </div>
                        @endcanany
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            @include('includes.pagination', ['object' => $posts])
          @else
            <span class="text-danger">
              {{ __('interface.not_found') }}
            </span>
          @endif
        </div>
      </div>

      @if (Auth::user()->isAdmin())
        <div class="card mb-4">
          <h5 class="card-header d-flex align-items-center justify-content-between">
            Slider
            <a href="#" class="btn btn-sm btn-success">
              {{ __('interface.add', ['name' => __('interface.post')]) }}
            </a>
          </h5>

          <div class="card-body">
            @if ($slider->isNotEmpty())
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Post</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($slider as $item)
                      <tr>
                        <th>{{ $item->id }}</th>
                        <th>
                          <a
                            href="{{ route('post.show', $item->post->alias) }}"
                            class="text-dark"
                          >
                            {{ $item->post->{'title_' . app()->currentLocale()} }}
                          </a>
                        </th>
                        @canany(['update-posts', 'delete-posts'])
                          <td>
                            <div class="d-flex justify-content-center my-2">
                              @can('update-posts')
                                <a href="#" class="btn btn-sm btn-light mr-2 border">
                                  {{ __('interface.edit') }}
                                </a>
                              @endcan

                              @can('delete-posts')
                                <form action="#" method="POST">
                                  @method('DELETE')
                                  @csrf

                                  <button
                                    type="submit"
                                    class="btn btn-sm btn-danger delete"
                                  >
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

              @include('includes.pagination', ['object' => $slider])
            @else
              <span class="text-danger">
                {{ __('interface.not_found') }}
              </span>
            @endif
          </div>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
