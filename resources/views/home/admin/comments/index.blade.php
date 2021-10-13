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
            @include('includes.admin.buttons', ['active' => 'home.comments'])
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-8 order-md-1">
      @include('includes.success')

      @canany(['update-comments', 'delete-comments'])
        @if ($waitingComments->isNotEmpty())
          <div class="card mb-4">
            <h5 class="card-header">
              <i class="far fa-clock"></i>
              {{ __('home.waiting_comments') }}
            </h5>

            <div class="card-body">
              <div class="table-responsive rounded">
                <table class="table table-hover border">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">Comment</th>
                      <th class="text-center" scope="col">User</th>
                      <th class="text-center" scope="col">Date</th>
                      <th class="text-center" scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($waitingComments as $comment)
                      <tr>
                        <td>{{ Str::limit($comment->body, 30) }}</td>
                        @can('update-users')
                          <th>
                            @if ($comment->user)
                              <a href="{{ route('users.show', $comment->user->id) }}" class="text-dark">
                                {{ $comment->user->name }}
                              </a>
                            @else
                              {{ __('home.guest') }}
                            @endif
                          </th>
                        @else
                          <td>{{ $comment->user->name ?? __('home.guest') }}</td>
                        @endcan
                        <td class="text-center">
                          {{ $comment->created_at->diffForHumans() }}
                        </td>
                        <td>
                          <div class="d-flex justify-content-center">
                            @can('update-comments')
                              <form action="{{ route('comments.confirm', $comment->id) }}" method="POST">
                                @method('PUT')
                                @csrf

                                <button class="btn btn-sm btn-success">
                                  Confirm
                                </button>
                              </form>

                              <a
                                href="{{ route('comments.edit', $comment->id) }}"
                                class="btn btn-sm btn-light ml-3 border"
                              >
                                {{ __('interface.edit') }}
                              </a>
                            @endcan
                            @can('delete-comments')
                              <form action="{{ route('comments.destroy', $comment->id) }}" class="ml-3" method="POST">
                                @method('DELETE')
                                @csrf

                                <button type="submit" class="btn btn-sm btn-danger delete">
                                  {{ __('interface.delete') }}
                                </button>
                              </form>
                            @endcan
                          </div>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

              @include('includes.pagination', ['object' => $waitingComments])
            </div>
          </div>
        @endif
      @endcanany

      <div class="card mb-4">
        <h5 class="card-header">
          {{ __('home.comments') }}
        </h5>

        <div class="card-body">
          @if ($comments->isNotEmpty())
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>{{ __('home.comment') }}</th>
                    <th>{{ __('home.user') }}</th>
                    <th>{{ __('home.post') }}</th>
                    <th class="text-center">{{ __('home.date') }}</th>
                    @canany(['update-comments', 'delete-comments'])
                      <th class="text-center">{{ __('home.action') }}</th>
                    @endcanany
                  </tr>
                </thead>
                <tbody>
                  @foreach ($comments as $comment)
                    <tr>
                      <td>{{ $comment->body }}</td>
                      @can('update-users')
                        <th>
                          @if ($comment->user)
                            <a href="{{ route('users.show', $comment->user->id) }}" class="text-dark">
                              {{ $comment->user->name }}
                            </a>
                          @else
                            {{ __('home.guest') }}
                          @endif
                        </th>
                      @else
                        <td>{{ $comment->user->name ?? __('home.guest') }}</td>
                      @endcan
                      <th>
                        <a href="{{ route('post.show', $comment->post->alias) }}" class="text-dark">
                          {{ Str::limit($comment->post->{'title_' . app()->currentLocale()}, 30) }}
                        </a>
                      </th>
                      <td class="text-nowrap text-center">
                        {{ $comment->created_at->format('H:i - d M Y') }}
                      </td>
                      @canany(['update-comments', 'delete-comments'])
                        <td>
                          <div class="d-flex justify-content-center my-2">
                            @can('update-comments')
                              <a
                                href="{{ route('comments.edit', $comment->id) }}"
                                class="btn btn-sm btn-light mr-2 border"
                              >
                                {{ __('interface.edit') }}
                              </a>
                            @endcan
                            @can('delete-comments')
                              <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
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

            @include('includes.pagination', ['object' => $comments])
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
