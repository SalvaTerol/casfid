<?php

namespace Domain\Menu\Actions\Pizza;

use Domain\Menu\ViewModels\Pizza\GetPizzasViewModel;
use Illuminate\Support\Facades\Cache;

class ResetCachePizzaAction
{
    public static function execute(): void
    {
        $page = 1;
        while (true) {
            $cacheKey = GetPizzasViewModel::getCacheKey().$page;
            if (! Cache::has($cacheKey)) {
                break;
            }
            Cache::forget($cacheKey);
            $page++;
        }
    }
}
