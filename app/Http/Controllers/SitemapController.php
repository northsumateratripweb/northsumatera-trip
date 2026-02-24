<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Post;
use App\Models\Car;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $tours = Tour::all();
        $posts = Post::where('is_published', true)->get();
        $cars = Car::where('is_available', true)->get();
        $pages = \App\Models\StaticPage::where('is_published', true)->get();

        return response()->view('sitemap', [
            'tours' => $tours,
            'posts' => $posts,
            'cars' => $cars,
            'pages' => $pages,
        ])->header('Content-Type', 'text/xml');
    }
}
