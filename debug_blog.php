<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use App\Models\Post;
try {
    $post = Post::first();
    if (!$post) { echo "No posts found\n"; exit; }
    echo "Rendering post: " . $post->title . "\n";
    echo view('post-detail', compact('post'))->render();
    echo "\nSuccess!\n";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "FILE: " . $e->getFile() . "\n";
    echo "LINE: " . $e->getLine() . "\n";
    if ($e->getPrevious()) {
        echo "PREVIOUS: " . $e->getPrevious()->getMessage() . "\n";
    }
}
