<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            \Database\Seeders\DataVocabularySeeder::class,
            \Database\Seeders\DataGrammarSeeder::class,
            \Database\Seeders\DataKanjiSeeder::class,
            \Database\Seeders\N4KanjiSeeder::class,
            \Database\Seeders\DataExamSeeder::class,
        ]);
    }
}
