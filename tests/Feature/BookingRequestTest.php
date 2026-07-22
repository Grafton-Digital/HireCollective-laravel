<?php

namespace Tests\Feature;

use App\Models\Boutique;
use App\Models\Enquiry;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_booking_request_can_be_submitted_via_ajax(): void
    {
        $product = Product::factory()->approved()->create();

        $response = $this->postJson('/enquiry', [
            'product_id' => $product->id,
            'customer_name' => 'Jane Doe',
            'customer_email' => 'jane@example.com',
            'customer_phone' => '+353 87 123 4567',
            'desired_dates' => '2026-08-15',
            'message' => 'I would like to book this dress for a wedding.',
        ]);

        $response->assertOk()
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('enquiries', [
            'product_id' => $product->id,
            'boutique_id' => $product->boutique_id,
            'customer_name' => 'Jane Doe',
            'customer_email' => 'jane@example.com',
            'status' => 'new',
        ]);
    }

    public function test_booking_request_validation_returns_json_errors(): void
    {
        $product = Product::factory()->approved()->create();

        $response = $this->postJson('/enquiry', [
            'product_id' => $product->id,
            'customer_name' => '',
            'customer_email' => 'not-an-email',
            'message' => '',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['customer_name', 'customer_email', 'message']);
    }

    public function test_booking_request_fails_for_inactive_product(): void
    {
        $product = Product::factory()->pending()->create();

        $response = $this->postJson('/enquiry', [
            'product_id' => $product->id,
            'customer_name' => 'Jane Doe',
            'customer_email' => 'jane@example.com',
            'message' => 'Test message.',
        ]);

        $response->assertNotFound();
    }

    public function test_boutique_owner_can_confirm_booking(): void
    {
        $boutique = Boutique::factory()->approved()->create();
        $user = User::factory()->create(['role' => 'boutique_owner', 'boutique_id' => $boutique->id]);
        $product = Product::factory()->approved()->create(['boutique_id' => $boutique->id]);

        $enquiry = new Enquiry([
            'product_id' => $product->id,
            'customer_name' => 'Jane Doe',
            'customer_email' => 'jane@example.com',
            'message' => 'Test booking',
        ]);
        $enquiry->boutique_id = $boutique->id;
        $enquiry->status = 'new';
        $enquiry->save();

        $response = $this->actingAs($user)->patch("/account/enquiries/{$enquiry->id}", [
            'status' => 'confirmed',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('enquiries', [
            'id' => $enquiry->id,
            'status' => 'confirmed',
        ]);
    }

    public function test_boutique_owner_can_complete_confirmed_booking(): void
    {
        $boutique = Boutique::factory()->approved()->create();
        $user = User::factory()->create(['role' => 'boutique_owner', 'boutique_id' => $boutique->id]);
        $product = Product::factory()->approved()->create(['boutique_id' => $boutique->id]);

        $enquiry = new Enquiry([
            'product_id' => $product->id,
            'customer_name' => 'Jane Doe',
            'customer_email' => 'jane@example.com',
            'message' => 'Test booking',
        ]);
        $enquiry->boutique_id = $boutique->id;
        $enquiry->status = 'confirmed';
        $enquiry->save();

        $response = $this->actingAs($user)->patch("/account/enquiries/{$enquiry->id}", [
            'status' => 'completed',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('enquiries', [
            'id' => $enquiry->id,
            'status' => 'completed',
        ]);
    }

    public function test_boutique_owner_can_cancel_booking(): void
    {
        $boutique = Boutique::factory()->approved()->create();
        $user = User::factory()->create(['role' => 'boutique_owner', 'boutique_id' => $boutique->id]);
        $product = Product::factory()->approved()->create(['boutique_id' => $boutique->id]);

        $enquiry = new Enquiry([
            'product_id' => $product->id,
            'customer_name' => 'Jane Doe',
            'customer_email' => 'jane@example.com',
            'message' => 'Test booking',
        ]);
        $enquiry->boutique_id = $boutique->id;
        $enquiry->status = 'new';
        $enquiry->save();

        $response = $this->actingAs($user)->patch("/account/enquiries/{$enquiry->id}", [
            'status' => 'cancelled',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('enquiries', [
            'id' => $enquiry->id,
            'status' => 'cancelled',
        ]);
    }
}
