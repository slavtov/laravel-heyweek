@extends('layouts.post')

@section('title', $post['title_' . app()->currentLocale()])
@section('img', $post['img_' . app()->currentLocale()] ? asset($post['img_' . app()->currentLocale()]) : asset('img/default.png'))
@section('time', $post->created_at->format('c'))

@if ($post->created_at != $post->updated_at)
  @section('updated_time')
    <meta property="article:modified_time" content="{{ $post->updated_at->format('c') }}">
    <meta property="og:updated_time" content="{{ $post->updated_at->format('c') }}">
  @endsection
@endif

@section('content')
@include('includes.success')

<div class="row">
  <div class="col-lg-8">
    <h1 class="font-weight-bold mb-3 title">
      {{ $post['title_' . app()->currentLocale()] }}
    </h1>

    @canany(['update', 'update-posts', 'delete'], $post)
      <div class="my-3 d-flex">
        @canany(['update', 'update-posts'], $post)
          <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-light mr-2 border">
            Edit
          </a>
        @endcanany
        @can('delete', $post)
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

    <div class="clearfix">
      @if ($post->categories->isNotEmpty())
        <div class="float-left">
          @foreach ($post->categories as $category)
            <a
              href="{{ route('category.show', $category->alias) }}"
              class="font-weight-bold mr-1"
              {{ $category->color ? 'style=color:' . $category->color : null }}
            >
              {{ $category['name_' . app()->currentLocale()] }}
            </a>
          @endforeach
        </div>
      @endif

      <div class="float-right">
        <div class="text-gray">
          <a class="text-decoration-none text-gray mr-3" href="#comments">
            <i class="far fa-comment"></i>
            {{ $commentsCount }}
          </a>

          <span>
            <i class="far fa-eye"></i>
            {{ cache('views:now:' . $post->id) }}
          </span>
        </div>
      </div>
    </div>

    <img
      class="border w-100 mt-3"
      src="{{ $post['img_' . app()->currentLocale()] ? asset($post['img_' . app()->currentLocale()]) : asset('img/default.png') }}"
      style="border-radius: 15px;"
      alt=""
    >

    <div class="content my-4">
      {!! $post['body_' . app()->currentLocale()] !!}
    </div>

    @if ($randomPosts->isNotEmpty())
      <div class="jumbotron text-light py-4 round" style="background: #8f63d2;">
        <h4 class="text-center mt-2 mb-3">
          {{ __('interface.random_posts') }}
        </h4>

        <div class="row">
          @foreach ($randomPosts as $random)
            <div class="col-md-4 mb-3 mb-md-0">
              <img
                class="img-fluid border round"
                src="{{ $random['img_' . app()->currentLocale()] ? asset($random['img_' . app()->currentLocale()]) : asset('img/default.png') }}"
                alt="Card image cap"
              >

              <h5 class="card-title mt-3">
                {{ $random['title_' . app()->currentLocale()] }}
              </h5>

              <a href="{{ route('post.show', $random->alias) }}" class="stretched-link"></a>
            </div>
          @endforeach
        </div>
      </div>
    @endif

    <div class="card mb-4" id="comments">
      <h5 class="card-header">
        {{ __('interface.leave_comment') }}:
      </h5>

      <div class="card-body">
        <form action="{{ route('comment.store', $post->id) }}" method="POST">
          @csrf

          <div class="form-group">
            <textarea class="form-control" rows="3" name="body"></textarea>
          </div>

          <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-purple mr-3 round">
              Submit
            </button>

            <span class="text-muted small">
              {{ __('interface.comment_info') }}
            </span>
          </div>
        </form>
      </div>
    </div>

    @if ($comments->isNotEmpty())
      <div class="mb-5">
        @foreach ($comments as $key => $child)
          @if ($key) @break @endif

          @foreach ($child->sortByDesc('created_at') as $comment)
            <div class="media mb-2">
              <i
                class="fas fa-user text-secondary rounded-circle p-3 mr-2"
                style="background: darkgray;"
              ></i>

              <div class="media-body">
                <div class="d-flex align-items-end">
                  <h5 class="my-0 mr-2">
                    {{ $comment->user ? $comment->user->name : __('home.guest') }}
                  </h5>

                  <span class="small text-muted">
                    <i class="far fa-clock"></i>
                    {{ $comment->created_at->diffForHumans() }}
                  </span>
                </div>

                {{ $comment->body }}

                @if (isset($comments[$comment->id]))
                  @include('includes.comment', ['comments' => $comments[$comment->id]])
                @endif
              </div>
            </div>

            <form action="{{ route('comment.store', $post->id) }}" method="POST" class="mb-4 ml-5">
              @csrf

              <div class="input-group">
                <input class="form-control form-control-sm" type="text" name="body">
                <input type="hidden" name="parent" value="{{ $comment->id }}">

                <div class="input-group-append">
                  <button class="btn btn-sm btn-light border" type="submit">
                    Reply
                  </button>
                </div>
              </div>
            </form>
          @endforeach
        @endforeach
      </div>
    @endif
  </div>

  @include('includes.sidebar')
</div>

<x-trending />
@endsection
