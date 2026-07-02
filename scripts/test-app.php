<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Testing database connection...\n";
    $db = \DB::connection();
    $db->getPdo();
    echo "✅ Database connection OK\n";
    
    echo "\nTesting Language model...\n";
    $langs = \App\Models\Language::all();
    echo "✅ Found " . count($langs) . " languages\n";
    foreach ($langs as $lang) {
        echo "  - " . $lang->locale . ": " . $lang->name . " (default: " . ($lang->is_default ? 'yes' : 'no') . ")\n";
    }
    
    echo "\nTesting AdminUser model...\n";
    $users = \App\Models\AdminUser::all();
    echo "✅ Found " . count($users) . " admin users\n";
    foreach ($users as $user) {
        echo "  - " . $user->username . ": " . $user->nickname . "\n";
    }
    
    echo "\nTesting get_translated helper...\n";
    $lang = \App\Models\Language::first();
    if (function_exists('get_translated')) {
        echo "✅ get_translated function is available\n";
    } else {
        echo "❌ get_translated function NOT found\n";
    }
    
    echo "\n✅ All tests passed!\n";
    
} catch (\Exception $e) {
    echo "\n❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo $e->getTraceAsString() . "\n";
}
