<?php

namespace Tests\Feature;

use App\Models\Boutique;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoritesPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_favorites_page_loads_without_ids(): void
    {
        $response = $this->get(route('favorites.index'));

        $response->assertStatus(200);
        $response->assertSee('Saved Items');
        $response->assertSee('No saved items yet');
    }

    public function test_favorites_page_loads_products_with_ids(): void
    {
        $boutique = Boutique::factory()->create(['is_active' => true]);

        $product1 = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'name' => 'Test Product 1',
            'is_active' => true,
        ]);

        $product2 = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'name' => 'Test Product 2',
            'is_active' => true,
        ]);

        $response = $this->get(route('favorites.index', ['ids' => [$product1->id, $product2->id]]));

        $response->assertStatus(200);
        $response->assertSee('Test Product 1');
        $response->assertSee('Test Product 2');
    }

    public function test_favorites_page_shows_empty_when_no_valid_products(): void
    {
        $response = $this->get(route('favorites.index', ['ids' => [999, 888]]));

        $response->assertStatus(200);
        $response->assertSee('No saved items yet');
    }
}
