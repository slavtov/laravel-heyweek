@extends('layouts.default')

@section('title', __('policy.privacy'))

@section('content')
<h1 class="font-weight-bold">
  {{ __('policy.privacy') }}
</h1>

<p class="text-muted my-3">
  {{ __('policy.updated') }}:
  {{ __('policy.date') }}
</p>

<p>Text</p>
@endsection
