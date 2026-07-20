<?php

namespace Tests\Feature;

use App\Models\Boutique;
use App\Models\Category;
use App\Models\Colour;
use App\Models\Occasion;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_by_product_name(): void
    {
        $boutique = Boutique::factory()->create(['is_active' => true]);

        $product1 = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'name' => 'Blue Evening Dress',
            'is_active' => true,
        ]);

        $product2 = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'name' => 'Red Party Dress',
            'is_active' => true,
        ]);

        $response = $this->get(route('products.index', ['search' => 'Evening']));

        $response->assertStatus(200);
        $response->assertSee($product1->name);
        $response->assertDontSee($product2->name);
    }

    public function test_search_by_designer_name(): void
    {
        $boutique = Boutique::factory()->create(['is_active' => true]);

        $product1 = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'name' => 'Valentino Product',
            'designer' => 'Valentino',
            'is_active' => true,
        ]);

        $product2 = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'name' => 'Gucci Product',
            'designer' => 'Gucci',
            'is_active' => true,
        ]);

        $response = $this->get(route('products.index', ['search' => 'Valentino']));

        $response->assertStatus(200);
        $response->assertSee($product1->name);
        $response->assertDontSee($product2->name);
    }

    public function test_filter_by_category(): void
    {
        $boutique = Boutique::factory()->create(['is_active' => true]);
        $category = Category::create(['name' => 'Dresses', 'slug' => 'dresses']);

        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'is_active' => true,
        ]);

        $product->categories()->attach($category);

        $response = $this->get(route('products.index', ['category' => 'dresses']));

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    public function test_filter_by_colour(): void
    {
        $boutique = Boutique::factory()->create(['is_active' => true]);
        $colour = Colour::create(['name' => 'Blue', 'slug' => 'blue', 'hex_code' => '#0000FF']);

        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'is_active' => true,
        ]);

        $product->colours()->attach($colour);

        $response = $this->get(route('products.index', ['colour' => 'blue']));

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    public function test_filter_by_occasion(): void
    {
        $boutique = Boutique::factory()->create(['is_active' => true]);
        $occasion = Occasion::create(['name' => 'Wedding', 'slug' => 'wedding']);

        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'is_active' => true,
        ]);

        $product->occasions()->attach($occasion);

        $response = $this->get(route('products.index', ['occasion' => 'wedding']));

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    public function test_filter_by_designer(): void
    {
        $boutique = Boutique::factory()->create(['is_active' => true]);

        $product1 = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'designer' => 'Valentino',
            'is_active' => true,
        ]);

        $product2 = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'designer' => 'Gucci',
            'is_active' => true,
        ]);

        $response = $this->get(route('products.index', ['designer' => 'Valentino']));

        $response->assertStatus(200);
        $response->assertSee($product1->name);
        $response->assertDontSee($product2->name);
    }

    public function test_filter_by_county(): void
    {
        $boutique = Boutique::factory()->create(['is_active' => true]);

        $product1 = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'county' => 'Dublin',
            'is_active' => true,
        ]);

        $product2 = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'county' => 'Cork',
            'is_active' => true,
        ]);

        $response = $this->get(route('products.index', ['county' => 'Dublin']));

        $response->assertStatus(200);
        $response->assertSee($product1->name);
        $response->assertDontSee($product2->name);
    }

    public function test_filter_by_size(): void
    {
        $boutique = Boutique::factory()->create(['is_active' => true]);

        $product1 = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'is_active' => true,
        ]);

        ProductVariant::create([
            'product_id' => $product1->id,
            'size' => '10',
            'price' => 50,
            'is_available' => true,
        ]);

        $product2 = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'is_active' => true,
        ]);

        ProductVariant::create([
            'product_id' => $product2->id,
            'size' => '14',
            'price' => 50,
            'is_available' => true,
        ]);

        $response = $this->get(route('products.index', ['size' => '10']));

        $response->assertStatus(200);
        $response->assertSee($product1->name);
        $response->assertDontSee($product2->name);
    }

    public function test_filter_by_price_range_0_to_50(): void
    {
        $boutique = Boutique::factory()->create(['is_active' => true]);

        $product1 = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'price' => 45,
            'is_active' => true,
        ]);

        $product2 = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'price' => 75,
            'is_active' => true,
        ]);

        $response = $this->get(route('products.index', ['price' => '0-50']));

        $response->assertStatus(200);
        $response->assertSee($product1->name);
        $response->assertDontSee($product2->name);
    }

    public function test_filter_by_price_range_50_to_100(): void
    {
        $boutique = Boutique::factory()->create(['is_active' => true]);

        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'price' => 75,
            'is_active' => true,
        ]);

        $response = $this->get(route('products.index', ['price' => '50-100']));

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    public function test_filter_by_price_range_100_to_150(): void
    {
        $boutique = Boutique::factory()->create(['is_active' => true]);

        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'price' => 125,
            'is_active' => true,
        ]);

        $response = $this->get(route('products.index', ['price' => '100-150']));

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    public function test_filter_by_price_range_150_to_200(): void
    {
        $boutique = Boutique::factory()->create(['is_active' => true]);

        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'price' => 175,
            'is_active' => true,
        ]);

        $response = $this->get(route('products.index', ['price' => '150-200']));

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    public function test_filter_by_price_range_200_plus(): void
    {
        $boutique = Boutique::factory()->create(['is_active' => true]);

        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'price' => 250,
            'is_active' => true,
        ]);

        $response = $this->get(route('products.index', ['price' => '200+']));

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    public function test_filter_by_one_size(): void
    {
        $boutique = Boutique::factory()->create(['is_active' => true]);

        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'size' => 'One Size',
            'is_active' => true,
        ]);

        $response = $this->get(route('products.index', ['price' => 'one-size']));

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    public function test_multiple_filters_combined(): void
    {
        $boutique = Boutique::factory()->create(['is_active' => true]);
        $category = Category::create(['name' => 'Dresses', 'slug' => 'dresses']);
        $colour = Colour::create(['name' => 'Blue', 'slug' => 'blue', 'hex_code' => '#0000FF']);

        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'designer' => 'Valentino',
            'price' => 75,
            'county' => 'Dublin',
            'is_active' => true,
        ]);

        $product->categories()->attach($category);
        $product->colours()->attach($colour);

        $response = $this->get(route('products.index', [
            'category' => 'dresses',
            'colour' => 'blue',
            'designer' => 'Valentino',
            'price' => '50-100',
            'county' => 'Dublin',
        ]));

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    public function test_sort_by_price_ascending(): void
    {
        $boutique = Boutique::factory()->create(['is_active' => true]);

        $product1 = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'price' => 100,
            'is_active' => true,
        ]);

        $product2 = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'price' => 50,
            'is_active' => true,
        ]);

        $response = $this->get(route('products.index', ['sort' => 'price_asc']));

        $response->assertStatus(200);
        $this->assertTrue(
            strpos($response->getContent(), $product2->name) < strpos($response->getContent(), $product1->name)
        );
    }

    public function test_sort_by_price_descending(): void
    {
        $boutique = Boutique::factory()->create(['is_active' => true]);

        $product1 = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'price' => 50,
            'is_active' => true,
        ]);

        $product2 = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'price' => 100,
            'is_active' => true,
        ]);

        $response = $this->get(route('products.index', ['sort' => 'price_desc']));

        $response->assertStatus(200);
        $this->assertTrue(
            strpos($response->getContent(), $product2->name) < strpos($response->getContent(), $product1->name)
        );
    }
}
