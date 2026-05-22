<?php

namespace Database\Seeders;

use App\Models\Inquiry;
use Illuminate\Database\Seeder;

class InquirySeeder extends Seeder
{
    public function run(): void
    {
        $samples = [
            [
                'name'    => 'John Tan',
                'email'   => 'john.tan@example.com',
                'phone'   => '012-3456789',
                'subject' => 'Project Inquiry: High Rise Apartment',
                'message' => 'I would like to enquire about your high-rise construction services for a new project in Penang.',
                'status'  => 'New',
            ],
            [
                'name'    => 'Sarah Lee',
                'email'   => 'sarah.lee@company.com',
                'phone'   => '016-9876543',
                'subject' => 'Vendor Registration',
                'message' => 'We are interested in becoming a supplier for your upcoming projects. How do we register?',
                'status'  => 'In Progress',
            ],
            [
                'name'    => 'Ahmad Daud',
                'email'   => 'ahmad@construction.com.my',
                'phone'   => '019-1122334',
                'subject' => 'Safety Audit',
                'message' => 'Requesting a site safety audit for the Georgetown project site.',
                'status'  => 'Resolved',
            ],
            [
                'name'    => 'Michael Wong',
                'email'   => 'mw@developments.com',
                'phone'   => '011-55443322',
                'subject' => 'New Office Complex',
                'message' => 'Looking for a reliable contractor for a 12-storey office complex in Bukit Mertajam.',
                'status'  => 'New',
            ],
        ];

        foreach ($samples as $sample) {
            Inquiry::updateOrCreate(
                ['email' => $sample['email'], 'subject' => $sample['subject']],
                $sample
            );
        }
    }
}
