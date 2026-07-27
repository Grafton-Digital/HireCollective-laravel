<?php

namespace Tests\Feature;

use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_displays_without_page_record(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Find your perfect outfit');
    }

    public function test_homepage_displays_dynamic_content(): void
    {
        Page::factory()->create([
            'slug' => 'homepage',
            'template' => 'homepage',
            'is_published' => true,
            'content' => [
                'hero' => [
                    'left' => [
                        'image' => null,
                        'heading' => 'Custom Hero Title',
                        'subtitle' => 'Custom subtitle text',
                        'button_text' => 'SHOP NOW',
                        'button_link' => '/products',
                    ],
                    'right' => [
                        'image' => null,
                        'text' => 'Right side text',
                    ],
                ],
                'featured' => ['heading' => 'Weekly Picks', 'count' => 3],
                'new_arrivals' => ['heading' => 'Fresh Arrivals'],
                'collaboration' => [
                    'image' => null,
                    'heading' => 'Partner With Us',
                    'text' => 'Join our network',
                    'button_text' => 'Get Started',
                    'button_link' => '/products',
                ],
                'brands' => ['count' => 6, 'button_text' => 'SEE ALL', 'button_link' => '/boutiques'],
                'register' => [
                    'image' => null,
                    'heading' => 'Join Us Today',
                    'button_text' => 'Apply',
                    'button_link' => '/boutique/apply',
                ],
            ],
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Custom Hero Title');
        $response->assertSee('Custom subtitle text');
        $response->assertSee('Weekly Picks');
        $response->assertSee('Fresh Arrivals');
        $response->assertSee('Partner With Us');
        $response->assertSee('Join Us Today');
    }
}
