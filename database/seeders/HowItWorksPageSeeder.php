<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class HowItWorksPageSeeder extends Seeder
{
    public function run(): void
    {
        Page::updateOrCreate(
            ['slug' => 'how-it-works'],
            [
                'title' => 'How It Works',
                'template' => 'how-it-works',
                'is_published' => true,
                'content' => [
                    'heading' => 'How It Works',
                    'subtitle' => 'Find answers to common questions about our platform, ordering, and delivery',
                    'faq' => [
                        [
                            'question' => 'How do I place an order?',
                            'answer' => 'Browse our boutique collections, select the items you love, and add them to your bag. At checkout, choose your preferred delivery option and complete payment. You\'ll receive an order confirmation email with tracking details within 24 hours.',
                        ],
                        [
                            'question' => 'What payment methods do you accept?',
                            'answer' => 'We accept all major credit and debit cards including Visa, Mastercard, and American Express. We also support Apple Pay, Google Pay, and secure online banking payments for your convenience.',
                        ],
                        [
                            'question' => 'How long does delivery take?',
                            'answer' => 'Delivery times vary depending on the boutique and your location. Most orders arrive within 3–7 business days, while international shipping may take 7–14 business days.',
                        ],
                        [
                            'question' => 'Can I return or exchange an item?',
                            'answer' => 'Yes. Most boutiques accept returns or exchanges within 14 days of delivery, provided the item is unworn, unused, and in its original packaging. Return policies may vary by boutique.',
                        ],
                        [
                            'question' => 'How are boutiques selected for the platform?',
                            'answer' => 'We carefully curate every boutique on our platform based on quality, authenticity, customer service, and unique style. Our goal is to offer a trusted selection of premium fashion brands.',
                        ],
                        [
                            'question' => 'Are the products authentic?',
                            'answer' => 'Absolutely. Every product is sourced directly from our partner boutiques, ensuring that all items are 100% authentic and meet our quality standards.',
                        ],
                        [
                            'question' => 'How do I track my order?',
                            'answer' => 'Once your order has been shipped, you\'ll receive a confirmation email with a tracking number and a link to monitor your delivery in real time.',
                        ],
                        [
                            'question' => 'What if an item is out of stock?',
                            'answer' => 'If an item is unavailable, it will be marked as out of stock. Some boutiques may restock popular products, so we recommend checking back or contacting the boutique for availability.',
                        ],
                        [
                            'question' => 'Do you offer gift wrapping?',
                            'answer' => 'Gift wrapping is available for selected boutiques and products. If offered, you\'ll see the option during checkout before completing your purchase.',
                        ],
                        [
                            'question' => 'How can I contact a specific boutique?',
                            'answer' => 'Each boutique has its own profile page with contact information. You can also reach out through our platform, and we\'ll make sure your message gets to the boutique promptly.',
                        ],
                    ],
                ],
            ]
        );
    }
}
