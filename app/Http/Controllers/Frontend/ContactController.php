<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create($validated);

        return redirect()->route('contact')->with('success', 'Your message has been sent successfully! We will get back to you soon.');
    }

    public function subscribeNewsletter(Request $request)
    {
        $request->validate([
            'email' => 'required|email:rfc,dns|max:255',
        ]);

        $exists = Newsletter::where('email', strtolower(trim($request->email)))->exists();

        if ($exists) {
            return back()->with('info', 'You are already subscribed to our newsletter!');
        }

        Newsletter::create([
            'email' => strtolower(trim($request->email)),
            'token' => Str::random(64),
            'status' => true,
            'subscribed_at' => now(),
            'verified_at' => now(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Thank you for subscribing to our newsletter!');
    }
}
