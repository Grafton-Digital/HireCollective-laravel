<?php

namespace Tests\Feature\Admin;

use App\County;
use App\Filament\Resources\ProductResource\Pages\CreateProduct;
use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Resources\ProductResource\Pages\ListProducts;
use App\Models\Boutique;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class BoutiqueOwnerProductCountyTest extends TestCase
{
    use RefreshDatabase;

    public function test_boutique_owner_can_see_county_select_in_create_form(): void
    {
        $boutique = Boutique::factory()->create([
            'status' => Boutique::STATUS_APPROVED,
        ]);

        $owner = User::factory()->create([
            'role' => 'boutique_owner',
            'boutique_id' => $boutique->id,
        ]);

        $this->actingAs($owner);

        Livewire::test(CreateProduct::class)
            ->assertFormFieldExists('county')
            ->assertFormFieldIsVisible('county');
    }

    public function test_boutique_owner_can_create_product_with_county(): void
    {
        $boutique = Boutique::factory()->create([
            'status' => Boutique::STATUS_APPROVED,
        ]);

        $owner = User::factory()->create([
            'role' => 'boutique_owner',
            'boutique_id' => $boutique->id,
        ]);

        $this->actingAs($owner);

        Livewire::test(CreateProduct::class)
            ->fillForm([
                'boutique_id' => $boutique->id,
                'county' => County::DUBLIN->value,
                'name' => 'Test Product',
                'slug' => 'test-product',
                'description' => 'Test description',
                'is_variable' => false,
                'price_per_day' => 100,
                'is_available' => true,
                'is_active' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'county' => County::DUBLIN->value,
            'boutique_id' => $boutique->id,
        ]);
    }

    public function test_boutique_owner_can_edit_product_county(): void
    {
        $boutique = Boutique::factory()->create([
            'status' => Boutique::STATUS_APPROVED,
        ]);

        $owner = User::factory()->create([
            'role' => 'boutique_owner',
            'boutique_id' => $boutique->id,
        ]);

        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'county' => County::DUBLIN,
        ]);

        $this->actingAs($owner);

        Livewire::test(EditProduct::class, ['record' => $product->id])
            ->fillForm(['county' => County::CORK->value])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'county' => County::CORK->value,
        ]);
    }

    public function test_boutique_owner_sees_product_county_in_table(): void
    {
        $boutique = Boutique::factory()->create([
            'status' => Boutique::STATUS_APPROVED,
        ]);

        $owner = User::factory()->create([
            'role' => 'boutique_owner',
            'boutique_id' => $boutique->id,
        ]);

        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'county' => County::DUBLIN,
        ]);

        $this->actingAs($owner);

        Livewire::test(ListProducts::class)
            ->assertCanSeeTableRecords([$product])
            ->assertTableColumnExists('county');
    }

    public function test_county_field_is_required_for_boutique_owner(): void
    {
        $boutique = Boutique::factory()->create([
            'status' => Boutique::STATUS_APPROVED,
        ]);

        $owner = User::factory()->create([
            'role' => 'boutique_owner',
            'boutique_id' => $boutique->id,
        ]);

        $this->actingAs($owner);

        Livewire::test(CreateProduct::class)
            ->fillForm([
                'boutique_id' => $boutique->id,
                'name' => 'Test Product',
                'slug' => 'test-product',
                'county' => null,
            ])
            ->call('create')
            ->assertHasFormErrors(['county' => 'required']);
    }
}
