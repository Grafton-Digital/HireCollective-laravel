<?php

namespace Tests\Feature;

use App\Models\Boutique;
use App\Models\Colour;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductShowPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_show_page_displays_correctly(): void
    {
        $boutique = Boutique::factory()->create([
            'is_active' => true,
            'slug' => 'test-boutique',
            'name' => 'Test Boutique',
            'city' => 'Dublin',
            'county' => 'Co Dublin',
        ]);

        $colour = Colour::create([
            'name' => 'Blue',
            'slug' => 'blue',
            'hex' => '#0000FF',
        ]);

        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'is_active' => true,
            'slug' => 'test-dress',
            'name' => 'Test Dress',
            'designer' => 'Test Designer',
            'price_per_day' => 90,
            'description' => 'Beautiful test dress',
            'availability' => [
                '2026-07-18' => 'unavailable',
                '2026-07-19' => 'unavailable',
                '2026-07-29' => 'confirm',
            ],
        ]);

        $product->colours()->attach($colour);

        $response = $this->get("/boutiques/{$boutique->slug}/{$product->slug}");

        $response->assertStatus(200);
        $response->assertSee($product->name);
        $response->assertSee($product->designer);
        $response->assertSee('from');
        $response->assertSee('€90');
        $response->assertSee($boutique->name);
        $response->assertSee($boutique->city);
        $response->assertSee('Blue');
        $response->assertSee('AVAILABILITY');
        $response->assertSee('REQUEST TO BOOK');
    }
}
