<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'destiny' => fake()->unique()->name(),
            'going_date' => $this->validationdate(fake()->unique()->date('Y-m-d')),
            'back_date' => $this->validationdate(fake()->unique()->date('Y-m-d')),
            'status' => OrderStatus::r,
            'id_user' => '1'
        ];
    }
    public function validationdate($data): string
    {
        $nameDay = date("D", strtotime($data));
        if ($nameDay == "Sat" || $nameDay == "Sun") {
            $newdate = fake()->unique()->date('Y-m-d');
            return $this->validationdate($newdate);
        }
        return $data;
    }
}
