<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@test.com',
    'password' => Illuminate\Support\Facades\Hash::make('password'),
    'role' => 'admin'
]);
echo "User created\n";
