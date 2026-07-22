<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\MainPageController;
use App\Http\Controllers\Admin\{
    NewsletterSubscriberController,
    BookingTravelerController,
    AuthenticationController,
    ContactMessageController,
    TourItineraryController,
    TourDepartureController,
    TourCategoryController,
    BlogCategoryController,
    DestinationController,
    TourIncludeController,
    TourExcludeController,
    BlogCommentController,
    TestimonialController,
    PermissionController,
    TeamMemberController,
    DashboardController,
    TourImageController,
    PaymentsController,
    SettingController,
    PartnerController,
    BlogTagController,
    CounterController,
    BookingController,
    GalleryController,
    ReviewController,
    CouponController,
    BannerController,
    TourCountroller,
    RoleController,
    UserController,
    BlogController,
    FaqsController,
    PageController
};

Route::get('/', function () {
    return view('home.index');
});

Route::get('/pages/{slug}', [MainPageController::class, 'show'])->name('pages.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticationController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticationController::class, 'store']);
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
    Route::view('/dashboard', 'admin.dashboard.index')->name('dashboard');
    Route::get('logout', [AuthenticationController::class, 'destroy'])->name('logout');
});

Route::middleware(['auth'])->group(function(){
    // Setting Custom Routes
    Route::controller(SettingController::class)->prefix('settings')->name('settings.')->group(function () {
        Route::delete('{setting}/toggle-status', 'toggleStatus')->name('bulk-delete');
    });

    // Destination Custom Routes
    Route::controller(DestinationController::class)->prefix('destinations')->name('destinations.')->group(function () {
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
        Route::delete('gallery-image/{image}', 'deleteGalleryImage')->name('gallery-image.delete');
        Route::post('states', 'getStates')->name('states');
        Route::post('cities', 'getCities')->name('cities');
    });

    // Tour Custom Routes
    Route::controller(TourCountroller::class)->prefix('tours')->name('tours.')->group(function () {
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('change-featured', 'changeFeatured')->name('change-featured');
        Route::post('change-popular', 'changePopular')->name('change-popular');
    });

    // Tour Image Custom Routes
    Route::controller(TourImageController::class)->prefix('tour_images')->name('tour_images.')->group(function () {
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    // Tour Itinerary Custom Routes
    Route::controller(TourItineraryController::class)->prefix('tour_itineraries')->name('tour_itineraries.')->group(function () {
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    // Tour Includes Custom Routes
    Route::controller(TourIncludeController::class)->prefix('tour_includes')->name('tour_includes.')->group(function () {
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    // Tour Excludes Custom Routes
    Route::controller(TourExcludeController::class)->prefix('tour_excludes')->name('tour_excludes.')->group(function () {
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    // Tour Departure Custom Routes
    Route::controller(TourDepartureController::class)->prefix('tour_departures')->name('tour_departures.')->group(function () {
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    // Faqs Custom Routes
    Route::controller(FaqsController::class)->prefix('faqs')->name('faqs.')->group(function () {
        Route::post('change-featured', 'changeFeatured')->name('change-featured');
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::get('get-models', 'getModels')->name('get-models');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    // Reviews Custom Routes
    Route::controller(ReviewController::class)->prefix('reviews')->name('reviews.')->group(function () {
        Route::post('change-featured', 'changeFeatured')->name('change-featured');
        Route::post('change-verified', 'changeVerified')->name('change-verified');
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
        Route::get('get-models', 'getModels')->name('get-models');
    });

    // Bookings Custom Routes
    Route::controller(BookingController::class)->prefix('bookings')->name('bookings.')->group(function () {
        Route::post('change-payment-status', 'changePaymentStatus')->name('change-payment-status');
        Route::post('get-departures', 'getDepartures')->name('get-departures');
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::get('get-customers', 'getCustomers')->name('get-customers');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
        Route::post('get-tours', 'getTours')->name('get-tours');
    });

    // Booking Travelers Custom Routes
    Route::controller(BookingTravelerController::class)->prefix('booking_travelers')->name('booking_travelers.')->group(function () {
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::get('get-bookings', 'getBookings')->name('get-bookings');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    // Payments Custom Routes
    Route::controller(PaymentsController::class)->prefix('payments')->name('payments.')->group(function () {
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::get('get-bookings', 'getBookings')->name('get-bookings');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    //  Coupons Custom Routes
    Route::controller(CouponController::class)->prefix('coupons')->name('coupons.')->group(function () {
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::get('generate-code', 'generateCode')->name('generate-code');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    //  News Letter Custom Routes
    Route::controller(NewsletterSubscriberController::class)->prefix('newsletter_subscribers')->name('newsletter_subscribers.')->group(function () {
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::get('generate-code', 'generateCode')->name('generate-code');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    //  Contact Messages Custom Routes
    Route::controller(ContactMessageController::class)->prefix('contact_messages')->name('contact_messages.')->group(function () {
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('change-read-status', 'changeReadStatus')->name('change-read-status');
        Route::post('change-reply-status', 'changeReplyStatus')->name('change-reply-status');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
        Route::get('get-reply', 'getReply')->name('get-reply');
        Route::post('send-reply', 'sendReply')->name('send-reply');
        Route::get('view-reply', 'viewReply')->name('view-reply');
    });

    //  Testimonials Custom Routes
    Route::controller(TestimonialController::class)->prefix('testimonials')->name('testimonials.')->group(function () {
        Route::post('change-featured', 'changeFeatured')->name('change-featured');
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    //  Blog Category Custom Routes
    Route::controller(BlogCategoryController::class)->prefix('blog_categories')->name('blog_categories.')->group(function () {
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    // Blogs Custom Routes
    Route::controller(BlogController::class)->prefix('blogs')->name('blogs.')->group(function () {
        Route::post('change-featured', 'changeFeatured')->name('change-featured');
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    // Blog Comments Custom Routes
    Route::controller(BlogCommentController::class)->prefix('blog_comments')->name('blog_comments.')->group(function () {
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    // Blog Tags Custom Routes
    Route::controller(BlogTagController::class)->prefix('blog_tags')->name('blog_tags.')->group(function () {
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    // Banners Custom Routes
    Route::controller(BannerController::class)->prefix('banners')->name('banners.')->group(function () {
        Route::post('change-featured', 'changeFeatured')->name('change-featured');
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    // Pages Custom Routes
    Route::controller(PageController::class)->prefix('pages')->name('pages.')->group(function () {
        Route::post('change-featured', 'changeFeatured')->name('change-featured');
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    // Partners Custom Routes
    Route::controller(PartnerController::class)->prefix('partners')->name('partners.')->group(function () {
        Route::post('change-featured', 'changeFeatured')->name('change-featured');
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    // Counters Custom Routes
    Route::controller(CounterController::class)->prefix('counters')->name('counters.')->group(function () {
        Route::post('change-featured', 'changeFeatured')->name('change-featured');
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    // Team Members Custom Routes
    Route::controller(TeamMemberController::class)->prefix('team_members')->name('team_members.')->group(function () {
        Route::post('change-featured', 'changeFeatured')->name('change-featured');
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    // Gallery Custom Routes
    Route::controller(GalleryController::class)->prefix('gallery')->name('gallery.')->group(function () {
        Route::post('change-featured','changeFeatured')->name('change-featured');
        Route::post('change-status','changeStatus')->name('change-status');
        Route::post('bulk-delete','bulkDelete')->name('bulk-delete');
    });

    Route::resource('newsletter_subscribers', NewsletterSubscriberController::class);
    Route::resource('booking_travelers', BookingTravelerController::class);
    Route::resource('contact_messages', ContactMessageController::class);
    Route::resource('tour_itineraries', TourItineraryController::class);
    Route::resource('tour_departures', TourDepartureController::class);
    Route::resource('tour_categories', TourCategoryController::class);
    Route::resource('blog_categories', BlogCategoryController::class);
    Route::resource('tour_includes', TourIncludeController::class);
    Route::resource('tour_excludes', TourExcludeController::class);
    Route::resource('blog_comments', BlogCommentController::class);
    Route::resource('destinations', DestinationController::class);
    Route::resource('testimonials', TestimonialController::class);
    Route::resource('team_members', TeamMemberController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('tour_images', TourImageController::class);
    Route::resource('payments', PaymentsController::class);
    Route::resource('blog_tags', BlogTagController::class);
    Route::resource('settings', SettingController::class);
    Route::resource('bookings', BookingController::class);
    Route::resource('partners', PartnerController::class);
    Route::resource('counters', CounterController::class);
    Route::resource('gallery', GalleryController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('reviews', ReviewController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('tours', TourCountroller::class);
    Route::resource('roles', RoleController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('users', UserController::class);
    Route::resource('pages', PageController::class);
    Route::resource('faqs', FaqsController::class);
});

Route::get('/states/{country}', function ($country) {
    return \App\Models\State::where('country_id', $country)->orderBy('name')->get();
});

Route::get('/cities/{state}', function ($state) {
    return \App\Models\City::where('state_id', $state)->orderBy('name')->get();
});
