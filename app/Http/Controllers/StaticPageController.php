<?php

namespace App\Http\Controllers;

use App\Models\StaticPage;

class StaticPageController extends Controller
{
    public function show(string $slug)
    {
        $page = StaticPage::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('static-page', compact('page'));
    }
}

