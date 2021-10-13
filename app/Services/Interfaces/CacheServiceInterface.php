<?php

namespace App\Services\Interfaces;

interface CacheServiceInterface
{
    public const HIT = 'hit';
    public const RANDOM = 'random';

    public function values(): array;
    public function value(string $key, $value, $ttl = 0);
    public function localName(...$arr): string;
    public function name(...$arr): string;
    public function forget(string | array $tags, string $key): bool;
    public function flush(string | array $tags = null): void;
    public function delete($key, $val): void;
}
