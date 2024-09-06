<?php

namespace Domain\Menu\DataTransferObject;

use Domain\Menu\FormRequests\IngredientRequest;
use Domain\Menu\FormRequests\PizzaRequest;
use Domain\Menu\Models\Ingredient;
use Domain\Menu\Models\Pizza;
use Domain\Shared\ValueObjects\Price;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class PizzaData
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly string|UploadedFile|null $image,
        public readonly ?Price $total_price,
        public readonly Collection $ingredients,
        public readonly ?string $image_url = null
    ) {}

    public static function fromRequest(
        PizzaRequest $request,
        ?int $id = null
    ): self {
        $ingredients = Ingredient::whereIn('id', $request->get('ingredients'))->get();
        return new self(
            id: $id,
            name: $request->get('name'),
            image: Arr::get($request, 'image'),
            total_price: null,
            ingredients: IngredientData::collection($ingredients)
        );
    }

    public static function fromModel(Pizza $pizza): self
    {
        return new self(
            id: $pizza->id,
            name: $pizza->name,
            image: $pizza->image,
            total_price: $pizza->total_price,
            ingredients: IngredientData::collection($pizza->ingredients),
            image_url: $pizza->image_url
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: Arr::get($data, 'id'),
            name: Arr::get($data, 'name'),
            image: Arr::get($data, 'image'),
            total_price: Arr::get($data, 'total_price'),
            ingredients: IngredientData::collection(
                collect(Arr::get($data, 'ingredients', []))->map(function ($ingredient) {
                    return $ingredient instanceof Ingredient
                        ? $ingredient
                        : Ingredient::find($ingredient); // Convertimos los IDs en instancias de Ingredient
                })
            )
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'total_price' => $this->total_price,
            'ingredients' => $this->ingredients->pluck('id')->toArray()
        ];
    }
}
