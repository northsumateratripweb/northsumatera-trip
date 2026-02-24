{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Static Pages -->
    <url>
        <loc>{{ route('home') }}</loc>
        <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>{{ route('packages') }}</loc>
        <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('rental') }}</loc>
        <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('blog.index') }}</loc>
        <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>{{ route('gallery.index') }}</loc>
        <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ route('contact') }}</loc>
        <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>

    <!-- Static Pages (Terms, Privacy, etc.) -->
    @foreach($pages as $page)
    <url>
        <loc>{{ route('page.show', $page->slug) }}</loc>
        <lastmod>{{ $page->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.4</priority>
    </url>
    @endforeach

    <!-- Tour Packages -->
    @foreach($tours as $tour)
    <url>
        <loc>{{ route('tour.show', $tour->slug) }}</loc>
        <lastmod>{{ $tour->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    @endforeach

    <!-- Cars -->
    @foreach($cars as $car)
    <url>
        <loc>{{ route('car.show', $car->id) }}</loc>
        <lastmod>{{ $car->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach

    <!-- Blog Posts -->
    @foreach($posts as $post)
    <url>
        <loc>{{ route('post.show', $post->slug) }}</loc>
        <lastmod>{{ $post->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach
</urlset>
