<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faq;
use App\Models\Page;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $page = Page::where('slug', 'about')->first();
        $faqableType = $page ? Page::class : null;
        $faqableId = $page?->id;

        $faqs = [
            [
                'question' => 'How do I book a tour or holiday package?',
                'answer' => 'You can browse our tours and destinations, select the package you love, choose your travel dates and number of travelers, then complete a simple checkout. Once your booking is confirmed, our team will contact you to finalize all the details.',
                'featured' => true,
            ],
            [
                'question' => 'What is your cancellation policy?',
                'answer' => 'Cancellation policies vary by package and how close to your departure date you cancel. Generally, free cancellation is available within a certain window and applicable fees apply thereafter. Please review the specific cancellation terms shown on each package before booking.',
                'featured' => true,
            ],
            [
                'question' => 'Do you recommend purchasing travel insurance?',
                'answer' => 'Yes, we strongly recommend travel insurance to protect you against unexpected events such as medical emergencies, trip cancellations, lost baggage and flight delays. Our team can help you add comprehensive travel insurance to your booking.',
                'featured' => true,
            ],
            [
                'question' => 'What payment methods do you accept?',
                'answer' => 'We accept major credit and debit cards, bank transfers, and popular digital wallets. Secure online payment is processed through our trusted payment gateway, and you will receive a payment receipt instantly.',
                'featured' => true,
            ],
            [
                'question' => 'Do you provide visa assistance?',
                'answer' => 'Yes, we provide complete visa assistance for most international destinations including document guidance, application support and the latest visa requirements. Simply inform our team about your destination and we will guide you through the process.',
                'featured' => true,
            ],
            [
                'question' => 'What is the allowed baggage allowance?',
                'answer' => 'Baggage allowance depends on the airline included in your package. Our team will share the exact baggage limits with your itinerary after booking so you know exactly what to pack and what to expect at check-in.',
                'featured' => true,
            ],
            [
                'question' => 'Do you offer discounts for groups?',
                'answer' => 'Absolutely. We offer attractive group discounts for bookings of 5 or more travelers, as well as special corporate and family packages. Contact our team with your group size for a customized quotation.',
                'featured' => true,
            ],
            [
                'question' => 'How do refunds work if I need to cancel?',
                'answer' => 'Refunds depend on the package\'s cancellation policy and the timing of your cancellation. Eligible refunds are processed back to your original payment method within a few business days once approved by our support team.',
                'featured' => true,
            ],
        ];

        foreach ($faqs as $index => $item) {
            Faq::updateOrCreate(
                ['question' => $item['question']],
                [
                    'faqable_type' => $faqableType,
                    'faqable_id' => $faqableId,
                    'question' => $item['question'],
                    'answer' => $item['answer'],
                    'featured' => $item['featured'],
                    'status' => true,
                    'sort_order' => $index + 1,
                ]
            );
        }
    }
}
