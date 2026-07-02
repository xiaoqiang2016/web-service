<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Current languages:\n";
    $languages = \App\Models\Language::all();
    foreach ($languages as $lang) {
        echo "- " . $lang->locale . ": " . $lang->name . " (default: " . ($lang->is_default ? 'yes' : 'no') . ", active: " . ($lang->is_active ? 'yes' : 'no') . ")\n";
    }
    
    if (\App\Models\Language::where('locale', 'vn')->exists()) {
        echo "\nVietnamese language already exists!\n";
    } else {
        echo "\nAdding Vietnamese language...\n";
        
        \App\Models\Language::create([
            'locale' => 'vn',
            'name' => 'Tiếng Việt',
            'is_default' => 0,
            'is_active' => 1,
            'sort_order' => 3,
        ]);
        
        echo "Vietnamese language added successfully!\n";
    }
    
    echo "\nUpdated languages:\n";
    $languages = \App\Models\Language::all();
    foreach ($languages as $lang) {
        echo "- " . $lang->locale . ": " . $lang->name . " (default: " . ($lang->is_default ? 'yes' : 'no') . ", active: " . ($lang->is_active ? 'yes' : 'no') . ")\n";
    }
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
