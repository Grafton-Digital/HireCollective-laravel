<?php

namespace Tests\Feature;

use App\Models\Boutique;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoritesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_favorites_page_displays_empty_state_when_no_products(): void
    {
        $response = $this->get(route('favorites.index'));

        $response->assertStatus(200);
        $response->assertSee('No saved items yet');
        $response->assertSee('Start saving your favorite pieces to view them here');
    }

    public function test_favorites_page_displays_products_with_boutique_name(): void
    {
        $boutique = Boutique::factory()->create([
            'is_active' => true,
            'name' => 'AMARA CASHMERE',
        ]);

        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'is_active' => true,
            'name' => 'Oversized Cashmere Sweater',
            'price_per_day' => 285,
        ]);

        $response = $this->get(route('favorites.index', ['ids' => [$product->id]]));

        $response->assertStatus(200);
        $response->assertSee('AMARA CASHMERE');
        $response->assertSee('Oversized Cashmere Sweater');
        $response->assertSee('€285');
    }

    public function test_favorites_page_only_shows_active_products(): void
    {
        $boutique = Boutique::factory()->create(['is_active' => true]);

        $activeProduct = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'is_active' => true,
            'name' => 'Active Product',
        ]);

        $inactiveProduct = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'is_active' => false,
            'name' => 'Inactive Product',
        ]);

        $response = $this->get(route('favorites.index', ['ids' => [$activeProduct->id, $inactiveProduct->id]]));

        $response->assertStatus(200);
        $response->assertSee('Active Product');
        $response->assertDontSee('Inactive Product');
    }

    public function test_favorites_page_displays_multiple_products(): void
    {
        $boutique1 = Boutique::factory()->create([
            'is_active' => true,
            'name' => 'AMARA CASHMERE',
        ]);

        $boutique2 = Boutique::factory()->create([
            'is_active' => true,
            'name' => 'NORDE KNIT STUDIO',
        ]);

        $product1 = Product::factory()->create([
            'boutique_id' => $boutique1->id,
            'is_active' => true,
            'name' => 'Oversized Cashmere Sweater',
        ]);

        $product2 = Product::factory()->create([
            'boutique_id' => $boutique2->id,
            'is_active' => true,
            'name' => 'Cable Knit Cardigan',
        ]);

        $response = $this->get(route('favorites.index', ['ids' => [$product1->id, $product2->id]]));

        $response->assertStatus(200);
        $response->assertSee('AMARA CASHMERE');
        $response->assertSee('Oversized Cashmere Sweater');
        $response->assertSee('NORDE KNIT STUDIO');
        $response->assertSee('Cable Knit Cardigan');
    }
}
