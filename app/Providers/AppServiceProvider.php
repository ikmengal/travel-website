<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Page;
use App\Models\Destination;
use App\Models\SocialLink;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view){
            $pages = Page::where('status',1)->orderBy('sort_order')->get();
            $footerDestinations = Destination::active()->with('country')->take(5)->get();
            $socialLinks = SocialLink::active()->footer()->ordered()->get();
            $contactPhone = Setting::get('contact_phone', '+1 (555) 123-4567');
            $contactEmail = Setting::get('contact_email', 'info@travelbook.com');
            $contactAddress = Setting::get('contact_address', '123 Travel Street, New York, NY 10001, USA');

            $view->with('pagesMenu', $pages);
            $view->with('footerDestinations', $footerDestinations);
            $view->with('footerSocialLinks', $socialLinks);
            $view->with('contactPhone', $contactPhone);
            $view->with('contactEmail', $contactEmail);
            $view->with('contactAddress', $contactAddress);
        });
    }
}
