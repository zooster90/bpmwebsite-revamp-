<?php

namespace Database\Seeders;

use App\Models\JobOpening;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JobOpeningSeeder extends Seeder
{
    public function run(): void
    {
        // 遵循原网站的职位名称，但采用现代化的管理逻辑
        $positions = [
            ['title' => 'Site Managers', 'dept' => 'Construction', 'active' => true],
            ['title' => 'Engineers (Civil, Structural, Mechanical, Electrical)', 'dept' => 'Engineering', 'active' => true],
            ['title' => 'Quantity Surveyors', 'dept' => 'Quantity Surveying', 'active' => true],
            ['title' => 'Project Managers', 'dept' => 'Management', 'active' => false],
            ['title' => 'Construction Managers', 'dept' => 'Construction', 'active' => false],
            ['title' => 'QAQC & EHS Engineers', 'dept' => 'Quality & Safety', 'active' => false],
            ['title' => 'Planners/Schedulers', 'dept' => 'Project Management', 'active' => false],
            ['title' => 'Safety and Health Officers/Supervisors', 'dept' => 'HSE', 'active' => false],
            ['title' => 'Draughtman', 'dept' => 'Design & Drafting', 'active' => false],
            ['title' => 'Land Surveyors', 'dept' => 'Engineering', 'active' => false],
            ['title' => 'Site Coordinators/Supervisors', 'dept' => 'Construction', 'active' => false],
            ['title' => 'Finance and Administration Assistants', 'dept' => 'Admin & Finance', 'active' => false],
            ['title' => 'Purchasing Assistant', 'dept' => 'Procurement', 'active' => false],
        ];

        foreach ($positions as $index => $item) {
            JobOpening::updateOrCreate(
                ['title' => $item['title']], 
                [
                    'slug'         => Str::slug($item['title']),
                    'department'   => $item['dept'],
                    'location'     => 'Penang, PG',
                    'type'         => 'Full-Time',
                    'description'  => "We are seeking a dedicated {$item['title']} to join our team at Builtech. You will be responsible for overseeing technical aspects and ensuring project excellence.",
                    'requirements' => "<ul><li>Recognized Degree/Diploma in related field.</li><li>Minimum 3-5 years of experience in G7 construction projects.</li><li>Strong leadership and communication skills.</li></ul>",
                    'is_active'    => $item['active'], // 关键：控制前端是否显示
                    'sort_order'   => $index + 1,
                ]
            );
        }
    }
}