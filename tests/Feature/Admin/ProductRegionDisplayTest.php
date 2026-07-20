<?php

namespace Tests\Feature\Admin;

use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Resources\ProductResource\Pages\ListProducts;
use App\Models\Boutique;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ProductRegionDisplayTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_region_is_displayed_in_table(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $boutique = Boutique::factory()->create([
            'county' => 'Dublin',
            'status' => Boutique::STATUS_APPROVED,
        ]);

        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'status' => Product::STATUS_APPROVED,
        ]);

        $this->actingAs($admin);

        Livewire::test(ListProducts::class)
            ->assertCanSeeTableRecords([$product])
            ->assertTableColumnExists('boutique.county');
    }

    public function test_product_region_is_displayed_in_edit_form(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $boutique = Boutique::factory()->create([
            'county' => 'Dublin',
            'status' => Boutique::STATUS_APPROVED,
        ]);

        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'status' => Product::STATUS_APPROVED,
        ]);

        $this->actingAs($admin);

        Livewire::test(EditProduct::class, ['record' => $product->id])
            ->assertFormFieldExists('boutique.county');
    }

    public function test_products_can_be_filtered_by_region(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $dublinBoutique = Boutique::factory()->create([
            'county' => 'Dublin',
            'status' => Boutique::STATUS_APPROVED,
        ]);

        $corkBoutique = Boutique::factory()->create([
            'county' => 'Cork',
            'status' => Boutique::STATUS_APPROVED,
        ]);

        $dublinProduct = Product::factory()->create([
            'boutique_id' => $dublinBoutique->id,
            'county' => 'Dublin',
            'status' => Product::STATUS_APPROVED,
        ]);

        $corkProduct = Product::factory()->create([
            'boutique_id' => $corkBoutique->id,
            'county' => 'Cork',
            'status' => Product::STATUS_APPROVED,
        ]);

        $this->actingAs($admin);

        Livewire::test(ListProducts::class)
            ->assertCanSeeTableRecords([$dublinProduct, $corkProduct])
            ->filterTable('county', 'Dublin')
            ->assertCanSeeTableRecords([$dublinProduct])
            ->assertCanNotSeeTableRecords([$corkProduct]);
    }
}
