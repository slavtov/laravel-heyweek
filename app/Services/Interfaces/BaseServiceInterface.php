<?php

namespace App\Services\Interfaces;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Enumerable;

interface BaseServiceInterface
{
    public function getAll(): Enumerable;
    public function getPagination(int $qty = null): Paginator;
}
