<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommunityPortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_are_accessible(): void
    {
        $this->get(route('home'))->assertOk();
        $this->get(route('members.index'))->assertOk();
        $this->get(route('notices.index'))->assertOk();
        $this->get(route('campaigns.index'))->assertOk();
        $this->get(route('membership.create'))->assertOk();
    }

    public function test_membership_form_can_be_submitted(): void
    {
        $response = $this->post(route('membership.store'), [
            'full_name' => 'John Citizen',
            'email' => 'john@example.com',
            'phone' => '555-0111',
            'address' => 'Main Road',
            'occupation' => 'Designer',
            'interests' => 'Helping with events',
            'motivation' => 'I want to contribute in social projects.',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('membership_applications', [
            'email' => 'john@example.com',
            'status' => 'pending',
        ]);
    }

    public function test_member_area_requires_authentication(): void
    {
        $this->get(route('member.dashboard'))->assertRedirect(route('login'));
    }

    public function test_registered_user_can_access_member_area(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('member.dashboard'))
            ->assertOk();
    }
}
