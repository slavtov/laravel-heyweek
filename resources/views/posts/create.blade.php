@extends('layouts.default')

@section('title', __('interface.create', ['name' => __('interface.post')]))

@section('content')
<div class="row">
  <div class="col-lg-8 mb-4">
    <h1 class="mb-4">
      {{ __('interface.create', ['name' => __('interface.post')]) }}
    </h1>

    @include('includes.errors')

    <form
      action="{{ route('post.store') }}"
      method="post"
      enctype="multipart/form-data"
    >
      @csrf

      <div class="form-group">
        <label for="title">Title</label>
        <input
          type="text"
          class="form-control form-control-lg @error('title') is-invalid @enderror"
          id="title"
          name="title"
          value="{{ old('title') }}"
          required
          autofocus
        >
      </div>

      <div class="form-group">
        <label for="editor">Body</label>
        <editor-component
          name="body"
          state="{{ old('body') }}"
          token="{{ env('EDITOR_API_KEY') }}"
        ></editor-component>
      </div>

      <div class="form-group">
        @foreach ($categories as $category)
          <div class="form-check form-check-inline">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                class="custom-control-input"
                id="category-{{ $category->id }}"
                name="category[]"
                value="{{ $category->id }}"
              >
              <label class="custom-control-label" for="category-{{ $category->id }}">
                {{ $category->{'name_' . app()->currentLocale()} }}
              </label>
            </div>
          </div>
        @endforeach
      </div>

      <div class="form-group">
        <input type="file" accept="image/*" name="img">
      </div>

      <button type="submit" class="btn btn-lg btn-block btn-success">
        {{ __('interface.create', ['name' => __('interface.post')]) }}
      </button>
    </form>
  </div>

  @include('includes.sidebar')
</div>
@endsection
