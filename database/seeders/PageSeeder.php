<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about',
                'page_type' => 'about',
                'short_description' => 'TravelBook is your trusted partner for unforgettable travel experiences, offering tours, hotels and flights in one place.',
                'description' => '<p>Welcome to TravelBook, a full-service travel platform dedicated to crafting seamless and memorable journeys for travelers around the world. From breathtaking mountain valleys to sun-soaked beaches and vibrant city escapes, we bring the world closer to you.</p><p>Our passionate team of travel experts handpicks every destination, hotel and experience to ensure the highest quality and value. Whether you are planning a romantic honeymoon, an adventurous family trip or a relaxing getaway, we are here to make it happen.</p><p>With transparent pricing, 24/7 support and a customer-first approach, we have earned the trust of thousands of happy travelers. Your dream vacation is our mission.</p>',
                'meta_keywords' => 'about us, travel company, travel agency, tours, holidays',
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact',
                'page_type' => 'contact',
                'short_description' => 'Get in touch with our friendly support team for any questions about tours, bookings or destinations.',
                'description' => '<p>We would love to hear from you! Whether you have a question about a specific tour, need help with an existing booking or simply want travel advice, our team is ready to assist.</p><p>Reach out to us through our contact form, email or phone, and we will respond as quickly as possible. Your satisfaction is our top priority.</p><p>Visit our office during business hours or drop us a message anytime — we are here to help you plan the perfect journey.</p>',
                'meta_keywords' => 'contact us, support, travel help, customer service',
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'page_type' => 'privacy-policy',
                'short_description' => 'Learn how TravelBook collects, uses and protects your personal information.',
                'description' => '<p>Your privacy matters to us. This Privacy Policy explains what information we collect, how we use it and the choices you have regarding your personal data when you use our website and services.</p><p>We collect basic personal details such as your name, contact information and booking preferences to provide and improve our services, process payments and communicate with you about your travel plans.</p><p>We never sell your personal information to third parties. We may share necessary details with trusted partners such as airlines, hotels and payment processors solely to complete your bookings.</p><p>By using our platform, you consent to the practices described in this policy. If you have any questions, please contact our support team.</p>',
                'meta_keywords' => 'privacy policy, data protection, personal information',
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms-conditions',
                'page_type' => 'terms-conditions',
                'short_description' => 'Review the rules and terms governing the use of TravelBook and our travel services.',
                'description' => '<p>These Terms and Conditions govern your use of the TravelBook website and all services we offer, including tour bookings, hotel reservations and flight arrangements.</p><p>By accessing and using our platform, you agree to comply with these terms. All bookings are subject to availability, and prices are confirmed at the time of reservation.</p><p>We reserve the right to update these terms at any time, and your continued use of the service constitutes acceptance of any changes. Please review this page periodically.</p><p>For any questions regarding these terms, please reach out to our support team before making a booking.</p>',
                'meta_keywords' => 'terms and conditions, terms of service, booking terms',
            ],
            [
                'title' => 'Refund Policy',
                'slug' => 'refund-policy',
                'page_type' => 'refund-policy',
                'short_description' => 'Understand our refund procedures for canceled or modified bookings.',
                'description' => '<p>Our Refund Policy outlines how refunds are handled when a booking is canceled or requires modification. We aim to keep the process simple and transparent for all travelers.</p><p>Refund eligibility and amounts depend on the package, the timing of your cancellation and the policies of our suppliers such as airlines and hotels.</p><p>Once a refund is approved, it is processed back to your original payment method within a reasonable number of business days. Please note that some processing fees may apply.</p><p>If you believe you are eligible for a refund, contact our support team with your booking details and we will assist you promptly.</p>',
                'meta_keywords' => 'refund policy, refunds, cancellations',
            ],
            [
                'title' => 'Cancellation Policy',
                'slug' => 'cancellation-policy',
                'page_type' => 'cancellation-policy',
                'short_description' => 'Find out how and when you can cancel a booking and what charges may apply.',
                'description' => '<p>We understand that plans can change. Our Cancellation Policy explains the conditions under which you can cancel your booking and any charges that may apply.</p><p>Cancellation windows and fees vary by package type. Generally, the closer you cancel to your departure date, the higher the applicable cancellation charge.</p><p>Some packages offer free cancellation within an initial period, giving you added flexibility. Please review the specific terms shown on your chosen package before confirming.</p><p>To cancel or modify a booking, contact our support team as soon as possible with your booking reference for a smooth resolution.</p>',
                'meta_keywords' => 'cancellation policy, cancel booking, cancellation charges',
            ],
            [
                'title' => 'Cookie Policy',
                'slug' => 'cookie-policy',
                'page_type' => 'cookie-policy',
                'short_description' => 'Learn about the cookies we use to enhance your browsing and booking experience.',
                'description' => '<p>This Cookie Policy explains how TravelBook uses cookies and similar technologies to improve your experience on our website.</p><p>Cookies are small text files stored on your device that help us remember your preferences, understand how you use our site and deliver relevant content and offers.</p><p>We use essential cookies for site functionality, analytics cookies to measure performance, and marketing cookies to show you relevant travel deals. You can control cookie settings through your browser at any time.</p><p>By continuing to browse our website, you consent to the use of cookies as described in this policy.</p>',
                'meta_keywords' => 'cookie policy, cookies, browsing data',
            ],
            [
                'title' => 'Why Choose Us',
                'slug' => 'why-choose-us',
                'page_type' => 'why-choose-us',
                'short_description' => 'Discover the many reasons thousands of travelers trust TravelBook for their dream vacations.',
                'description' => '<p>Choosing the right travel partner makes all the difference, and TravelBook is committed to delivering exceptional value and service at every step of your journey.</p><p>We offer handpicked destinations, transparent pricing with no hidden fees, and expert travel consultants available around the clock to support you before, during and after your trip.</p><p>Our partnerships with trusted airlines, hotels and local operators ensure quality stays and smooth experiences wherever you travel in the world.</p><p>With thousands of happy travelers and a customer-first philosophy, choosing TravelBook is choosing peace of mind for your next adventure.</p>',
                'meta_keywords' => 'why choose us, travel benefits, trusted travel partner',
            ],
        ];

        foreach ($pages as $index => $item) {
            Page::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'title' => $item['title'],
                    'slug' => $item['slug'],
                    'page_type' => $item['page_type'],
                    'featured_image' => null,
                    'thumbnail_image' => null,
                    'short_description' => $item['short_description'],
                    'description' => $item['description'],
                    'meta_title' => $item['title'].' | TravelBook',
                    'meta_description' => $item['short_description'],
                    'meta_keywords' => $item['meta_keywords'],
                    'sort_order' => $index + 1,
                    'featured' => true,
                    'status' => true,
                ]
            );
        }
    }
}
