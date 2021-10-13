@extends('layouts.default')

@section('title', __('policy.terms'))

@section('content')
<h1 class="font-weight-bold">
  {{ __('policy.terms') }}
</h1>

<p class="text-muted my-3">
  {{ __('policy.updated') }}:
  {{ __('policy.date_terms') }}
</p>

<h5 class="font-weight-bold">1. ACCEPTANCE OF TERMS</h5>

<p>Text</p>
@endsection
