<?php 

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactPersonFactory extends Factory {
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
        ];
    }
}

?>