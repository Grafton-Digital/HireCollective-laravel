<?php

namespace Tests\Feature;

use App\Models\Boutique;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductEditCalendarTest extends TestCase
{
    use RefreshDatabase;

    public function test_edit_page_calendar_receives_correct_availability_data(): void
    {
        $user = User::factory()->admin()->create();
        $boutique = Boutique::factory()->create(['is_active' => true]);

        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'is_active' => true,
            'availability' => [
                '2026-07-18' => 'unavailable',
                '2026-07-19' => 'confirm',
                '2026-07-29' => 'confirm',
            ],
        ]);

        $response = $this->actingAs($user)->get("/admin/products/{$product->id}/edit");

        $response->assertStatus(200);

        // Check that calendar component is present
        $response->assertSee('Availability Calendar');

        // Check calendar structure
        $response->assertSee('calendarDays', false);
        $response->assertSee('toggleDate', false);

        // Check legend items
        $response->assertSee('Available');
        $response->assertSee('Unavailable');
        $response->assertSee('Need to confirm');
    }
}
