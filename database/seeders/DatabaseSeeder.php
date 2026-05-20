<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Province;
use App\Models\Daerah;
use App\Models\Organization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Provinces
        $jabar = Province::create([
            'name' => 'Jawa Barat',
            'slug' => 'jawa-barat',
            'image' => 'https://images.unsplash.com/photo-1596700778735-a6e5340eb93b?auto=format&fit=crop&w=800&q=80',
        ]);

        $dki = Province::create([
            'name' => 'DKI Jakarta',
            'slug' => 'dki-jakarta',
            'image' => 'https://images.unsplash.com/photo-1555652736-e92021d28a10?auto=format&fit=crop&w=800&q=80',
        ]);

        $jateng = Province::create([
            'name' => 'Jawa Tengah',
            'slug' => 'jawa-tengah',
            'image' => 'https://images.unsplash.com/photo-1627931326466-23eb1b78297b?auto=format&fit=crop&w=800&q=80',
        ]);

        // 2. Seed Daerahs (Districts)
        $bandung = Daerah::create([
            'province_id' => $jabar->id,
            'name' => 'Kota Bandung',
            'slug' => 'kota-bandung',
            'image' => 'https://images.unsplash.com/photo-1588528416453-623b185cf156?auto=format&fit=crop&w=800&q=80',
            'website' => 'https://bandung.baznas.go.id',
            'instagram' => '@baznas.kotabandung',
            'email' => 'baznas.kotabandung@baznas.go.id',
        ]);

        $bogor = Daerah::create([
            'province_id' => $jabar->id,
            'name' => 'Kabupaten Bogor',
            'slug' => 'kabupaten-bogor',
            'image' => 'https://images.unsplash.com/photo-1593361546950-c8e4d3c34f07?auto=format&fit=crop&w=800&q=80',
            'website' => 'https://kabupatenbogor.baznas.go.id',
            'instagram' => '@baznas_kabbogor',
            'email' => 'baznas.kab.bogor@baznas.go.id',
        ]);

        $jakpus = Daerah::create([
            'province_id' => $dki->id,
            'name' => 'Jakarta Pusat',
            'slug' => 'jakarta-pusat',
            'image' => 'https://images.unsplash.com/photo-1506469717960-433cd8b6028d?auto=format&fit=crop&w=800&q=80',
            'website' => 'https://jakarta.baznas.go.id',
            'instagram' => '@baznasbazis.jakpus',
            'email' => 'baznas.jakpus@baznas.go.id',
        ]);

        // 3. Seed Organizations
        $orgBandung = Organization::create([
            'name' => 'BAZNAS Kota Bandung',
            'region' => 'Bandung',
            'description' => 'Badan Amil Zakat Nasional Kota Bandung, melayani pengelolaan zakat wilayah Bandung.',
            'logo' => 'https://bandung.baznas.go.id/logo.png',
            'website' => 'https://bandung.baznas.go.id',
            'instagram' => '@baznas.kotabandung',
            'email' => 'baznas.kotabandung@baznas.go.id',
            'status' => 'active',
            'province_id' => $jabar->id,
            'daerah_id' => $bandung->id,
        ]);

        $orgBogor = Organization::create([
            'name' => 'BAZNAS Kabupaten Bogor',
            'region' => 'Bogor',
            'description' => 'Badan Amil Zakat Nasional Kabupaten Bogor, melayani amil zakat regional Bogor.',
            'logo' => 'https://kabupatenbogor.baznas.go.id/logo.png',
            'website' => 'https://kabupatenbogor.baznas.go.id',
            'instagram' => '@baznas_kabbogor',
            'email' => 'baznas.kab.bogor@baznas.go.id',
            'status' => 'active',
            'province_id' => $jabar->id,
            'daerah_id' => $bogor->id,
        ]);

        $orgJakpus = Organization::create([
            'name' => 'BAZNAS BAZIS Jakarta Pusat',
            'region' => 'Jakarta Pusat',
            'description' => 'Lembaga amil zakat resmi untuk wilayah Kota Administrasi Jakarta Pusat.',
            'logo' => 'https://jakarta.baznas.go.id/logo.png',
            'website' => 'https://jakarta.baznas.go.id',
            'instagram' => '@baznasbazis.jakpus',
            'email' => 'baznas.jakpus@baznas.go.id',
            'status' => 'active',
            'province_id' => $dki->id,
            'daerah_id' => $jakpus->id,
        ]);

        // 4. Seed Users (Admin & Daerah)
        // Super Admin / Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'organization_id' => null,
        ]);

        // Daerah user linked to BAZNAS Kota Bandung
        User::create([
            'name' => 'Petugas Bandung',
            'email' => 'daerah@test.com',
            'password' => Hash::make('password'),
            'role' => 'daerah',
            'organization_id' => $orgBandung->id,
        ]);

        // Standard user for fallback testing
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => 'daerah',
            'organization_id' => null,
        ]);
    }
}
