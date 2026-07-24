<?php

namespace Tests\Feature;

use App\Models\Boutique;
use App\Models\User;
use App\Notifications\NewBoutiqueApplicationNotification;
use Filament\Panel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BoutiqueApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_boutique_application_form_can_be_rendered(): void
    {
        $response = $this->get(route('boutique.application.create'));

        $response->assertStatus(200);
        $response->assertSee('Create Your Boutique');
    }

    public function test_boutique_can_be_created_via_application(): void
    {
        Storage::fake('public');
        Notification::fake();

        $response = $this->post(route('boutique.application.store'), [
            'name' => 'Test Boutique',
            'banner_image' => UploadedFile::fake()->image('banner.jpg'),
            'bio' => 'This is a test boutique bio',
            'region' => 'Dublin',
            'contact_email' => 'boutique@example.com',
            'phone' => '+353 123 456 789',
            'instagram' => '@testboutique',
            'email' => 'owner@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('boutique.application.confirmation'));

        $boutique = Boutique::latest()->first();

        $this->assertDatabaseHas('boutiques', [
            'name' => 'Test Boutique',
            'status' => Boutique::STATUS_PENDING,
            'pending_email' => 'owner@example.com',
        ]);

        Notification::assertSentOnDemand(
            NewBoutiqueApplicationNotification::class,
        );
    }

    public function test_validation_errors_are_shown_for_invalid_application(): void
    {
        $response = $this->post(route('boutique.application.store'), [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'password', 'banner_image', 'bio', 'region', 'contact_email']);
    }

    public function test_user_is_created_when_boutique_is_approved(): void
    {
        $boutique = Boutique::factory()->create([
            'status' => Boutique::STATUS_PENDING,
            'pending_email' => 'owner@example.com',
            'pending_password' => 'password123',
        ]);

        $this->assertDatabaseMissing('users', [
            'email' => 'owner@example.com',
        ]);

        $boutique->approve();

        $this->assertDatabaseHas('users', [
            'email' => 'owner@example.com',
            'role' => 'boutique_owner',
            'boutique_id' => $boutique->id,
        ]);

        $this->assertNull($boutique->fresh()->pending_email);
        $this->assertNull($boutique->fresh()->pending_password);
    }

    public function test_boutique_owner_cannot_access_filament_panel(): void
    {
        $boutique = Boutique::factory()->create();
        $user = User::factory()->create([
            'role' => 'boutique_owner',
            'boutique_id' => $boutique->id,
        ]);

        $this->assertFalse($user->canAccessPanel(app(Panel::class)));
    }

    public function test_admin_can_access_filament_panel(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->assertTrue($admin->canAccessPanel(app(Panel::class)));
    }
}
