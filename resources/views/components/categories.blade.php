<div class="nav-scroller mb-3">
  <nav class="nav d-flex justify-content-between" style="font-size: 18px">
    @foreach ($categories as $category)
      <a class="p-1 text-dark" href="{{ route('category.show', $category->alias) }}">
        {{ $category['name_' . app()->currentLocale()] }}
      </a>
    @endforeach
  </nav>
</div>
