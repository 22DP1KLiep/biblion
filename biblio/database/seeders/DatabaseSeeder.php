<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ja vēlies saglabāt šo user seeder, vari atstāt
        User::factory()->create([
            'name' => 'Test User',
            'username' => 'testuser', // ← ✅ ŠEIT!
            'email' => 'test@example.com',
        ]);

        // ✅ Šeit pievieno savus seederus
        $this->call([
            GenreSeeder::class,
            BooksTableSeeder::class,
        ]);
    }
}
