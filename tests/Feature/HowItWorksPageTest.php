<?php

namespace Tests\Feature;

use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HowItWorksPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_how_it_works_page_displays_successfully(): void
    {
        Page::factory()->create([
            'slug' => 'how-it-works',
            'title' => 'How It Works',
            'template' => 'how-it-works',
            'is_published' => true,
            'content' => [
                'heading' => 'How It Works',
                'subtitle' => 'Find answers to common questions',
                'faq' => [
                    ['question' => 'Test question?', 'answer' => 'Test answer.'],
                ],
            ],
        ]);

        $response = $this->get('/how-it-works');

        $response->assertStatus(200);
        $response->assertSee('How It Works');
        $response->assertSee('Find answers to common questions');
        $response->assertSee('Test question?');
        $response->assertSee('Test answer.');
    }

    public function test_how_it_works_page_returns_404_when_unpublished(): void
    {
        Page::factory()->create([
            'slug' => 'how-it-works',
            'template' => 'how-it-works',
            'is_published' => false,
            'content' => [
                'heading' => 'How It Works',
                'subtitle' => '',
                'faq' => [],
            ],
        ]);

        $response = $this->get('/how-it-works');

        $response->assertStatus(404);
    }

    public function test_how_it_works_page_returns_404_when_not_seeded(): void
    {
        $response = $this->get('/how-it-works');

        $response->assertStatus(404);
    }
}
