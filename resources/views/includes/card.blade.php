<div class="col-6 col-md-3">
  <div class="card border-0">
      <img
        src="{{ $post->{'img_' . app()->currentLocale()} ? asset($post->{'img_' . app()->currentLocale()}) : asset('img/default.png') }}"
        class="card-img border round"
        alt="Card image cap"
      >

      <h5 class="card-title mt-3">{{ $post->{'title_' . app()->currentLocale()} }}</h5>
      <a href="{{ route('post.show', $post->alias) }}" class="stretched-link"></a>
  </div>
</div>
