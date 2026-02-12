<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Member;
use App\Models\Notice;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $memberUser = User::factory()->create([
            'name' => 'Portal Member',
            'email' => 'member@example.com',
            'password' => 'password',
        ]);

        Member::query()->create([
            'user_id' => $memberUser->id,
            'full_name' => 'Portal Member',
            'slug' => 'portal-member',
            'role' => 'Coordinator',
            'email' => 'member@example.com',
            'phone' => '+1 555-0150',
            'location' => 'Central Block',
            'occupation' => 'Teacher',
            'bio' => 'Coordinates youth learning and volunteer efforts.',
            'joined_on' => now()->subYears(2),
            'is_public' => true,
            'is_active' => true,
        ]);

        $extraMembers = [
            ['Ariha Rahman', 'Event Volunteer', 'North Avenue'],
            ['Samir Hasan', 'Health Team', 'Lake Road'],
            ['Nazia Karim', 'Finance Support', 'Sunset Street'],
        ];

        foreach ($extraMembers as [$name, $role, $location]) {
            Member::query()->create([
                'full_name' => $name,
                'slug' => Str::slug($name),
                'role' => $role,
                'location' => $location,
                'occupation' => 'Community Volunteer',
                'bio' => "{$name} supports local community activities.",
                'joined_on' => now()->subMonths(rand(4, 24)),
                'is_public' => true,
                'is_active' => true,
            ]);
        }

        $noticeItems = [
            [
                'title' => 'Monthly Community Meeting',
                'type' => 'notice',
                'summary' => 'Monthly progress discussion in the center hall.',
                'body' => 'All residents are invited this Friday at 7:00 PM for planning and open feedback.',
                'is_public' => true,
            ],
            [
                'title' => 'Congratulations to Scholarship Winners',
                'type' => 'celebration',
                'summary' => 'Celebrating students selected for higher studies.',
                'body' => 'Join us on Sunday evening to celebrate the academic achievements of our students.',
                'is_public' => true,
            ],
            [
                'title' => 'Member Budget Review Session',
                'type' => 'event',
                'summary' => 'Quarterly finance discussion for registered members only.',
                'body' => 'Detailed budget and next quarter plans will be presented in this session.',
                'is_public' => false,
            ],
        ];

        foreach ($noticeItems as $notice) {
            Notice::query()->create([
                ...$notice,
                'slug' => Str::slug($notice['title']),
                'created_by' => $memberUser->id,
                'published_at' => now()->subDays(rand(1, 15)),
            ]);
        }

        Campaign::query()->create([
            'title' => 'Winter Clothing Drive',
            'slug' => 'winter-clothing-drive',
            'summary' => 'Collecting warm clothes for low-income families.',
            'description' => 'Community wide campaign to collect and distribute winter essentials.',
            'status' => 'active',
            'start_date' => now()->subDays(12),
            'end_date' => now()->addDays(20),
            'target_amount' => 5000,
            'current_amount' => 2750,
            'is_public' => true,
            'contact_email' => 'campaigns@example.com',
        ]);

        Campaign::query()->create([
            'title' => 'Member Skill Workshop',
            'slug' => 'member-skill-workshop',
            'summary' => 'Private training sessions for registered members.',
            'description' => 'Weekly workshops on leadership, budgeting, and digital tools.',
            'status' => 'planned',
            'start_date' => now()->addDays(10),
            'end_date' => now()->addDays(45),
            'target_amount' => 2000,
            'current_amount' => 300,
            'is_public' => false,
            'contact_email' => 'members@example.com',
        ]);
    }
}
