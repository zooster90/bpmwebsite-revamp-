<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OurPeopleController extends Controller
{
    public function index()
    {
        $galleries = [
            'site-coordination' => [
                'title' => 'Site Coordination Meeting',
                'photos' => [
                    ['src' => 'images/site_coordination_meeting1.jpg', 'alt' => 'Site coordination meeting 1'],
                    ['src' => 'images/site_coordination_meeting2.jpg', 'alt' => 'Site coordination meeting 2'],
                    ['src' => 'images/site_coordination_meeting3.jpg', 'alt' => 'Site coordination meeting 3'],
                    ['src' => 'images/unnamed.jpg', 'alt' => 'Site coordination meeting 4'],
                ],
            ],
            'tool-box' => [
                'title' => 'Tool Box Meeting',
                'photos' => [
                    ['src' => 'images/TooBoxMeeting1.jpg', 'alt' => 'Tool box meeting 1'],
                    ['src' => 'images/TooBoxMeeting2.jpg', 'alt' => 'Tool box meeting 2'],
                    ['src' => 'images/TooBoxMeeting3.jpg', 'alt' => 'Tool box meeting 3'],
                    ['src' => 'images/DSCN8625.jpg', 'alt' => 'Tool box meeting 4'],
                ],
            ],
            'vector-control' => [
                'title' => 'Vector Control (Anti-Larvae & Fogging)',
                'photos' => [
                    ['src' => 'images/alt 2.jpg', 'alt' => 'Fogging 1'],
                    ['src' => 'images/alt 3.jpg', 'alt' => 'Fogging 2'],
                    ['src' => 'images/alt 4.jpg', 'alt' => 'Anti-larvae treatment 1'],
                    ['src' => 'images/alt2.jpg', 'alt' => 'Anti-larvae treatment 2'],
                ],
            ],
            'gotong-royong' => [
                'title' => 'Gotong Royong',
                'photos' => [
                    ['src' => 'images/gt1.jpg', 'alt' => 'Gotong Royong 1'],
                    ['src' => 'images/gt1(2).png', 'alt' => 'Gotong Royong 2'],
                    ['src' => 'images/gt3.jpg', 'alt' => 'Gotong Royong 3'],
                    ['src' => 'images/gt2.jpg', 'alt' => 'Gotong Royong 4'],
                ],
            ],
            'management-training' => [
                'title' => 'Management Training',
                'photos' => [
                    ['src' => 'images/IMG_0225a (1).jpg', 'alt' => 'Management training 1'],
                    ['src' => 'images/IMG_0232a (1).jpg', 'alt' => 'Management training 2'],
                    ['src' => 'images/PICT2616a.jpg', 'alt' => 'Management training 3'],
                    ['src' => 'images/PICT0307a.jpg', 'alt' => 'Management training 4'],
                ],
            ],
            'conquas-qlassic' => [
                'title' => 'CONQUAS & QLASSIC Training',
                'photos' => [
                    ['src' => 'images/z 004a.jpg', 'alt' => 'CONQUAS training 1'],
                    ['src' => 'images/z 153a.jpg', 'alt' => 'CONQUAS training 2'],
                    ['src' => 'images/q2.jpg', 'alt' => 'QLASSIC assessment 1'],
                    ['src' => 'images/q7.jpg', 'alt' => 'QLASSIC assessment 2'],
                ],
            ],
            'first-aid' => [
                'title' => 'First Aid Readiness',
                'photos' => [
                    ['src' => 'images/DSCN2674.jpg', 'alt' => 'First aid training 1'],
                    ['src' => 'images/5(2).jpg', 'alt' => 'First aid training 2'],
                    ['src' => 'images/16a(3).jpg', 'alt' => 'First aid training 3'],
                    ['src' => 'images/8a(4).jpg', 'alt' => 'First aid training 4'],
                ],
            ],
            'in-house-training' => [
                'title' => 'In-House Training',
                'photos' => [
                    ['src' => 'images/IMG_1144.jpg', 'alt' => 'In-house training 1'],
                    ['src' => 'images/t1(5).jpg', 'alt' => 'In-house training 2'],
                    ['src' => 'images/110320111059a.jpg', 'alt' => 'In-house training 3'],
                    ['src' => 'images/t8(1).jpg', 'alt' => 'In-house training 4'],
                ],
            ],
        ];

        return view('our-people', compact('galleries'));
    }
}