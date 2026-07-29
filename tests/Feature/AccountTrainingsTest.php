<?php

namespace Tests\Feature;

use App\Models\Boutique;
use App\Models\Training;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountTrainingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_trainings_page(): void
    {
        $response = $this->get(route('account.trainings'));

        $response->assertRedirect(route('login'));
    }

    public function test_boutique_owner_can_access_trainings_page(): void
    {
        $boutique = Boutique::factory()->create([
            'status' => Boutique::STATUS_APPROVED,
        ]);

        $owner = User::factory()->create([
            'role' => 'boutique_owner',
            'boutique_id' => $boutique->id,
        ]);

        $response = $this->actingAs($owner)->get(route('account.trainings'));

        $response->assertOk();
        $response->assertSee('Trainings');
    }

    public function test_trainings_page_displays_published_trainings(): void
    {
        $boutique = Boutique::factory()->create([
            'status' => Boutique::STATUS_APPROVED,
        ]);

        $owner = User::factory()->create([
            'role' => 'boutique_owner',
            'boutique_id' => $boutique->id,
        ]);

        $published = Training::factory()->create([
            'title' => 'How to Create a Product',
            'is_published' => true,
        ]);

        $unpublished = Training::factory()->create([
            'title' => 'Draft Training',
            'is_published' => false,
        ]);

        $response = $this->actingAs($owner)->get(route('account.trainings'));

        $response->assertOk();
        $response->assertSee('How to Create a Product');
        $response->assertDontSee('Draft Training');
    }

    public function test_trainings_page_shows_empty_state_when_no_trainings(): void
    {
        $boutique = Boutique::factory()->create([
            'status' => Boutique::STATUS_APPROVED,
        ]);

        $owner = User::factory()->create([
            'role' => 'boutique_owner',
            'boutique_id' => $boutique->id,
        ]);

        $response = $this->actingAs($owner)->get(route('account.trainings'));

        $response->assertOk();
        $response->assertSee('No training videos available yet');
    }
}
