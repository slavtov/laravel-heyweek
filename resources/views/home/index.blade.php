@extends('layouts.app')

@section('title', __('home.dashboard'))

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-4 order-md-2 mb-3">
      <div class="card">
        <div class="card-body">
          <div class="text-center mb-3">
            <i class="fas fa-user p-3 border rounded-circle"></i>

            <h3>{{ Auth::user()->name }}</h3>
          </div>
          <div class="list-group">
            <a
              href="#"
              class="list-group-item list-group-item-action border-0 rounded active"
            >
              {{ __('home.dashboard') }}
            </a>
            <a
              href="{{ route('home.posts') }}"
              class="list-group-item list-group-item-action border-0 rounded"
            >
              {{ __('home.my_posts') }}
            </a>
            <a
              href="{{ route('home.comments') }}"
              class="list-group-item list-group-item-action border-0 rounded"
            >
              {{ __('home.my_comments') }}
            </a>
            <a
              href="{{ route('home.settings') }}"
              class="list-group-item list-group-item-action border-0 rounded"
            >
              {{ __('home.settings') }}
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-8 order-md-1">
      <div class="card">
        <div class="card-header">
          {{ __('home.dashboard') }}
        </div>

        <div class="card-body">
          @include('includes.success')

          @if ($waitingPosts->isNotEmpty())
            <h5>
              <i class="far fa-clock"></i>
              {{ __('home.waiting_posts') }}
            </h5>

            <div class="table-responsive rounded mb-4">
              <table class="table table-hover border">
                <thead class="thead-light">
                  <tr class="text-center">
                    <th class="text-left" scope="col">Title</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($waitingPosts as $post)
                    <tr class="text-center">
                      <td class="text-left">
                        {{ Str::limit($post->{'title_' . app()->currentLocale()}, 30) }}
                      </td>
                      <td>
                        {{ $post->created_at->diffForHumans() }}
                      </td>
                      <td>
                        <a
                          href="{{ route('post.edit', $post->id) }}"
                          class="btn btn-sm btn-light border"
                        >
                          {{ __('interface.edit') }}
                        </a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif

          <div class="row">
            <div class="col">
              <div class="jumbotron text-center py-5">
                <h5>{{ __('home.posts') }}</h5>

                <p class="lead">{{ $qtyPosts }}</p>
              </div>
            </div>
            <div class="col">
              <div class="jumbotron text-center py-5">
                <h5>{{ __('home.comments') }}</h5>

                <p class="lead">{{ $qtyPosts }}</p>
              </div>
            </div>
          </div>

          <h5 class="mt-2">
            {{ __('home.latest_posts') }}
          </h5>

          @if ($latestPosts->isNotEmpty())
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th scope="col">Title</th>
                    <th class="text-center" scope="col">Date</th>
                    <th class="text-center" scope="col">Views</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($latestPosts as $post)
                    <tr>
                      <th>
                        <a
                          href="{{ route('post.show', $post->alias) }}"
                          class="text-dark"
                        >
                          {{ Str::limit($post->{'title_' . app()->currentLocale()}, 30) }}
                        </a>
                      </th>
                      <td class="text-center">
                        {{ $post->created_at->diffForHumans() }}
                      </td>
                      <td class="text-center">
                        {{ $post->views->all }}
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <a
              href="{{ route('home.posts') }}"
              class="btn btn-sm btn-primary float-right"
            >
              {{ __('home.all_posts') }}
            </a>
          @else
            <span class="text-danger">
              {{ __('interface.not_found') }}
            </span>
          @endif

          <h5 class="mt-5">
            {{ __('home.latest_comments') }}
          </h5>

          @if ($latestComments->isNotEmpty())
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th scope="col">Post</th>
                    <th scope="col">Comment</th>
                    <th class="text-center" scope="col">Date</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($latestComments as $comment)
                    <tr>
                      <th>
                        <a
                          href="{{ route('post.show', $comment->post->alias) }}"
                          class="text-dark"
                        >
                          {{ Str::limit($comment->post->{'title_' . app()->currentLocale()}, 30) }}
                        </a>
                      </th>
                      <td>
                        {{ $comment->body }}
                      </td>
                      <td class="text-center">
                        {{ $comment->created_at->diffForHumans() }}
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <a
              href="{{ route('home.comments') }}"
              class="btn btn-sm btn-primary float-right"
            >
              {{ __('home.all_comments') }}
            </a>
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
