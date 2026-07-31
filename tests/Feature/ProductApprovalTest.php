<?php

namespace Tests\Feature;

use App\Models\Boutique;
use App\Models\Category;
use App\Models\Colour;
use App\Models\Product;
use App\Models\User;
use App\Notifications\NewProductSubmissionNotification;
use App\Notifications\ProductApprovedNotification;
use App\Notifications\ProductRejectedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductApprovalTest extends TestCase
{
    use RefreshDatabase;

    private User $owner;

    private Boutique $boutique;

    protected function setUp(): void
    {
        parent::setUp();

        $this->boutique = Boutique::factory()->approved()->create();
        $this->owner = User::factory()->create([
            'role' => 'boutique_owner',
            'boutique_id' => $this->boutique->id,
        ]);
    }

    public function test_product_is_created_with_pending_status(): void
    {
        Storage::fake('public');
        Notification::fake();

        $category = Category::create(['name' => 'Dresses', 'slug' => 'dresses']);
        $colour = Colour::create(['name' => 'Red', 'slug' => 'red']);

        $response = $this->actingAs($this->owner)->post(route('account.products.store'), [
            'name' => 'Test Product',
            'price_per_day' => '50.00',
            'size' => 'M',
            'county' => 'Dublin',
            'colours' => [$colour->id],
            'category' => $category->id,
            'featured_image' => UploadedFile::fake()->image('product.jpg'),
        ]);

        $response->assertRedirect(route('account.products'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'status' => Product::STATUS_PENDING,
            'is_active' => false,
            'submitted_by' => $this->owner->id,
            'boutique_id' => $this->boutique->id,
        ]);

        Notification::assertSentOnDemand(NewProductSubmissionNotification::class);
    }

    public function test_product_approval_activates_product_and_notifies_owner(): void
    {
        Notification::fake();

        $product = Product::factory()->pending()->create([
            'boutique_id' => $this->boutique->id,
            'submitted_by' => $this->owner->id,
        ]);

        $product->approve();

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'status' => Product::STATUS_APPROVED,
            'is_active' => true,
        ]);

        Notification::assertSentTo($this->owner, ProductApprovedNotification::class);
    }

    public function test_product_rejection_deactivates_product_and_notifies_owner(): void
    {
        Notification::fake();

        $product = Product::factory()->pending()->create([
            'boutique_id' => $this->boutique->id,
            'submitted_by' => $this->owner->id,
        ]);

        $product->reject('Images are low quality');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'status' => Product::STATUS_REJECTED,
            'is_active' => false,
        ]);

        Notification::assertSentTo(
            $this->owner,
            function (ProductRejectedNotification $notification) {
                return $notification->reason === 'Images are low quality';
            }
        );
    }

    public function test_editing_rejected_product_resubmits_for_review(): void
    {
        Storage::fake('public');
        Notification::fake();

        $category = Category::create(['name' => 'Dresses', 'slug' => 'dresses']);
        $colour = Colour::create(['name' => 'Red', 'slug' => 'red']);

        $product = Product::factory()->rejected()->create([
            'boutique_id' => $this->boutique->id,
            'submitted_by' => $this->owner->id,
            'category_id' => $category->id,
        ]);
        $product->colours()->sync([$colour->id]);

        $response = $this->actingAs($this->owner)->put(route('account.products.update', $product), [
            'name' => 'Updated Product',
            'price_per_day' => '60.00',
            'size' => 'L',
            'county' => 'Dublin',
            'colours' => [$colour->id],
            'category' => $category->id,
        ]);

        $response->assertRedirect(route('account.products'));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
            'status' => Product::STATUS_PENDING,
            'is_active' => false,
        ]);

        Notification::assertSentOnDemand(NewProductSubmissionNotification::class);
    }

    public function test_editing_approved_product_does_not_change_status(): void
    {
        Storage::fake('public');
        Notification::fake();

        $category = Category::create(['name' => 'Dresses', 'slug' => 'dresses']);
        $colour = Colour::create(['name' => 'Red', 'slug' => 'red']);

        $product = Product::factory()->approved()->create([
            'boutique_id' => $this->boutique->id,
            'submitted_by' => $this->owner->id,
            'category_id' => $category->id,
        ]);
        $product->colours()->sync([$colour->id]);

        $this->actingAs($this->owner)->put(route('account.products.update', $product), [
            'name' => 'Updated Product',
            'price_per_day' => '60.00',
            'size' => 'L',
            'county' => 'Dublin',
            'colours' => [$colour->id],
            'category' => $category->id,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'status' => Product::STATUS_APPROVED,
            'is_active' => true,
        ]);

        Notification::assertNothingSentTo($this->owner);
    }

    public function test_rejected_product_is_not_deleted(): void
    {
        Notification::fake();

        $product = Product::factory()->pending()->create([
            'boutique_id' => $this->boutique->id,
            'submitted_by' => $this->owner->id,
        ]);

        $product->reject('Not suitable');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
        ]);
    }
}
