<?php

namespace Domain\Menu\ViewModels\Pizza;

use Domain\Menu\DataTransferObject\IngredientData;
use Domain\Menu\DataTransferObject\PizzaData;
use Domain\Menu\Models\Ingredient;
use Domain\Menu\Models\Pizza;
use Domain\Shared\ViewModels\ViewModel;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class GetPizzasViewModel extends ViewModel
{
    private const PER_PAGE = 20;
    private const CACHE_KEY = 'pizzas_page_';


    public function __construct(private readonly int $currentPage)
    {
    }

    public function pizzas(): LengthAwarePaginator
    {
        $cacheKey = self::CACHE_KEY . $this->currentPage;

        $pizzasPaginator = Cache::rememberForever($cacheKey, function () {
            return Pizza::getPizzasWithIngredientsPaginated(self::PER_PAGE, $this->currentPage);
        });

        $pizzasDTOs = $pizzasPaginator->getCollection()->map(fn($ingredient) => PizzaData::fromModel($ingredient));

        return new LengthAwarePaginator(
            $pizzasDTOs,
            $pizzasPaginator->total(),
            self::PER_PAGE,
            $this->currentPage,
            [
                'path' => route('pizzas.index'),
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
