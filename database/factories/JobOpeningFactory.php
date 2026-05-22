<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class JobOpeningFactory extends Factory
{
    public function definition(): array
    {
        // 匹配旧版网站 Careers 页面的 13 个具体职位与它们对应的 Available/Not Available 状态
        $job = $this->faker->unique()->randomElement([
            ['title' => 'Project Managers', 'is_active' => false],
            ['title' => 'Construction Managers', 'is_active' => false],
            ['title' => 'Site Managers', 'is_active' => true],
            ['title' => 'Engineers (Civil, Structural, Mechanical, Electrical)', 'is_active' => true],
            ['title' => 'QAQC & EHS Engineers', 'is_active' => false],
            ['title' => 'Planners/Schedulers', 'is_active' => false],
            ['title' => 'Quantity Surveyors', 'is_active' => true],
            ['title' => 'Safety and Health Officers/Supervisors', 'is_active' => false],
            ['title' => 'Draughtman', 'is_active' => false],
            ['title' => 'Land Surveyors', 'is_active' => false],
            ['title' => 'Site Coordinators/Supervisors', 'is_active' => false],
            ['title' => 'Finance and Administration Assistants', 'is_active' => false],
            ['title' => 'Purchasing Assistant', 'is_active' => false],
        ]);

        $departments = ['Construction', 'Engineering', 'Management', 'Quality & Safety', 'Admin & Finance'];
        $types       = ['Full-Time', 'Contract'];
        $locations   = ['Penang, PG'];

        return [
            'title'       => $job['title'],
            'slug'        => Str::slug($job['title']),
            'department'  => $this->faker->randomElement($departments),
            'location'    => $this->faker->randomElement($locations),
            'type'        => $this->faker->randomElement($types),
            'description' => $this->faker->paragraphs(3, true),
            'is_active'   => $job['is_active'],
        ];
    }
}