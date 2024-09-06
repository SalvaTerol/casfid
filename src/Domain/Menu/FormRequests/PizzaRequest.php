<?php

namespace Domain\Menu\FormRequests;

use Illuminate\Foundation\Http\FormRequest;

class PizzaRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "name" => "required|string|max:255",
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif|max:2048|dimensions:min_width=200,min_height=200',
            "ingredients" => "required|array",
            "ingredients.*" => "integer|exists:ingredients,id",
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
