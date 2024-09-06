<?php

namespace Domain\Menu\ViewModels\Ingredient;

use Domain\Menu\DataTransferObject\IngredientData;
use Domain\Menu\Models\Ingredient;
use Domain\Shared\ViewModels\ViewModel;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class GetIngredientViewModel extends ViewModel
{
    private const PER_PAGE = 10;

    private const CACHE_KEY = 'ingredient_page_';

    public function __construct(private readonly int $currentPage) {}

    public function ingredients(): LengthAwarePaginator
    {
        $cacheKey = self::CACHE_KEY.$this->currentPage;

        $ingredientsPaginator = Cache::rememberForever($cacheKey, function () {
            return Ingredient::getIngredientsPaginated(self::PER_PAGE, $this->currentPage);
        });

        $ingredientsDTOs = $ingredientsPaginator->getCollection()->map(fn ($ingredient) => IngredientData::fromModel($ingredient));

        return new LengthAwarePaginator(
            $ingredientsDTOs,
            $ingredientsPaginator->total(),
            self::PER_PAGE,
            $this->currentPage,
            [
                'path' => route('ingredients.index'),
                'query' => request()->query(),
            ]
        );
    }

    public static function getPerPage(): int
    {
        return self::PER_PAGE;
    }

    public static function getCacheKey(): string
    {
        return self::CACHE_KEY;
    }
}
