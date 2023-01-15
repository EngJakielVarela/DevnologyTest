<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Products;

class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = $this->faker->randomElement(['0', '1', '2']);
        return [
            'id_product' => $this->faker->numberBetween(1, 10),
            'id_customer' => Customer::factory(),
            'quantity' => $this->faker->numberBetween(1, 10),
            'total' => $this->faker->numberBetween(100, 1000),
            'status' => $status,
        ];
    }
}
