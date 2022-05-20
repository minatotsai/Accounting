<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'up_at' => now(),
            'memo' => '無',
            'content' => '雞',
            'amount' => 360,
            'company_id' => 1,
            'price' => 120,
            'quantity' => 3,
        ];
    }
}
