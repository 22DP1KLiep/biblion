<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            'Klasika',
            'Fantāzija',
            'Romāns',
            'Vēsturisks',
            'Psiholoģisks',
            'Dzeja',
            'Filozofisks',
            'Stāsti',
            'Distopija',
            'Maģiskais reālisms',
            'Krimināls',
            'Biogrāfija',
            'Ģimenes drāma',
            'Bērnu literatūra',
        ];

        foreach ($genres as $name) {
            Genre::create(['name' => $name]);
        }
    }
}
