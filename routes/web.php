<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/migrate-seed', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true]);
        return 'Migration and seeding finished successfully!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});
