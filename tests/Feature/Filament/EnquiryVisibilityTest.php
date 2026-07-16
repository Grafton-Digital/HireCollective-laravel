<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\EnquiryResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnquiryVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_enquiry_resource_hidden_from_boutique_owner(): void
    {
        $owner = User::factory()->create(['role' => 'boutique_owner']);

        $this->actingAs($owner);

        $this->assertFalse(EnquiryResource::shouldRegisterNavigation());
    }

    public function test_enquiry_resource_visible_to_admin(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin);

        $this->assertTrue(EnquiryResource::shouldRegisterNavigation());
    }

    public function test_enquiry_resource_visible_to_customer(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);

        $this->actingAs($customer);

        $this->assertTrue(EnquiryResource::shouldRegisterNavigation());
    }
}
