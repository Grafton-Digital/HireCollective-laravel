<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\ProductEnquiryResource;
use App\Filament\Resources\ProductResource;
use App\Models\Boutique;
use App\Models\Colour;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ProductEnquiryTest extends TestCase
{
    use RefreshDatabase;

    protected Colour $colour;

    protected function setUp(): void
    {
        parent::setUp();

        $this->colour = Colour::create(['name' => 'Black', 'slug' => 'black', 'hex_code' => '#000000']);
    }

    public function test_boutique_owner_can_submit_product_enquiry(): void
    {
        $owner = User::factory()->create(['role' => 'boutique_owner']);
        $boutique = Boutique::factory()->create([
            'status' => Boutique::STATUS_APPROVED,
            'submitted_by' => $owner->id,
        ]);
        $owner->update(['boutique_id' => $boutique->id]);

        $this->actingAs($owner);

        Livewire::test(ProductResource\Pages\CreateProduct::class)
            ->fillForm([
                'name' => 'Test Product',
                'slug' => 'test-product',
                'price_per_day' => 100,
                'is_variable' => false,
                'colours' => [$this->colour->id],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas(Product::class, [
            'name' => 'Test Product',
            'slug' => 'test-product',
            'status' => Product::STATUS_PENDING,
            'submitted_by' => $owner->id,
            'is_active' => false,
        ]);
    }

    public function test_admin_can_see_product_enquiries(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $owner = User::factory()->create(['role' => 'boutique_owner']);
        $boutique = Boutique::factory()->create(['submitted_by' => $owner->id]);

        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'status' => Product::STATUS_PENDING,
            'submitted_by' => $owner->id,
        ]);

        $this->actingAs($admin);

        Livewire::test(ProductEnquiryResource\Pages\ListProductEnquiries::class)
            ->assertCanSeeTableRecords([$product]);
    }

    public function test_admin_can_approve_product_enquiry(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $owner = User::factory()->create(['role' => 'boutique_owner']);
        $boutique = Boutique::factory()->create(['submitted_by' => $owner->id]);

        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'status' => Product::STATUS_PENDING,
            'submitted_by' => $owner->id,
            'is_active' => false,
        ]);

        $this->actingAs($admin);

        Livewire::test(ProductEnquiryResource\Pages\EditProductEnquiry::class, ['record' => $product->id])
            ->callAction('approve');

        $this->assertEquals(Product::STATUS_APPROVED, $product->fresh()->status);
        $this->assertTrue($product->fresh()->is_active);
    }

    public function test_admin_can_reject_product_enquiry(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $owner = User::factory()->create(['role' => 'boutique_owner']);
        $boutique = Boutique::factory()->create(['submitted_by' => $owner->id]);

        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'status' => Product::STATUS_PENDING,
            'submitted_by' => $owner->id,
        ]);

        $this->actingAs($admin);

        Livewire::test(ProductEnquiryResource\Pages\EditProductEnquiry::class, ['record' => $product->id])
            ->callAction('reject');

        $this->assertEquals(Product::STATUS_REJECTED, $product->fresh()->status);
        $this->assertFalse($product->fresh()->is_active);
    }

    public function test_boutique_owner_sees_all_products_with_status(): void
    {
        $owner = User::factory()->create(['role' => 'boutique_owner']);
        $boutique = Boutique::factory()->create([
            'status' => Boutique::STATUS_APPROVED,
            'submitted_by' => $owner->id,
        ]);
        $owner->update(['boutique_id' => $boutique->id]);

        $pendingProduct = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'status' => Product::STATUS_PENDING,
            'submitted_by' => $owner->id,
        ]);

        $approvedProduct = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'status' => Product::STATUS_APPROVED,
            'submitted_by' => $owner->id,
        ]);

        $this->actingAs($owner);

        Livewire::test(ProductResource\Pages\ListProducts::class)
            ->assertCanSeeTableRecords([$pendingProduct, $approvedProduct]);
    }

    public function test_boutique_owner_cannot_edit_pending_product(): void
    {
        $owner = User::factory()->create(['role' => 'boutique_owner']);
        $boutique = Boutique::factory()->create([
            'status' => Boutique::STATUS_APPROVED,
            'submitted_by' => $owner->id,
        ]);
        $owner->update(['boutique_id' => $boutique->id]);

        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'status' => Product::STATUS_PENDING,
            'submitted_by' => $owner->id,
        ]);

        $this->actingAs($owner);

        $this->assertFalse($owner->can('update', $product));
    }

    public function test_boutique_owner_can_edit_approved_product(): void
    {
        $owner = User::factory()->create(['role' => 'boutique_owner']);
        $boutique = Boutique::factory()->create([
            'status' => Boutique::STATUS_APPROVED,
            'submitted_by' => $owner->id,
        ]);
        $owner->update(['boutique_id' => $boutique->id]);

        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'status' => Product::STATUS_APPROVED,
            'submitted_by' => $owner->id,
        ]);

        $this->actingAs($owner);

        $this->assertTrue($owner->can('update', $product));
    }

    public function test_admin_can_create_product_directly_without_approval(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $boutique = Boutique::factory()->create();

        $this->actingAs($admin);

        Livewire::test(ProductResource\Pages\CreateProduct::class)
            ->fillForm([
                'boutique_id' => $boutique->id,
                'name' => 'Admin Product',
                'slug' => 'admin-product',
                'price_per_day' => 150,
                'is_variable' => false,
                'colours' => [$this->colour->id],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas(Product::class, [
            'name' => 'Admin Product',
            'status' => Product::STATUS_APPROVED,
            'submitted_by' => $admin->id,
        ]);
    }

    public function test_navigation_badge_shows_pending_product_enquiries_count(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        Product::factory()->count(5)->create([
            'status' => Product::STATUS_PENDING,
        ]);

        Product::factory()->count(3)->create([
            'status' => Product::STATUS_APPROVED,
        ]);

        $this->actingAs($admin);

        $badge = ProductEnquiryResource::getNavigationBadge();

        $this->assertEquals('5', $badge);
    }
}
