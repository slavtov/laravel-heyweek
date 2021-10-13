<?php

namespace App\Services;

use App\Services\Interfaces\BaseServiceInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class BaseService implements BaseServiceInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model
            ->all();
    }

    public function getPagination(int $qty = null): Paginator
    {
        return $this->model
            ->paginate($qty);
    }
}
