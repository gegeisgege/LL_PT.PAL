<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Department::insert([
            ['name' => 'Information Technology', 'code' => 'IT', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Engineering', 'code' => 'ENG', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Quality Assurance', 'code' => 'QA', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
