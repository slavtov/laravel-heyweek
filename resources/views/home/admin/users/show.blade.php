@extends('layouts.admin')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8">
      @include('includes.success')

      <div class="card mb-4">
        <h5 class="card-header">
          User #{{ $user->id }}
        </h5>

        <div class="card-body">
          <h3>{{ $user->name }}</h3>

          <p>{{ $user->email }}</p>
          <p>Email verified: {{ $user->email_verified_at ?? 'None' }}
            @empty($user->email_verified_at)
              <a href="{{ route('confirm.email', $user->id) }}">
                Confirm email
              </a>
            @endempty
          </p>

          <a href="{{ route('change.email', $user->id) }}" class="btn btn-primary mr-2">
            Change email
          </a>
          <a href="{{ route('change.username', $user->id) }}" class="btn btn-primary mr-2">
            Change username
          </a>
          <a href="{{ route('change.password', $user->id) }}" class="btn btn-primary">
            Change password
          </a>
          <a href="{{ route('users.index') }}" class="d-block mt-3">
            {{ __('interface.return_back') }}
          </a>
        </div>
      </div>

      @if ($posts->isNotEmpty())
        <div class="card mb-4">
          <div class="card-header">
            {{ __('home.posts') }}
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Post</th>
                    <th>Created_at</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($posts as $post)
                    <tr>
                      <th><a href="{{ route('post.show', $post->alias) }}" class="text-dark">{{ $post->{'title_' . app()->currentLocale()} }}</a></th>
                      <td>{{ $post->created_at->format('H:i - d M Y') }}</td>
                      <td>
                        <div class="my-2 d-flex">
                          <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-light mr-2 border">Edit</a>
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
          </div>
        </div>
      @endif

      @if ($comments->isNotEmpty())
        <div class="card mb-4">
          <div class="card-header">
            {{ __('home.comments') }}
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Post</th>
                    <th>Comment</th>
                    <th>Created_at</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($comments as $comment)
                    <tr>
                      <th>
                        <a href="{{ route('post.show', $comment->post->alias) }}" class="text-dark">
                          {{ $comment->post->{'title_' . app()->currentLocale()} }}
                        </a>
                      </th>
                      <td>{{ $comment->body}}</td>
                      <td>{{ $comment->created_at->format('H:i - d M Y') }}</td>
                      <td>
                        <div class="my-2 d-flex">
                          <a href="{{ route('post.edit', $comment->id) }}" class="btn btn-sm btn-light mr-2 border">
                            Edit
                          </a>

                          <form action="{{ route('post.destroy', $comment->id) }}" method="POST">
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

            @include('includes.pagination', ['object' => $comments])
          </div>
        </div>
      @endif
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
            @include('includes.admin.buttons', ['active' => 'home.users'])
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
