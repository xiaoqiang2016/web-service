<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Language;
use App\Models\AdminRole;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Hash;

echo "Seeding initial data...\n";

if (!Language::where('locale', 'en')->exists()) {
    Language::create([
        'locale' => 'en',
        'name' => 'English',
        'is_default' => 1,
        'is_active' => 1,
        'sort_order' => 1,
    ]);
    echo "Created English language\n";
}

if (!Language::where('locale', 'zh')->exists()) {
    Language::create([
        'locale' => 'zh',
        'name' => 'ZH',
        'is_default' => 0,
        'is_active' => 1,
        'sort_order' => 2,
    ]);
    echo "Created Chinese language\n";
}

if (!AdminRole::where('role_name', 'super_admin')->exists()) {
    AdminRole::create([
        'role_name' => 'super_admin',
        'description' => 'Super Administrator',
        'permissions' => json_encode(['*']),
        'status' => 1,
    ]);
    echo "Created super_admin role\n";
}

if (!AdminUser::where('username', 'admin')->exists()) {
    AdminUser::create([
        'username' => 'admin',
        'password' => Hash::make('admin123'),
        'nickname' => 'Super Admin',
        'email' => 'admin@enterprisecms.com',
        'role_id' => 1,
        'status' => 1,
    ]);
    echo "Created admin user (username: admin, password: admin123)\n";
}

echo "Data seeding completed!\n";
