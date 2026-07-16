<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\ProductResource;
use App\Models\Boutique;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_hidden_from_owner_without_boutique(): void
    {
        $owner = User::factory()->create(['role' => 'boutique_owner']);

        $this->actingAs($owner);

        $this->assertFalse(ProductResource::shouldRegisterNavigation());
    }

    public function test_products_hidden_from_owner_with_pending_boutique(): void
    {
        $owner = User::factory()->create(['role' => 'boutique_owner']);

        $boutique = Boutique::factory()->create([
            'status' => Boutique::STATUS_PENDING,
            'submitted_by' => $owner->id,
        ]);

        $owner->update(['boutique_id' => $boutique->id]);

        $this->actingAs($owner);

        $this->assertFalse(ProductResource::shouldRegisterNavigation());
    }

    public function test_products_hidden_from_owner_with_rejected_boutique(): void
    {
        $owner = User::factory()->create(['role' => 'boutique_owner']);

        $boutique = Boutique::factory()->create([
            'status' => Boutique::STATUS_REJECTED,
            'submitted_by' => $owner->id,
        ]);

        $owner->update(['boutique_id' => $boutique->id]);

        $this->actingAs($owner);

        $this->assertFalse(ProductResource::shouldRegisterNavigation());
    }

    public function test_products_visible_to_owner_with_approved_boutique(): void
    {
        $owner = User::factory()->create(['role' => 'boutique_owner']);

        $boutique = Boutique::factory()->create([
            'status' => Boutique::STATUS_APPROVED,
            'submitted_by' => $owner->id,
        ]);

        $owner->update(['boutique_id' => $boutique->id]);

        $this->actingAs($owner);

        $this->assertTrue(ProductResource::shouldRegisterNavigation());
    }

    public function test_products_visible_to_admin(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin);

        $this->assertTrue(ProductResource::shouldRegisterNavigation());
    }

    public function test_products_visible_to_customer(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);

        $this->actingAs($customer);

        $this->assertTrue(ProductResource::shouldRegisterNavigation());
    }
}
