<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class RobotsController extends Controller
{
    public function index(): Response
    {
        $content = "User-agent: *\n";
        $content .= "Disallow: /admin\n";
        $content .= "Disallow: /login\n";
        $content .= "Disallow: /register\n";
        $content .= "Disallow: /password/reset\n\n";
        $content .= "Sitemap: " . url('/sitemap.xml') . "\n";

        return response($content)->header('Content-Type', 'text/plain');
    }
}
