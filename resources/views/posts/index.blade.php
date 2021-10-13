@extends('layouts.default')

@section('desc', 'Get inspired!')

@section('content')
<div class="row">
  <div class="col-lg-8">
    <x-slider />

    <post-component link="posts"></post-component>
  </div>

  @include('includes.sidebar')
</div>

<x-trending />
@endsection
