@extends('layouts.admin')

@section('title', __('interface.admin'))

@section('content')
<div class="container">
  <div class="row text-center">
    <div class="col-6 col-md-3">
      <div class="jumbotron round">
        <h5>{{ __('home.posts') }}</h5>

        <p class="lead">
          {{ $posts->count() }}
        </p>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="jumbotron round">
        <h5>{{ __('home.users') }}</h5>

        <p class="lead">
          {{ $users->count() }}
        </p>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="jumbotron round">
        <h5>{{ __('home.categories') }}</h5>

        <p class="lead">
          {{ $categories->count() }}
        </p>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="jumbotron round">
        <h5>{{ __('home.comments') }}</h5>

        <p class="lead">
          {{ $comments->count() }}
        </p>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4 order-md-2 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="text-center mb-3">
            <a href="{{ route('home.index') }}" class="text-dark">
              <i class="fas fa-user p-3 border rounded-circle"></i>
            </a>

            <h3>{{ Auth::user()->name }}</h3>

            @foreach (Auth::user()->roles as $role)
              <span class="@if ($role->name == 'admin') text-danger @else text-muted @endif">
                {{ Str::ucfirst($role->name) }}
              </span>
            @endforeach
          </div>

          <div class="list-group">
            @include('includes.admin.buttons', ['active' => 'home.dashboard'])
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-8 order-md-1">
      <div class="card mb-4">
        <h5 class="card-header">
          <i class="far fa-clock"></i>
          {{ __('home.waiting_posts') }}
        </h5>

        <div class="card-body">
          @if ($waitingPosts->isNotEmpty())
            <div class="table-responsive rounded">
              <table class="table table-hover border">
                <thead class="thead-light">
                  <tr class="text-center">
                    <th class="text-left" scope="col">Title</th>
                    <th scope="col">Date</th>
                    <th scope="col">User</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($waitingPosts as $post)
                    <tr>
                      <td>
                        {{ Str::limit($post->{'title_' . app()->currentLocale()}, 30) }}
                      </td>
                      <td class="text-center">
                        {{ $post->created_at->diffForHumans() }}
                      </td>
                      <td class="text-center">
                        {{ $post->user->name }}
                      </td>
                      <td>
                        <div class="d-flex justify-content-center">
                          @if (Auth::user()->isAdmin())
                            <form action="{{ route('post.confirm', $post->id) }}" method="POST">
                              @method('PUT')
                              @csrf

                              <button class="btn btn-sm btn-success">
                                Confirm
                              </button>
                            </form>
                          @endif
                          @can('update', $post)
                            <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-light mx-3 border">
                              {{ __('interface.edit') }}
                            </a>
                          @endcan
                          @if (Auth::user()->isAdmin())
                            <form action="{{ route('post.delete', $post->id) }}" method="POST">
                              @method('DELETE')
                              @csrf

                              <button type="submit" class="btn btn-sm btn-danger delete">
                                {{ __('interface.delete') }}
                              </button>
                            </form>
                          @endif
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            @include('includes.pagination', ['object' => $waitingPosts])
          @else
            <span class="text-danger">
              {{ __('interface.not_found') }}
            </span>
          @endif
        </div>
      </div>

      @if ($leaderboard->count())
        <div class="card mb-4">
          <h5 class="card-header">
            <i class="far fa-check-circle"></i>
            Leaderboard
          </h5>

          <div class="card-body">
            <div class="row text-center">
              @for ($i = 0; $i < count($leaderboard) && $i < 3; $i++)
                <h5 class="{{ $i ? 'col-lg-6' : 'col-12 h4' }}">
                  <span class="place border">
                    {{ $i + 1 }}
                  </span>
                  <span>{{ $leaderboard[$i] }}</span>
                </h5>
              @endfor
            </div>
          </div>
        </div>
      @endif

      <div class="card mb-4">
        <h5 class="card-header">
          <i class="far fa-envelope-open"></i>
          {{ __('home.recent') }}
        </h5>

        <div class="card-body">
          <div class="row text-center">
            <div class="col-4">
              <h5>{{ __('home.post') }}</h5>

              @if ($posts->isEmpty())
                <span class="small text-muted">
                  {{ __('interface.not_found') }}
                </span>
              @else
                <span class="small text-muted">
                  <i class="far fa-clock"></i>
                  {{ $posts->last()->created_at->diffForHumans() }}
                </span>

                <div class="font-weight-bold">
                  <a href="{{ route('post.show', $posts->last()->alias) }}">
                    {{ $posts->last()->{'title_' . app()->currentLocale()} }}
                  </a>
                </div>
              @endif
            </div>

            <div class="col-4">
              <h5>{{ __('home.comment') }}</h5>

              @if ($comments->isEmpty())
                <span class="small text-muted">
                  {{ __('interface.not_found') }}
                </span>
              @else
                <span class="small text-muted">
                  <i class="far fa-clock"></i>
                  {{ $comments->last()->created_at->diffForHumans() }}
                </span>

                <div class="font-weight-bold">
                  <a href="{{ route('comments.edit', $comments->last()->id) }}">
                    {{ $comments->last()->body }}
                  </a>
                </div>
              @endif
            </div>

            <div class="col-4">
              <h5>User</h5>

              @if ($users->isEmpty())
                <span class="small text-muted">
                  {{ __('interface.not_found') }}
                </span>
              @else
                <span class="small text-muted">
                  <i class="far fa-clock"></i>
                  {{ $users->last()->created_at->diffForHumans() }}
                </span>

                <div class="font-weight-bold">
                  <a href="{{ route('users.show', $users->last()->id) }}">
                    {{ $users->last()->name }}
                  </a>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>

      <div class="card">
        <h5 class="card-header">
          <i class="far fa-chart-bar"></i>
          {{ __('home.statistics') }}
        </h5>

        <div class="card-body">
          <table class="table table-bordered text-center mb-0">
            <thead class="thead-light">
              <tr>
                <th scope="col">Date</th>
                <th scope="col">Posts</th>
                <th scope="col">Users</th>
                <th scope="col">Comments</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">Today</th>
                <td>{{ $datePost['today'] }}</td>
                <td>{{ $dateUser['today'] }}</td>
                <td>{{ $dateComment['today'] }}</td>
              </tr>
              <tr>
                <th scope="row">Week</th>
                <td>{{ $datePost['week'] }}</td>
                <td>{{ $dateUser['week'] }}</td>
                <td>{{ $dateComment['week'] }}</td>
              </tr>
              <tr>
                <th scope="row">Month</th>
                <td>{{ $datePost['month'] }}</td>
                <td>{{ $dateUser['month'] }}</td>
                <td>{{ $dateComment['month'] }}</td>
              </tr>
              <tr>
                <th scope="row">Year</th>
                <td>{{ $datePost['year'] }}</td>
                <td>{{ $dateUser['year'] }}</td>
                <td>{{ $dateComment['year'] }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
