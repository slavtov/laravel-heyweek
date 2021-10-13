@extends('layouts.app')

@section('title', __('home.my_posts'))

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-4 order-md-2 mb-3">
      <div class="card">
        <div class="card-body">
          <div class="text-center mb-3">
            <a href="{{ route('home.index') }}" class="text-dark">
              <i class="fas fa-user p-3 border rounded-circle"></i>
            </a>

            <h3>{{ Auth::user()->name }}</h3>
          </div>

          <div class="list-group">
            @include('includes.buttons', ['active' => 'home.my_posts'])
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-8 order-md-1">
      @include('includes.success')

      <div class="card">
        <div class="card-header">
          {{ __('home.posts') }}
        </div>

        <div class="card-body">
          @if ($posts->isNotEmpty())
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>{{ __('home.post') }}</th>
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
                      <td class="text-center">
                        {{ $post->created_at->diffForHumans() }}
                      </td>
                      <td class="text-center">
                        {{ $post->views->all }}
                      </td>
                      <td>
                        <div class="d-flex justify-content-center">
                          <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-light mr-2 border">
                            {{ __('interface.edit') }}
                          </a>

                          <form action="{{ route('post.destroy', $post->id) }}" method="POST">
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

            @include('includes.pagination', ['object' => $posts])
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
