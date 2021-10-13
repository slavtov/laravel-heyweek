<?php

namespace App\Services\Interfaces;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;

interface SliderServiceInterface extends BaseServiceInterface
{
    public const TAG = 'slider';

    public function getPaginationWithQuery(Request $request, int $qty = null): Paginator;
}
