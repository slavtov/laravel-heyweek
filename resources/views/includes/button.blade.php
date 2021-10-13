<a
  href="{{ route($route) }}"
  class="list-group-item list-group-item-action border-0 rounded {{ $active === $name ? 'active' : null }}"
>
  {{ __($name) }}
</a>
