<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $itId = \App\Models\Department::where('code', 'IT')->value('id');

        \App\Models\Project::insert([
            ['name' => 'Project X', 'code' => 'PRJX', 'department_id' => $itId, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
