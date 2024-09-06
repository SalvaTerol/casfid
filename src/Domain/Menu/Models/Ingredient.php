<?php

namespace Domain\Menu\Models;

use Domain\Menu\Builders\Ingredient\IngredientBuilder;
use Domain\Menu\DataTransferObject\IngredientData;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Casts\PriceCast;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends BaseModel
{
    protected $fillable = [
        'name',
        'price',
    ];

    protected $dataClass = IngredientData::class;

    public function pizzas(): BelongsToMany
    {
        return $this->belongsToMany(Pizza::class);
    }

    protected function casts()
    {
        return [
            'price' => PriceCast::class,
        ];
    }

    public function newEloquentBuilder($query): IngredientBuilder
    {
        return new IngredientBuilder($query);
    }
}
