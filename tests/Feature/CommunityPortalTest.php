<?php

namespace Tests\Feature;

use App\Models\Notice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CommunityPortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_dashboard_and_pages_are_accessible(): void
    {
        $this->get(route('home'))->assertOk();
        $this->get(route('dashboard'))->assertOk();
        $this->get(route('members.index'))->assertOk();
        $this->get(route('notices.index'))->assertOk();
        $this->get(route('campaigns.index'))->assertOk();
        $this->get(route('dashboard.slider-images'))->assertOk();
    }

    public function test_registered_user_can_apply_for_membership(): void
    {
        $user = User::factory()->create(['membership_status' => 'none']);

        $this->actingAs($user)
            ->post(route('membership.store'), [
                'phone' => '555-0111',
                'address' => 'Main Road',
                'occupation' => 'Designer',
                'interests' => 'Helping with events',
                'motivation' => 'I want to contribute in social projects.',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('membership_applications', [
            'user_id' => $user->id,
            'status' => 'pending',
        ]);
    }

    public function test_membership_apply_requires_login(): void
    {
        $this->get(route('membership.create'))->assertRedirect(route('login'));
        $this->post(route('membership.store'))->assertRedirect(route('login'));
    }

    public function test_admin_can_create_and_delete_notice(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'membership_status' => 'approved']);

        $this->actingAs($admin)
            ->post(route('admin.notices.store'), [
                'title' => 'Emergency Maintenance',
                'type' => 'notice',
                'summary' => 'System work in progress.',
                'body' => 'Dashboard systems will be under maintenance tonight.',
                'is_public' => 1,
            ])
            ->assertRedirect();

        $notice = Notice::query()->firstOrFail();

        $this->actingAs($admin)
            ->delete(route('admin.notices.destroy', $notice))
            ->assertRedirect();

        $this->assertDatabaseMissing('notices', ['id' => $notice->id]);
    }

    public function test_admin_can_promote_member_and_set_designation(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'membership_status' => 'approved']);
        $user = User::factory()->create(['membership_status' => 'pending']);

        $this->actingAs($admin)
            ->post(route('admin.members.membership.update', $user), [
                'membership_status' => 'approved',
                'designation' => 'Program Coordinator',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'membership_status' => 'approved',
        ]);

        $this->assertDatabaseHas('members', [
            'user_id' => $user->id,
            'role' => 'Program Coordinator',
        ]);
    }

    public function test_admin_slider_upload_is_visible_in_public_slider_api(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['is_admin' => true, 'membership_status' => 'approved']);

        $this->actingAs($admin)
            ->post(route('admin.media.slider.store'), [
                'title' => 'Health Camp Activity',
                'activity_note' => 'Public health activity completed.',
                'sort_order' => 0,
                'is_active' => 1,
                'image' => UploadedFile::fake()->image('health-camp.jpg'),
            ])
            ->assertRedirect();

        $this->getJson(route('dashboard.slider-images'))
            ->assertOk()
            ->assertJsonPath('images.0.title', 'Health Camp Activity');
    }
}
