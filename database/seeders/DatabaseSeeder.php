<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $adminEmail = env('ADMIN_EMAIL', 'admin@acryluxe.local');

        User::updateOrCreate([
            'email' => $adminEmail,
        ], [
            'name' => 'Acryluxe Admin',
            'password' => env('ADMIN_PASSWORD', 'admin123456'),
            'is_admin' => true,
        ]);

        $this->call([
            ProductSeeder::class,
        ]);
    }
}
