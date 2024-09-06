<?php

namespace Domain\Menu\FormRequests;

use Illuminate\Foundation\Http\FormRequest;

class IngredientRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "name" => "required|string|max:255",
            "price" => "required|numeric|between:0.01,9999.99",
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
