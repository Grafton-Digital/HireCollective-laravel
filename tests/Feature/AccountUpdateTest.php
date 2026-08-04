<?php

namespace Tests\Feature;

use App\Models\Boutique;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_boutique_owner_can_save_logo_background_color(): void
    {
        $boutique = Boutique::factory()->create([
            'status' => Boutique::STATUS_APPROVED,
            'logo_background_color' => null,
        ]);

        $user = User::factory()->create([
            'role' => 'boutique_owner',
            'boutique_id' => $boutique->id,
        ]);

        $response = $this->actingAs($user)->patch(route('account.update'), [
            'email' => $user->email,
            'boutique_name' => $boutique->name,
            'contact_email' => $boutique->contact_email,
            'county' => $boutique->county,
            'logo_background_color' => '#4466cc',
        ]);

        $response->assertRedirect(route('account.settings'));

        $this->assertDatabaseHas('boutiques', [
            'id' => $boutique->id,
            'logo_background_color' => '#4466cc',
        ]);
    }
}
