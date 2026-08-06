<?php

namespace Tests\Feature;

use App\Models\Boutique;
use App\Models\Enquiry;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnquiryConfirmationTest extends TestCase
{
    use RefreshDatabase;

    public function test_confirming_booking_adds_dates_to_product_availability(): void
    {
        $boutique = Boutique::factory()->create();
        $user = User::factory()->create(['boutique_id' => $boutique->id, 'role' => 'boutique_owner']);
        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'availability' => [],
        ]);

        $enquiry = new Enquiry([
            'product_id' => $product->id,
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'desired_dates' => '2026-09-10 to 2026-09-14',
            'message' => 'Test booking',
        ]);
        $enquiry->boutique_id = $boutique->id;
        $enquiry->status = 'new';
        $enquiry->save();

        $response = $this->actingAs($user)->patch(route('account.enquiries.update', $enquiry), [
            'status' => 'confirmed',
        ]);

        $response->assertRedirect(route('account.enquiries.show', $enquiry));
        $response->assertSessionHas('success');

        $product->refresh();
        $this->assertEquals('unavailable', $product->availability['2026-09-10']);
        $this->assertEquals('unavailable', $product->availability['2026-09-11']);
        $this->assertEquals('unavailable', $product->availability['2026-09-12']);
        $this->assertEquals('unavailable', $product->availability['2026-09-13']);
        $this->assertEquals('unavailable', $product->availability['2026-09-14']);
    }

    public function test_confirming_booking_with_conflicting_dates_shows_warning(): void
    {
        $boutique = Boutique::factory()->create();
        $user = User::factory()->create(['boutique_id' => $boutique->id, 'role' => 'boutique_owner']);
        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'availability' => [
                '2026-09-11' => 'unavailable',
                '2026-09-12' => 'unavailable',
            ],
        ]);

        $enquiry = new Enquiry([
            'product_id' => $product->id,
            'customer_name' => 'Jane Doe',
            'customer_email' => 'jane@example.com',
            'desired_dates' => '2026-09-10 to 2026-09-14',
            'message' => 'Test booking',
        ]);
        $enquiry->boutique_id = $boutique->id;
        $enquiry->status = 'new';
        $enquiry->save();

        $response = $this->actingAs($user)->patch(route('account.enquiries.update', $enquiry), [
            'status' => 'confirmed',
        ]);

        $response->assertRedirect(route('account.enquiries.show', $enquiry));
        $response->assertSessionHas('date_warning');

        $product->refresh();
        $this->assertEquals('unavailable', $product->availability['2026-09-10']);
        $this->assertEquals('unavailable', $product->availability['2026-09-13']);
        $this->assertEquals('unavailable', $product->availability['2026-09-14']);
    }

    public function test_non_confirm_status_does_not_modify_availability(): void
    {
        $boutique = Boutique::factory()->create();
        $user = User::factory()->create(['boutique_id' => $boutique->id, 'role' => 'boutique_owner']);
        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'availability' => [],
        ]);

        $enquiry = new Enquiry([
            'product_id' => $product->id,
            'customer_name' => 'Bob',
            'customer_email' => 'bob@example.com',
            'desired_dates' => '2026-09-10 to 2026-09-14',
            'message' => 'Test',
        ]);
        $enquiry->boutique_id = $boutique->id;
        $enquiry->status = 'new';
        $enquiry->save();

        $this->actingAs($user)->patch(route('account.enquiries.update', $enquiry), [
            'status' => 'cancelled',
        ]);

        $product->refresh();
        $this->assertEmpty($product->availability);
    }
}
