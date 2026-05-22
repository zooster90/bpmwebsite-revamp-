<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        $names = [
            'Apex Tower', 'Meridian Plaza', 'Harborview Complex', 'Skyline Bridge',
            'Crescendo Center', 'Ironwood Residences', 'The Summit', 'Vertex Hub',
            'Pinnacle Court', 'Eclipse Tower', 'Solaris Park', 'Nova Commercial Center',
        ];

        $locations = [
            'New York, NY', 'Los Angeles, CA', 'Chicago, IL', 'Houston, TX',
            'Miami, FL', 'Seattle, WA', 'Boston, MA', 'Denver, CO',
        ];

        $categories = ['Commercial', 'Residential', 'Infrastructure', 'Mixed-Use', 'Industrial'];
        $statuses   = ['Completed', 'Ongoing', 'Planned'];

        $name = $this->faker->unique()->randomElement($names);

        return [
            'name'         => $name,
            'slug'         => Str::slug($name),
            'description'  => $this->faker->paragraphs(2, true),
            'client'       => $this->faker->company(),
            'location'     => $this->faker->randomElement($locations),
            'category'     => $this->faker->randomElement($categories),
            'status'       => $this->faker->randomElement($statuses),
            'year'         => $this->faker->numberBetween(2018, 2026),
            'is_flagship'  => $this->faker->boolean(30),
            'is_published' => true,
            'sort_order'   => $this->faker->numberBetween(1, 50),
        ];
    }
}
