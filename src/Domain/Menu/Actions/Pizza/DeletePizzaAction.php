<?php

namespace Domain\Menu\Actions\Pizza;

use Domain\Menu\Events\Pizza\PizzaUpdatedEvent;
use Domain\Menu\Models\Pizza;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeletePizzaAction
{
    public static function execute(Pizza $pizza): mixed
    {
        return DB::transaction(function () use ($pizza) {
            if ($pizza->image) {
                if (Storage::disk('public')->exists($pizza->image)) {
                    Storage::disk('public')->delete($pizza->image);
                }
            }

            $pizza->delete();
            event(new PizzaUpdatedEvent());
        });

    }
}
