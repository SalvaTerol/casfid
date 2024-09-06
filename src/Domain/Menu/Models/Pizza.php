<?php

namespace Domain\Menu\Models;

use Domain\Menu\Builders\Pizza\PizzaBuilder;
use Domain\Menu\DataTransferObject\PizzaData;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Casts\PriceCast;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Number;

class Pizza extends BaseModel
{

    protected $fillable = ['name', 'image', 'total_price'];
    protected $dataClass = PizzaData::class;


    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class);
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => $attributes['image'] ? Storage::disk('public')->url($attributes['image']) : asset('images/pizza-default.webp'),
        );
    }

    protected function casts(): array
    {
        return [
            'total_price' => PriceCast::class,
        ];
    }

    public function newEloquentBuilder($query): PizzaBuilder
    {
        return new PizzaBuilder($query);
    }


}
