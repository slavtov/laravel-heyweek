User-agent: *
Disallow:

<? $languages = array_replace(Config::get('app.languages'), [0 => '']) ?>
@foreach ($languages as $lang)
  Sitemap: {{ url($lang . '/sitemap.xml') }}
@endforeach
