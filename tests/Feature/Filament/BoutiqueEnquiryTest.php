<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\BoutiqueEnquiryResource;
use App\Filament\Resources\BoutiqueResource;
use App\Models\Boutique;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class BoutiqueEnquiryTest extends TestCase
{
    use RefreshDatabase;

    public function test_boutique_owner_can_submit_boutique_enquiry(): void
    {
        $owner = User::factory()->create(['role' => 'boutique_owner']);

        $this->actingAs($owner);

        Livewire::test(BoutiqueResource\Pages\CreateBoutique::class)
            ->fillForm([
                'name' => 'Test Boutique',
                'slug' => 'test-boutique',
                'contact_email' => 'test@boutique.com',
            ])
            ->call('create')
            ->assertNotified();

        $this->assertDatabaseHas(Boutique::class, [
            'name' => 'Test Boutique',
            'slug' => 'test-boutique',
            'status' => Boutique::STATUS_PENDING,
            'submitted_by' => $owner->id,
            'is_active' => false,
        ]);

        $this->assertNull($owner->fresh()->boutique_id);
    }

    public function test_admin_can_see_boutique_enquiries(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $owner = User::factory()->create(['role' => 'boutique_owner']);

        $boutique = Boutique::factory()->create([
            'status' => Boutique::STATUS_PENDING,
            'submitted_by' => $owner->id,
        ]);

        $this->actingAs($admin);

        Livewire::test(BoutiqueEnquiryResource\Pages\ListBoutiqueEnquiries::class)
            ->assertCanSeeTableRecords([$boutique]);
    }

    public function test_admin_can_approve_boutique_enquiry(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $owner = User::factory()->create(['role' => 'boutique_owner']);

        $boutique = Boutique::factory()->create([
            'status' => Boutique::STATUS_PENDING,
            'submitted_by' => $owner->id,
            'is_active' => false,
        ]);

        $this->actingAs($admin);

        Livewire::test(BoutiqueEnquiryResource\Pages\EditBoutiqueEnquiry::class, ['record' => $boutique->id])
            ->callAction('approve');

        $this->assertEquals(Boutique::STATUS_APPROVED, $boutique->fresh()->status);
        $this->assertTrue($boutique->fresh()->is_active);
        $this->assertEquals($boutique->id, $owner->fresh()->boutique_id);
    }

    public function test_admin_can_reject_boutique_enquiry(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $owner = User::factory()->create(['role' => 'boutique_owner']);

        $boutique = Boutique::factory()->create([
            'status' => Boutique::STATUS_PENDING,
            'submitted_by' => $owner->id,
        ]);

        $this->actingAs($admin);

        Livewire::test(BoutiqueEnquiryResource\Pages\EditBoutiqueEnquiry::class, ['record' => $boutique->id])
            ->callAction('reject');

        $this->assertEquals(Boutique::STATUS_REJECTED, $boutique->fresh()->status);
        $this->assertNull($owner->fresh()->boutique_id);
    }

    public function test_boutique_owner_cannot_see_pending_boutiques_in_main_list(): void
    {
        $owner = User::factory()->create(['role' => 'boutique_owner']);

        $pendingBoutique = Boutique::factory()->create([
            'status' => Boutique::STATUS_PENDING,
            'submitted_by' => $owner->id,
        ]);

        $this->actingAs($owner);

        Livewire::test(BoutiqueResource\Pages\ListBoutiques::class)
            ->assertCanNotSeeTableRecords([$pendingBoutique]);
    }

    public function test_boutique_owner_can_see_approved_boutique(): void
    {
        $owner = User::factory()->create(['role' => 'boutique_owner']);

        $boutique = Boutique::factory()->create([
            'status' => Boutique::STATUS_APPROVED,
            'submitted_by' => $owner->id,
            'is_active' => true,
        ]);

        $owner->update(['boutique_id' => $boutique->id]);

        $this->actingAs($owner);

        Livewire::test(BoutiqueResource\Pages\ListBoutiques::class)
            ->assertCanSeeTableRecords([$boutique]);
    }

    public function test_admin_can_create_boutique_directly_without_approval(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin);

        Livewire::test(BoutiqueResource\Pages\CreateBoutique::class)
            ->fillForm([
                'name' => 'Admin Boutique',
                'slug' => 'admin-boutique',
                'contact_email' => 'admin@boutique.com',
            ])
            ->call('create')
            ->assertNotified();

        $this->assertDatabaseHas(Boutique::class, [
            'name' => 'Admin Boutique',
            'status' => Boutique::STATUS_APPROVED,
            'submitted_by' => $admin->id,
        ]);
    }

    public function test_navigation_badge_shows_pending_enquiries_count(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        Boutique::factory()->count(3)->create([
            'status' => Boutique::STATUS_PENDING,
        ]);

        Boutique::factory()->count(2)->create([
            'status' => Boutique::STATUS_APPROVED,
        ]);

        $this->actingAs($admin);

        $badge = BoutiqueEnquiryResource::getNavigationBadge();

        $this->assertEquals('3', $badge);
    }

    public function test_boutique_owner_cannot_create_another_boutique_when_pending_exists(): void
    {
        $owner = User::factory()->create(['role' => 'boutique_owner']);

        Boutique::factory()->create([
            'status' => Boutique::STATUS_PENDING,
            'submitted_by' => $owner->id,
        ]);

        $this->actingAs($owner);

        $this->assertFalse($owner->can('create', Boutique::class));
    }

    public function test_boutique_owner_can_create_after_rejection(): void
    {
        $owner = User::factory()->create(['role' => 'boutique_owner']);

        Boutique::factory()->create([
            'status' => Boutique::STATUS_REJECTED,
            'submitted_by' => $owner->id,
        ]);

        $this->actingAs($owner);

        $this->assertTrue($owner->can('create', Boutique::class));
    }

    public function test_boutique_owner_sees_pending_notification(): void
    {
        $owner = User::factory()->create(['role' => 'boutique_owner']);

        $pendingBoutique = Boutique::factory()->create([
            'name' => 'Test Boutique',
            'status' => Boutique::STATUS_PENDING,
            'submitted_by' => $owner->id,
        ]);

        $this->actingAs($owner);

        Livewire::test(BoutiqueResource\Pages\ListBoutiques::class)
            ->assertNotified();
    }
}
