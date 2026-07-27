<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class HomepageSeeder extends Seeder
{
    public function run(): void
    {
        Page::updateOrCreate(
            ['slug' => 'homepage'],
            [
                'title' => 'Homepage',
                'template' => 'homepage',
                'is_published' => true,
                'content' => [
                    'hero' => [
                        'left' => [
                            'image' => null,
                            'heading' => 'Find your perfect outfit — all in one place',
                            'subtitle' => 'Hundreds of styles brought together from some of Ireland\'s most trusted hire boutiques.',
                            'button_text' => 'BROWSE NOW',
                            'button_link' => '/products',
                        ],
                        'right' => [
                            'image' => null,
                            'text' => 'Learn how it works',
                        ],
                    ],
                    'featured' => [
                        'heading' => 'Featured Edit of the Week',
                        'count' => 3,
                    ],
                    'categories' => [
                        [
                            'image' => null,
                            'text' => 'All products',
                            'link' => '/products',
                        ],
                        [
                            'image' => null,
                            'text' => 'Suits/Jumpsuits',
                            'link' => '/products?category=suits',
                        ],
                        [
                            'image' => null,
                            'text' => 'Dresses',
                            'link' => '/products?category=dresses',
                        ],
                        [
                            'image' => null,
                            'text' => 'Hats',
                            'link' => '/products?category=hats',
                        ],
                        [
                            'image' => null,
                            'text' => 'Bags',
                            'link' => '/products?category=bags',
                        ],
                    ],
                    'new_arrivals' => [
                        'heading' => 'NEW ARRIVALS',
                    ],
                    'collaboration' => [
                        'image' => null,
                        'heading' => 'For Colaboration',
                        'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem ducimus sunt deleniti, tempora, porro animi, minus labore excepturi deserunt reiciendis distinctio maiores laboriosam facilis.',
                        'button_text' => 'Contact Us',
                        'button_link' => '/products',
                    ],
                    'brands' => [
                        'count' => 6,
                        'button_text' => 'VIEW ALL BRANDS',
                        'button_link' => '/boutiques',
                    ],
                    'register' => [
                        'image' => null,
                        'heading' => 'Register your boutique',
                        'button_text' => 'Register Now',
                        'button_link' => '/boutique/apply',
                    ],
                ],
            ]
        );
    }
}
