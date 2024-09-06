<?php

namespace Domain\Menu\Actions\Ingredient;

use Domain\Menu\ViewModels\Ingredient\GetIngredientViewModel;
use Illuminate\Support\Facades\Cache;

class ResetCacheIngredientAction
{
    public static function execute(): void
    {
        $page = 1;
        while (true) {
            $cacheKey = GetIngredientViewModel::getCacheKey() . $page;
            if (!Cache::has($cacheKey)) {
                break;
            }
            Cache::forget($cacheKey);
            $page++;
        }
        Cache::forget("ingredients_list");
    }
}
