<?php

namespace Tests\Feature;

use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Models\Boutique;
use App\Models\Colour;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ProductAvailabilitySaveTest extends TestCase
{
    use RefreshDatabase;

    protected Colour $colour;

    protected function setUp(): void
    {
        parent::setUp();

        $this->colour = Colour::create(['name' => 'Black', 'slug' => 'black', 'hex_code' => '#000000']);
    }

    public function test_availability_persists_when_boutique_owner_saves_product(): void
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
            'availability' => [
                '2026-07-18' => 'unavailable',
                '2026-07-19' => 'confirm',
                '2026-07-29' => 'confirm',
            ],
        ]);

        $product->colours()->attach($this->colour->id);

        $this->actingAs($boutiqueOwner);

        Livewire::test(EditProduct::class, ['record' => $product->id])
            ->assertFormSet([
                'availability' => [
                    '2026-07-18' => 'unavailable',
                    '2026-07-19' => 'confirm',
                    '2026-07-29' => 'confirm',
                ],
            ])
            ->fillForm([
                'name' => 'Updated Product Name',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $product->refresh();

        // Availability should remain unchanged when not explicitly modified
        $this->assertEquals([
            '2026-07-18' => 'unavailable',
            '2026-07-19' => 'confirm',
            '2026-07-29' => 'confirm',
        ], $product->availability, 'Availability data was lost during save');
    }

    public function test_availability_can_be_updated(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $boutique = Boutique::factory()->create(['is_active' => true]);

        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'is_active' => true,
            'price_per_day' => 50.00,
            'availability' => [
                '2026-07-18' => 'unavailable',
            ],
        ]);

        $product->colours()->attach($this->colour->id);

        $this->actingAs($admin);

        Livewire::test(EditProduct::class, ['record' => $product->id])
            ->fillForm([
                'availability' => [
                    '2026-07-18' => 'unavailable',
                    '2026-07-20' => 'confirm',
                    '2026-07-25' => 'unavailable',
                ],
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $product->refresh();

        // Availability should be updated with new values
        $this->assertEquals([
            '2026-07-18' => 'unavailable',
            '2026-07-20' => 'confirm',
            '2026-07-25' => 'unavailable',
        ], $product->availability, 'Availability data was not updated correctly');
    }

    public function test_boutique_owner_can_see_and_edit_calendar_in_dashboard(): void
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
        ]);

        $product->colours()->attach($this->colour->id);

        $this->actingAs($boutiqueOwner);

        $response = $this->get("/account/products/{$product->id}/edit");

        $response->assertStatus(200);
        $response->assertSee('Availability Calendar');
        $response->assertSee('Click on dates to toggle availability');
    }

    public function test_admin_can_see_calendar(): void
    {
        $admin = User::factory()->admin()->create();
        $boutique = Boutique::factory()->create(['is_active' => true]);

        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'is_active' => true,
            'price_per_day' => 50.00,
        ]);

        $product->colours()->attach($this->colour->id);

        $this->actingAs($admin);

        $response = $this->get("/admin/products/{$product->id}/edit");

        $response->assertStatus(200);
        $response->assertSee('Availability Calendar');
    }
}
