@if ($slider->isNotEmpty())
  <div id="carouselExampleIndicators" class="carousel slide mb-5" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
    </ol>

    <div class="carousel-inner" style="border-radius: 20px">
      @foreach ($slider as $key => $item)
        <div class="carousel-item @if (!$key) active @endif">
          <a href="{{ route('post.show', $item->post->alias) }}">
            <img
              src="{{ $item->post['img_' . app()->currentLocale()] ? asset($item->post['img_' . app()->currentLocale()]) : asset('img/default.png') }}"
              class="d-block w-100"
              alt="..."
            >
          </a>
        </div>
      @endforeach
    </div>

    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>

    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
@endif
