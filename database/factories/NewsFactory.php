<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NewsFactory extends Factory
{
    public function definition(): array
    {
        $headlines = [
            'Builtech Awarded Contract for New Metropolitan Transit Hub',
            'Breaking Ground on the Skyline Bridge Expansion',
            'Builtech Named Among Top 10 Engineering Firms of the Year',
            'Sustainability Report: Our Journey to Net-Zero by 2030',
            'New Partnership Announced with Global Infrastructure Leaders',
            'Apex Tower Wins International Design Excellence Award',
            'Builtech Expands Operations to Southeast Asia',
            'New Safety Standards Adopted Across All Active Projects',
        ];

        $categories = ['Corporate', 'Industry', 'Awards', 'Sustainability', 'Projects'];

        $title = $this->faker->unique()->randomElement($headlines);

        return [
            'title'          => $title,
            'slug'           => Str::slug($title),
            'content'        => $this->faker->paragraphs(4, true),
            'published_date' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'category'       => $this->faker->randomElement($categories),
        ];
    }
}
