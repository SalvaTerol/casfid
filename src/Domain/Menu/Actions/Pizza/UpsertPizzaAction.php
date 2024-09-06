<?php

namespace Domain\Menu\Actions\Pizza;

use Domain\Menu\DataTransferObject\PizzaData;
use Domain\Menu\Events\Pizza\PizzaCreatedEvent;
use Domain\Menu\Events\Pizza\PizzaUpdatedEvent;
use Domain\Menu\Models\Ingredient;
use Domain\Menu\Models\Pizza;
use Illuminate\Support\Facades\DB;

class UpsertPizzaAction
{
    public static function execute(PizzaData $data, ?Pizza $pizza = null): Pizza
    {
        return DB::transaction(function () use ($data, $pizza) {

            $imagePath = UploadImageAction::execute($data->image, $pizza?->image);
            $dataArray = array_merge($data->toArray(), ['image' => $imagePath]);

            $dataArray['total_price'] = CalculateTotalPriceAction::execute($data, $pizza);

            $pizza = Pizza::updateOrCreate([
                'id' => $data->id,
            ], $dataArray);
            $pizza->ingredients()->sync($data->ingredients->pluck('id'));


            if ($pizza->wasRecentlyCreated){
                event(new PizzaCreatedEvent($pizza));
            }

            if ($pizza->wasChanged()){
                event(new PizzaUpdatedEvent());
            }

            return $pizza->load('ingredients');
        });

    }
}
