<?php

namespace Database\Seeders;

use App\Models\Boutique;
use App\Models\Category;
use App\Models\Colour;
use App\Models\HomepageSection;
use App\Models\Occasion;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@hirecollective.ie',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Categories
        $categories = collect([
            ['name' => 'Dresses', 'slug' => 'dresses'],
            ['name' => 'Hats', 'slug' => 'hats'],
            ['name' => 'Bags', 'slug' => 'bags'],
            ['name' => 'Jumpsuits', 'slug' => 'jumpsuits'],
        ])->map(fn ($c) => Category::create($c));

        // Colours
        $colours = collect([
            ['name' => 'Black', 'slug' => 'black', 'hex_code' => '#000000'],
            ['name' => 'White', 'slug' => 'white', 'hex_code' => '#FFFFFF'],
            ['name' => 'Red', 'slug' => 'red', 'hex_code' => '#DC2626'],
            ['name' => 'Navy', 'slug' => 'navy', 'hex_code' => '#1E3A5F'],
            ['name' => 'Emerald', 'slug' => 'emerald', 'hex_code' => '#047857'],
            ['name' => 'Blush', 'slug' => 'blush', 'hex_code' => '#FBCFE8'],
            ['name' => 'Gold', 'slug' => 'gold', 'hex_code' => '#C4975A'],
            ['name' => 'Champagne', 'slug' => 'champagne', 'hex_code' => '#F7E7CE'],
        ])->map(fn ($c) => Colour::create($c));

        // Occasions
        $occasions = collect([
            ['name' => 'Wedding', 'slug' => 'wedding'],
            ['name' => 'Races', 'slug' => 'races'],
            ['name' => 'Black Tie', 'slug' => 'black-tie'],
            ['name' => 'Cocktail', 'slug' => 'cocktail'],
            ['name' => 'Formal', 'slug' => 'formal'],
            ['name' => 'Party', 'slug' => 'party'],
        ])->map(fn ($o) => Occasion::create($o));

        // Boutiques
        $boutiques = collect([
            [
                'name' => 'Complete Look',
                'slug' => 'complete-look',
                'description' => "Chic, modern and effortlessly elegant. Complete Look offers a handpicked edit of designer pieces for every occasion.\n\nBased in Dublin, we're known for our curated collection of modern, timeless pieces from 100+ designer and premium brands.",
                'city' => 'Dublin',
                'county' => 'Dublin',
                'contact_email' => 'hello@completelook.ie',
                'phone' => '087 123 4567',
                'address' => '12 Grafton Street',
                'is_active' => true,
                'opening_hours' => ['Mon-Fri' => '10:00 - 18:00', 'Sat' => '10:00 - 17:00', 'Sun' => 'Closed'],
            ],
            [
                'name' => 'Leasa Look',
                'slug' => 'leasa-look',
                'description' => 'A boutique specialising in contemporary designer dress hire with a focus on sustainability and style.',
                'city' => 'Cork',
                'county' => 'Cork',
                'contact_email' => 'info@leasalook.ie',
                'phone' => '021 456 7890',
                'address' => '5 Patrick Street',
                'is_active' => true,
                'opening_hours' => ['Mon-Sat' => '10:00 - 18:00', 'Sun' => '12:00 - 17:00'],
            ],
            [
                'name' => 'Muse Rental',
                'slug' => 'muse-rental',
                'description' => 'Premium occasion wear hire. From red carpet gowns to chic cocktail dresses, find your perfect look.',
                'city' => 'Galway',
                'county' => 'Galway',
                'contact_email' => 'hello@muserental.ie',
                'phone' => '091 234 5678',
                'address' => '8 Shop Street',
                'is_active' => true,
                'opening_hours' => ['Tue-Sat' => '10:00 - 18:00', 'Sun-Mon' => 'Closed'],
            ],
        ])->map(fn ($b) => Boutique::create($b));

        // Owner users for each boutique
        foreach ($boutiques as $i => $boutique) {
            User::create([
                'name' => $boutique->name.' Owner',
                'email' => 'owner'.($i + 1).'@hirecollective.ie',
                'password' => Hash::make('password'),
                'role' => 'boutique_owner',
                'boutique_id' => $boutique->id,
            ]);
        }

        // Products
        $dresses = $categories->firstWhere('slug', 'dresses');
        $productData = [
            ['name' => 'Black Lace Mini', 'slug' => 'black-lace-mini', 'boutique' => 0, 'colour' => 'black', 'price_from' => 75],
            ['name' => 'Emerald Satin Midi', 'slug' => 'emerald-satin-midi', 'boutique' => 1, 'colour' => 'emerald', 'price_from' => 65],
            ['name' => 'Blush Tulle Gown', 'slug' => 'blush-tulle-gown', 'boutique' => 2, 'colour' => 'blush', 'price_from' => 95],
            ['name' => 'Navy Wrap Dress', 'slug' => 'navy-wrap-dress', 'boutique' => 0, 'colour' => 'navy', 'price_from' => 60],
            ['name' => 'Gold Sequin Mini', 'slug' => 'gold-sequin-mini', 'boutique' => 1, 'colour' => 'gold', 'price_from' => 70],
            ['name' => 'Ivory Strapless Maxi', 'slug' => 'ivory-strapless-maxi', 'boutique' => 2, 'colour' => 'champagne', 'price_from' => 85],
            ['name' => 'Red One Shoulder', 'slug' => 'red-one-shoulder', 'boutique' => 0, 'colour' => 'red', 'price_from' => 65],
            ['name' => 'Satin Halter Maxi', 'slug' => 'satin-halter-maxi', 'boutique' => 0, 'colour' => 'champagne', 'price_from' => 75],
            ['name' => 'Pink Floral Ruffle', 'slug' => 'pink-floral-ruffle', 'boutique' => 1, 'colour' => 'blush', 'price_from' => 70],
            ['name' => 'Champagne Slip Dress', 'slug' => 'champagne-slip-dress', 'boutique' => 2, 'colour' => 'champagne', 'price_from' => 55],
            ['name' => 'Sage Ruched Midi', 'slug' => 'sage-ruched-midi', 'boutique' => 0, 'colour' => 'emerald', 'price_from' => 65],
            ['name' => 'Cobalt Blazer Dress', 'slug' => 'cobalt-blazer-dress', 'boutique' => 2, 'colour' => 'navy', 'price_from' => 80],
        ];

        foreach ($productData as $pd) {
            $product = Product::create([
                'boutique_id' => $boutiques[$pd['boutique']]->id,
                'name' => $pd['name'],
                'slug' => $pd['slug'],
                'description' => 'A stunning piece perfect for any formal occasion. Features elegant design and premium materials.',
                'is_variable' => true,
                'is_available' => true,
                'is_active' => true,
            ]);

            $sizes = [6, 8, 10, 12];
            foreach ($sizes as $size) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'size' => (string) $size,
                    'price' => $pd['price_from'] + (($size - 6) * 5),
                    'is_available' => true,
                ]);
            }

            $product->categories()->attach($dresses->id);
            $product->colours()->attach($colours->firstWhere('slug', $pd['colour'])->id);
            $product->occasions()->attach($occasions->random(rand(2, 3))->pluck('id'));
        }

        // Pages
        Page::create([
            'title' => 'About',
            'slug' => 'about',
            'content' => "# About Hire Collective\n\nHire Collective is Ireland's luxury multi-boutique fashion hire marketplace. We bring together the country's most trusted independent hire boutiques in one place.\n\n## Our Mission\n\nTo make luxury fashion accessible and sustainable by connecting you with Ireland's finest hire boutiques.\n\n## How It Works\n\n1. **Browse** — Discover hundreds of styles from trusted boutiques\n2. **Enquire** — Send an enquiry about your chosen item\n3. **Hire** — The boutique will get back to you to arrange your hire",
            'is_published' => true,
        ]);

        Page::create([
            'title' => 'FAQ',
            'slug' => 'faq',
            'content' => "# Frequently Asked Questions\n\n## How does hiring work?\n\nBrowse our collection, find something you love, and submit an enquiry. The boutique will contact you directly to arrange hire dates, fitting, and payment.\n\n## How long can I hire for?\n\nHire periods vary by boutique but are typically 3-5 days.\n\n## What if something doesn't fit?\n\nMost boutiques offer a fitting appointment before your event. Contact the boutique directly to arrange.\n\n## Is delivery available?\n\nMany boutiques offer nationwide delivery. Check with the individual boutique for their delivery policy.",
            'is_published' => true,
        ]);

        // Homepage sections
        HomepageSection::create([
            'type' => 'hero',
            'title' => 'Find your perfect outfit — all in one place',
            'content' => 'Hundreds of styles brought together from some of Ireland\'s most trusted hire boutiques.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        HomepageSection::create([
            'type' => 'featured_boutiques',
            'title' => 'Browse Our Trusted Boutiques',
            'sort_order' => 2,
            'is_active' => true,
        ]);
    }
}
