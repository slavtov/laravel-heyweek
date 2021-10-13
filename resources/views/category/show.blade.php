@extends('layouts.default')

@section('title', $category['name_' . app()->currentLocale()])

@section('content')
<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4 text-center">
      {{ $category['name_' . app()->currentLocale()] }}
    </h1>
  </div>
</div>

<div class="row">
  <div class="col-md-8">
    <post-component link="categories/{{ $category->alias }}"></post-component>
  </div>

  @include('includes.sidebar')
</div>

<x-trending />
@endsection
