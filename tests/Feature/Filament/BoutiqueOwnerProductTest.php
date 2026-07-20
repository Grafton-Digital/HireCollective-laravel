<?php

namespace Tests\Feature\Filament;

use App\County;
use App\Filament\Resources\ProductResource;
use App\Models\Boutique;
use App\Models\Colour;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class BoutiqueOwnerProductTest extends TestCase
{
    use RefreshDatabase;

    protected Colour $colour;

    protected function setUp(): void
    {
        parent::setUp();

        $this->colour = Colour::create(['name' => 'Black', 'slug' => 'black', 'hex_code' => '#000000']);
    }

    public function test_boutique_owner_can_create_product(): void
    {
        $boutique = Boutique::factory()->create();
        $owner = User::factory()->create([
            'role' => 'boutique_owner',
            'boutique_id' => $boutique->id,
        ]);

        $this->actingAs($owner);

        Livewire::test(ProductResource\Pages\CreateProduct::class)
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
                'colours' => [$this->colour->id],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas(Product::class, [
            'name' => 'Test Product',
            'boutique_id' => $boutique->id,
        ]);
    }

    public function test_boutique_owner_can_only_create_products_for_their_boutique(): void
    {
        $boutique1 = Boutique::factory()->create();
        $boutique2 = Boutique::factory()->create();
        $owner = User::factory()->create([
            'role' => 'boutique_owner',
            'boutique_id' => $boutique1->id,
        ]);

        $this->actingAs($owner);

        Livewire::test(ProductResource\Pages\CreateProduct::class)
            ->fillForm([
                'boutique_id' => $boutique1->id,
                'county' => County::CORK->value,
                'name' => 'Test Product',
                'slug' => 'test-product',
                'description' => 'Test description',
                'is_variable' => false,
                'price_per_day' => 100,
                'is_available' => true,
                'is_active' => true,
                'colours' => [$this->colour->id],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $product = Product::where('name', 'Test Product')->first();
        $this->assertEquals($boutique1->id, $product->boutique_id);
        $this->assertNotEquals($boutique2->id, $product->boutique_id);
    }

    public function test_boutique_owner_can_edit_their_product(): void
    {
        $boutique = Boutique::factory()->create();
        $owner = User::factory()->create([
            'role' => 'boutique_owner',
            'boutique_id' => $boutique->id,
        ]);
        $product = Product::factory()->create([
            'boutique_id' => $boutique->id,
            'name' => 'Original Name',
            'price_per_day' => 100,
        ]);

        $product->colours()->attach($this->colour->id);

        $this->actingAs($owner);

        Livewire::test(ProductResource\Pages\EditProduct::class, ['record' => $product->id])
            ->fillForm([
                'name' => 'Updated Name',
                'price_per_day' => 100,
                'colours' => [$this->colour->id],
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas(Product::class, [
            'id' => $product->id,
            'name' => 'Updated Name',
            'boutique_id' => $boutique->id,
        ]);
    }

    public function test_boutique_owner_cannot_see_other_boutique_products(): void
    {
        $boutique1 = Boutique::factory()->create();
        $boutique2 = Boutique::factory()->create();
        $owner = User::factory()->create([
            'role' => 'boutique_owner',
            'boutique_id' => $boutique1->id,
        ]);
        $ownProduct = Product::factory()->create(['boutique_id' => $boutique1->id]);
        $otherProduct = Product::factory()->create(['boutique_id' => $boutique2->id]);

        $this->actingAs($owner);

        Livewire::test(ProductResource\Pages\ListProducts::class)
            ->assertCanSeeTableRecords([$ownProduct])
            ->assertCanNotSeeTableRecords([$otherProduct]);
    }
}
