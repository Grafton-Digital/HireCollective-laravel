<?php

namespace Tests\Feature;

use App\Models\Boutique;
use App\Models\Colour;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductAvailabilityDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected Colour $colour;

    protected function setUp(): void
    {
        parent::setUp();

        $this->colour = Colour::create(['name' => 'Black', 'slug' => 'black', 'hex_code' => '#000000']);
    }

    public function test_boutique_owner_can_save_availability_via_dashboard(): void
    {
        $boutique = Boutique::factory()->create(['is_active' => true, 'status' => 'approved']);
        $boutiqueOwner = User::factory()->create([
            'role' => 'boutique_owner',
            'boutique_id' => $boutique->id,
        ]);

        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'is_active' => true,
            'price_per_day' => 50.00,
            'availability' => [],
        ]);

        $product->colours()->attach($this->colour->id);

        $this->actingAs($boutiqueOwner);

        $availabilityData = [
            '2026-07-20' => 'unavailable',
            '2026-07-21' => 'confirm',
            '2026-07-25' => 'unavailable',
        ];

        $response = $this->put("/account/products/{$product->id}", [
            'name' => $product->name,
            'price_per_day' => $product->price_per_day,
            'colours' => [$this->colour->id],
            'availability' => json_encode($availabilityData),
        ]);

        $response->assertRedirect();

        $product->refresh();

        $this->assertIsArray($product->availability, 'Availability should be stored as array');
        $this->assertEquals($availabilityData, $product->availability, 'Availability data should match');
    }

    public function test_admin_can_see_boutique_owner_availability_in_filament(): void
    {
        $admin = User::factory()->admin()->create();
        $boutique = Boutique::factory()->create(['is_active' => true]);

        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'is_active' => true,
            'price_per_day' => 50.00,
            'availability' => [
                '2026-07-20' => 'unavailable',
                '2026-07-21' => 'confirm',
            ],
        ]);

        $product->colours()->attach($this->colour->id);

        $this->actingAs($admin);

        $response = $this->get("/admin/products/{$product->id}/edit");

        $response->assertStatus(200);
        $response->assertSee('Availability Calendar');

        // Check that availability data is in the response
        $this->assertIsArray($product->availability);
        $this->assertEquals([
            '2026-07-20' => 'unavailable',
            '2026-07-21' => 'confirm',
        ], $product->availability);
    }
}
