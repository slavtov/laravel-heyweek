<div class="mt-5 mt-lg-0">
  <!-- Popular this week -->
  @if ($week->isNotEmpty())
    <h3 class="mb-3">
      {{ __('interface.popular_week') }}
    </h3>

    <div class="row">
      @foreach ($week as $post)
        @include('includes.card')
      @endforeach
    </div>
  @endif

  <!-- Trending -->
  @if ($trending->isNotEmpty())
    <h3 class="my-3">
      {{ __('interface.trending') }}
    </h3>

    <div class="row">
      @foreach ($trending as $post)
        @include('includes.card')
      @endforeach
    </div>
  @endif

  <!-- Very interesting -->
  @if ($interesting->isNotEmpty())
    <h3 class="my-3">
      {{ __('interface.very_interesting') }}
    </h3>

    <div class="row">
      @foreach ($interesting as $post)
        @include('includes.card')
      @endforeach
    </div>
  @endif
</div>
