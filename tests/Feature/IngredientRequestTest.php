<?php

namespace Tests\Unit;

use Domain\Menu\FormRequests\IngredientRequest;
use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class IngredientRequestTest extends TestCase
{
    public function test_it_requires_a_name()
    {
        $this->expectException(ValidationException::class);

        $data = [
            'price' => 1.5,
        ];

        $this->validateRequest($data);
    }

    public function test_it_requires_a_price()
    {
        $this->expectException(ValidationException::class);

        $data = [
            'name' => 'Tomato',
        ];

        $this->validateRequest($data);
    }

    public function test_the_price_must_be_numeric()
    {
        $this->expectException(ValidationException::class);

        $data = [
            'name' => 'Tomato',
            'price' => 'invalid',
        ];

        $this->validateRequest($data);
    }

    public function test_it_passes_when_data_is_valid()
    {
        $data = [
            'name' => 'Tomato',
            'price' => 1.5,
        ];

        $this->assertTrue($this->validateRequest($data));
    }

    private function validateRequest(array $data)
    {
        $request = new IngredientRequest();
        $validator = Validator::make($data, $request->rules());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return true;
    }
}
