<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LessonCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\LessonCategory::insert([
            ['name' => 'Network', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Integration', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Testing', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
