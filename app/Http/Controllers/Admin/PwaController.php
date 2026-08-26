<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class PwaController extends Controller
{
    public function manifest()
    {
        $settings = Setting::first();

        $manifest = [
            "name" => $settings->site_name,
            "short_name" => $settings->site_name,
            "description" => $settings->site_tagline,
            "start_url" => "/",
            "scope" => "/",
            "display" => "standalone",
            "background_color" => "#ffffff",
            "theme_color" => $settings->theme_color ?? "#696cff",
            "icons" => [
                [
                    "src" => asset($settings->logo),
                    "sizes" => "512x512",
                    "type" => "image/png"
                ]
            ]
        ];

        return response()->json($manifest)
            ->header('Content-Type', 'application/manifest+json');
    }
}
