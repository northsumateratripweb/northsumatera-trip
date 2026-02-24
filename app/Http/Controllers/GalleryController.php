<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::query()->where('is_active', true)->orderBy('order');

        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        $galleries = $query->get();
        $categories = Gallery::query()
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->toArray();

        return view('gallery', compact('galleries', 'categories', 'category'));
    }
}
