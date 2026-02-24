<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Clear view cache to ensure we see the latest error
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    
    // Attempt to render
    echo "RENDERING...\n";
    $view = view('welcome');
    echo $view->render();
    echo "\nRENDER SUCCESSFUL\n";
} catch (\Throwable $e) {
    echo "\n!!! ERROR CAUGHT !!!\n";
    echo "MESSAGE: " . $e->getMessage() . "\n";
    echo "FILE: " . $e->getFile() . "\n";
    echo "LINE: " . $e->getLine() . "\n";
    
    // If it's a compiler error, it might be in the compiled file.
    // We want to know which Blade file caused it.
    if ($e instanceof \Illuminate\View\ViewException) {
        echo "VIEW EXCEPTION DETAILS:\n";
    }
}
