<?php

namespace Tests\Feature;

use App\Mail\BookTestMail;
use App\Models\Boutique;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class BookTestControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_book_test_sends_email_to_admin(): void
    {
        Mail::fake();

        $product = Product::factory()->for(Boutique::factory()->state(['is_active' => true]))->create(['is_active' => true]);

        $response = $this->postJson('/book-test', [
            'product_id' => $product->id,
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'customer_phone' => '+353 87 123 4567',
        ]);

        $response->assertOk();

        Mail::assertSent(BookTestMail::class, function ($mail) use ($product) {
            return $mail->hasTo($product->boutique->contact_email)
                && $mail->customerName === 'John Doe'
                && $mail->customerEmail === 'john@example.com'
                && $mail->customerPhone === '+353 87 123 4567'
                && $mail->productName === $product->name;
        });
    }

    public function test_book_test_works_without_phone(): void
    {
        Mail::fake();

        $product = Product::factory()->for(Boutique::factory()->state(['is_active' => true]))->create(['is_active' => true]);

        $response = $this->postJson('/book-test', [
            'product_id' => $product->id,
            'customer_name' => 'Jane Doe',
            'customer_email' => 'jane@example.com',
        ]);

        $response->assertOk();

        Mail::assertSent(BookTestMail::class);
    }

    public function test_book_test_validates_required_fields(): void
    {
        $response = $this->postJson('/book-test', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['product_id', 'customer_name', 'customer_email']);
    }

    public function test_book_test_validates_email_format(): void
    {
        $product = Product::factory()->for(Boutique::factory()->state(['is_active' => true]))->create(['is_active' => true]);

        $response = $this->postJson('/book-test', [
            'product_id' => $product->id,
            'customer_name' => 'John',
            'customer_email' => 'not-an-email',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['customer_email']);
    }

    public function test_book_test_fails_for_inactive_product(): void
    {
        Mail::fake();

        $product = Product::factory()->for(Boutique::factory()->state(['is_active' => true]))->create(['is_active' => false]);

        $response = $this->postJson('/book-test', [
            'product_id' => $product->id,
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
        ]);

        $response->assertStatus(404);

        Mail::assertNothingSent();
    }
}
