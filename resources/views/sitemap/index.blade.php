<? echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>{{ route('main') }}</loc>
    <changefreq>always</changefreq>
  </url>
  <url>
    <loc>{{ route('contact') }}</loc>
    <changefreq>monthly</changefreq>
  </url>
  @foreach ($posts as $post)
    <url>
      <loc>{{ route('post.show', $post->alias) }}</loc>
      <lastmod>{{ $post->updated_at->format('c') }}</lastmod>
    </url>
  @endforeach
</urlset>
