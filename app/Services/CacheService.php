<?php

namespace App\Services;

use App\Services\Interfaces\CacheServiceInterface;
use App\Services\Interfaces\CategoryServiceInterface;
use App\Services\Interfaces\PostServiceInterface;
use App\Services\Interfaces\SliderServiceInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class CacheService implements CacheServiceInterface
{
    private const SEPARATOR = ':';

    private string $locale;

    public function __construct()
    {
        $this->locale = App::currentLocale();
    }

    public function values(): array
    {
        return [
            CategoryServiceInterface::TAG => 'index',
            SliderServiceInterface::TAG => $this->locale,
            PostServiceInterface::TAG => $this->locale,
        ];
    }

    public function value(string $key, $value, $ttl = 0)
    {
        if (!Cache::has($key))
            Cache::put($key, $value, $ttl);

        return Cache::get($key);
    }

    public function localName(...$arr): string
    {
        array_unshift($arr, App::currentLocale());
        return $this->generateKey($arr);
    }

    public function name(...$arr): string
    {
        return $this->generateKey($arr);
    }

    public function forget(string | array $tags, string $key): bool
    {
        if (!Cache::tags($tags)->has($key))
            return false;

        Cache::tags($tags)
            ->forget($key);

        return true;
    }

    public function flush(string | array $tags = null): void
    {
        if ($tags) {
            Cache::tags($tags)
                ->flush();
        } else {
            Cache::flush();
        }
    }

    public function delete($key, $val): void
    {
        Cache::forget($this->localName($key, $val));
    }

    private function generateKey($arr): string
    {
        return implode(self::SEPARATOR, $arr);
    }
}
