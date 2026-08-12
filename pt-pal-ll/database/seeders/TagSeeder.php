<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Tag::insert([
            ['name' => 'network', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'integration', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'configuration', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
