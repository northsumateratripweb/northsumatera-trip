<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User
        User::updateOrCreate(
            ['email' => 'admin@northsumateratrip.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('Admin123!'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Translations
        $this->call(TranslationSeeder::class);

        // 3. Main Content
        $this->call(ContentSeeder::class);

        // 4. CSV Import (January Trip)
        $this->call(CsvImportSeeder::class);
    }
}
