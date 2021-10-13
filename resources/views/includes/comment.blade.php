@foreach ($comments as $comment)
  <div class="media mt-4">
    <i
      class="fas fa-user text-secondary rounded-circle p-3 mr-2"
      style="background: darkgray;"
    ></i>

    <div class="media-body">
      <div class="d-flex align-items-end">
        <h5 class="my-0 mr-2">
          {{ $comment->user ? $comment->user->name : __('home.guest') }}
        </h5>

        <span class="small text-muted">
          <i class="far fa-clock"></i>
          {{ $comment->created_at->diffForHumans() }}
        </span>
      </div>

      {{ $comment->body }}
    </div>
  </div>
@endforeach
