<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Service::truncate();
        $services = [
            ['title' => 'Project Management', 'slug' => 'project-management', 'icon_class' => 'fas fa-tasks', 'short_description' => 'Full oversight ensuring timeline adherence, strict cost control, and premium quality assurance from inception to handover. Our project teams use the latest technologies and proven methodologies.', 'sort_order' => 1],
            ['title' => 'Building & Civil', 'slug' => 'building-civil', 'icon_class' => 'fas fa-city', 'short_description' => 'High-rise residential developments, commercial complexes, and specialised civil engineering infrastructure. We deliver every project to the highest CONQUAS quality standards.', 'sort_order' => 2],
            ['title' => 'Industrial Building', 'slug' => 'industrial-building', 'icon_class' => 'fas fa-industry', 'short_description' => 'Specialised construction of factories and industrial plants, optimised for operational flow, regulatory compliance, and international safety standards.', 'sort_order' => 3],
            ['title' => 'Maintenance', 'slug' => 'maintenance', 'icon_class' => 'fas fa-tools', 'short_description' => 'Post-construction support and facility management to ensure long-term structural integrity, optimal performance, and sustained asset value for all completed developments.', 'sort_order' => 4],
            ['title' => 'Property Development', 'slug' => 'property-development', 'icon_class' => 'fas fa-building', 'short_description' => 'Transforming strategic land parcels into high-value commercial and residential real estate assets, from concept through to final handover.', 'sort_order' => 5],
            ['title' => 'Safety & Health Training', 'slug' => 'safety-health-training', 'icon_class' => 'fas fa-hard-hat', 'short_description' => 'Comprehensive EHS training programs to maintain our Zero Accident Tolerance Policy and ensure full ISO 45001:2018 and OHSAS compliance across all sites.', 'sort_order' => 6],
        ];
        foreach ($services as $s) { \App\Models\Service::create($s); }
    }
}
