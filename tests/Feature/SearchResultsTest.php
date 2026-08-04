<?php

namespace Tests\Feature;

use App\Models\Boutique;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchResultsTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_page_loads_without_query(): void
    {
        $response = $this->get('/search');

        $response->assertStatus(200);
        $response->assertSee('Enter a search term to find products and boutiques.');
    }

    public function test_search_finds_products_by_name(): void
    {
        $boutique = Boutique::factory()->approved()->create();
        Product::factory()->approved()->create([
            'boutique_id' => $boutique->id,
            'name' => 'Cashmere Sweater',
        ]);

        $response = $this->get('/search?q=cashmere');

        $response->assertStatus(200);
        $response->assertSee('Cashmere Sweater');
        $response->assertSee('1 result');
    }

    public function test_search_finds_products_by_designer(): void
    {
        $boutique = Boutique::factory()->approved()->create();
        Product::factory()->approved()->create([
            'boutique_id' => $boutique->id,
            'name' => 'Evening Dress',
            'designer' => 'Valentino',
        ]);

        $response = $this->get('/search?q=valentino');

        $response->assertStatus(200);
        $response->assertSee('Evening Dress');
    }

    public function test_search_finds_boutiques_by_name(): void
    {
        Boutique::factory()->approved()->create(['name' => 'Amara Cashmere']);

        $response = $this->get('/search?q=amara');

        $response->assertStatus(200);
        $response->assertSee('Amara Cashmere');
    }

    public function test_search_shows_both_products_and_boutiques(): void
    {
        $boutique = Boutique::factory()->approved()->create(['name' => 'Silk Studio']);
        Product::factory()->approved()->create([
            'boutique_id' => $boutique->id,
            'name' => 'Silk Blouse',
        ]);

        $response = $this->get('/search?q=silk');

        $response->assertStatus(200);
        $response->assertSee('2 results');
    }

    public function test_search_does_not_show_inactive_products(): void
    {
        $boutique = Boutique::factory()->approved()->create();
        Product::factory()->create([
            'boutique_id' => $boutique->id,
            'name' => 'Hidden Item',
            'is_active' => false,
        ]);

        $response = $this->get('/search?q=hidden');

        $response->assertStatus(200);
        $response->assertDontSee('Hidden Item');
    }

    public function test_search_does_not_show_unapproved_boutiques(): void
    {
        Boutique::factory()->pending()->create(['name' => 'Pending Boutique']);

        $response = $this->get('/search?q=pending');

        $response->assertStatus(200);
        $response->assertDontSee('Pending Boutique');
    }

    public function test_search_shows_no_results_message(): void
    {
        $response = $this->get('/search?q=xyznonexistent');

        $response->assertStatus(200);
        $response->assertSee('No results found for');
    }

    public function test_search_ignores_query_shorter_than_2_characters(): void
    {
        $boutique = Boutique::factory()->approved()->create();
        Product::factory()->approved()->create([
            'boutique_id' => $boutique->id,
            'name' => 'A Nice Dress',
        ]);

        $response = $this->get('/search?q=a');

        $response->assertStatus(200);
        $response->assertDontSee('A Nice Dress');
    }

    public function test_search_type_filter_shows_only_products(): void
    {
        $boutique = Boutique::factory()->approved()->create(['name' => 'Silk Studio']);
        Product::factory()->approved()->create([
            'boutique_id' => $boutique->id,
            'name' => 'Silk Blouse',
        ]);

        $response = $this->get('/search?q=silk&type=products');

        $response->assertStatus(200);
        $response->assertSee('Silk Blouse');
        $response->assertDontSee('Silk Studio');
    }

    public function test_search_type_filter_shows_only_boutiques(): void
    {
        $boutique = Boutique::factory()->approved()->create(['name' => 'Silk Studio']);
        Product::factory()->approved()->create([
            'boutique_id' => $boutique->id,
            'name' => 'Silk Blouse',
        ]);

        $response = $this->get('/search?q=silk&type=boutiques');

        $response->assertStatus(200);
        $response->assertSee('Silk Studio');
        $response->assertDontSee('Silk Blouse');
    }

    public function test_search_paginates_results(): void
    {
        $boutique = Boutique::factory()->approved()->create();
        Product::factory()->approved()->count(3)->create([
            'boutique_id' => $boutique->id,
            'name' => 'Test Hat',
        ]);

        $response = $this->get('/search?q=hat&page=2');

        $response->assertStatus(200);
    }
}
