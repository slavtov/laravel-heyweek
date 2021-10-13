<?php

namespace App\Services;

use App\Models\Slider;
use App\Services\Interfaces\SliderServiceInterface;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class SliderService extends BaseService implements SliderServiceInterface
{
    public function __construct(Slider $model)
    {
        parent::__construct($model);
    }

    public function getAll(): Collection
    {
        $key = App::currentLocale();
        $ttl = Carbon::now()->addMinutes(30);

        return Cache::tags(self::TAG)
            ->remember($key, $ttl, function () {
                return $this->model
                    ->with('post')
                    ->latest()
                    ->limit(5)
                    ->get();
            });
    }

    public function getPaginationWithQuery(Request $request, int $qty = null): Paginator
    {
        return $this->model
            ->with('post')
            ->latest()
            ->paginate($qty, '*', 'slider')
            ->appends($request->query());
    }
}
