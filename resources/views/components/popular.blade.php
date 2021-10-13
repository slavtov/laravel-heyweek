@if ($posts->isNotEmpty())
<div class="card my-4 round">
  <div class="card-body">
    <h5 class="text-center mb-4">
      {{ __('interface.popular_now') }}
    </h5>

    <div class="row">
      @foreach ($posts as $key => $post)
        <div class="col-12 card border-0 mb-3">
          <a href="{{ route('post.show', $post->alias) }}">
            <img
              class="card-img border round"
              src="{{ $post['img_' . app()->currentLocale()] ? asset($post['img_' . app()->currentLocale()]) : asset('img/default.png') }}"
              alt="Card image cap"
            >
          </a>

          <div class="card-body mt-2 p-0 text-center">
            @if ($post->categories->isNotEmpty())
              <div class="font-weight-bold">
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
          </div>

          <h4 class="card-title mt-1">
            <a href="{{ route('post.show', $post->alias) }}" class="text-dark">
              {{ $post['title_' . app()->currentLocale()] }}
            </a>
          </h4>

          @if ($posts->keys()->last() != $key) <hr> @endif
        </div>
      @endforeach
    </div>
  </div>
</div>
@endif
