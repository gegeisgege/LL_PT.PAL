<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use App\Models\Project;
use App\Models\LessonCategory;
use App\Models\Tag;
use App\Models\Lesson;
use App\Models\Comment;
use App\Models\Attachment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // Clear previous dummy lessons so re-running doesn't duplicate
        Comment::truncate();
        Attachment::truncate();
        DB::table('bookmarks')->truncate();
        DB::table('lesson_tag')->truncate();
        Lesson::truncate();

        // Extra tags
        $tagNames = ['welding', 'electrical', 'safety', 'procurement', 'scheduling', 'quality-control', 'vendor', 'documentation', 'training', 'equipment'];
        foreach ($tagNames as $name) {
            Tag::firstOrCreate(['name' => $name]);
        }

        // Extra projects
        $departments = Department::all();
        $projectNames = [
            ['name' => 'Hull Fabrication Unit 4', 'code' => 'HFU4'],
            ['name' => 'Combat System Upgrade', 'code' => 'CSU'],
            ['name' => 'Dry Dock Renovation', 'code' => 'DDR'],
            ['name' => 'Vendor Onboarding Platform', 'code' => 'VOP'],
        ];
        foreach ($projectNames as $p) {
            Project::firstOrCreate(
                ['code' => $p['code']],
                ['name' => $p['name'], 'department_id' => $departments->random()->id]
            );
        }

        // Extra users
        $names = ['Budi Santoso', 'Siti Rahayu', 'Agus Wijaya', 'Dewi Lestari', 'Hendra Kusuma'];
        $roles = ['employee', 'employee', 'employee', 'reviewer', 'employee'];
        foreach ($names as $i => $name) {
            User::firstOrCreate(
                ['email' => strtolower(str_replace(' ', '.', $name)) . '@ptpal.test'],
                [
                    'name' => $name,
                    'password' => Hash::make('password'),
                    'department_id' => $departments->random()->id,
                    'role' => $roles[$i],
                ]
            );
        }

        $users = User::all();
        $projects = Project::all();
        $categories = LessonCategory::all();
        $tags = Tag::all();

        $statuses = ['published', 'published', 'published', 'published', 'submitted', 'draft', 'returned'];

        $problems = [
            'Welding seam failed inspection on first pass',
            'Vendor delivered incorrect cable specification',
            'Crane scheduling conflict delayed hull section lift',
            'Safety harness inspection log incomplete before task',
            'Software update broke integration test suite',
            'Procurement order missing required certification docs',
            'Training session did not cover updated safety procedure',
            'Dry dock pump failure during flooding sequence',
            'Combat system calibration drifted after transport',
            'Documentation mismatch between drawing revisions',
            'Equipment left uncalibrated after maintenance window',
            'Contractor unfamiliar with updated access protocol',
            'Paint application failed humidity threshold check',
            'Generator load test exceeded expected tolerance',
            'Steel plate batch failed material certification',
            'Radar system interference from nearby equipment',
            'Fuel line pressure test flagged a leak',
            'Ballast tank sensor gave inconsistent readings',
            'Subcontractor missed mandatory safety briefing',
            'Propeller shaft alignment off tolerance after installation',
            'Fire suppression system false-triggered during testing',
            'Crane operator certification expired before scheduled lift',
            'Insulation material substitution not properly documented',
            'Hydraulic system pressure drop found during sea trial prep',
            'Navigation software version mismatch across systems',
            'Scaffolding inspection missed before high-risk task',
            'Corrosion found on hull section during routine survey',
            'Electrical panel labeling inconsistent with as-built drawings',
            'Weld procedure specification not updated for new alloy',
            'Access control badge system failed during shift change',
        ];

        foreach ($problems as $i => $problem) {
            $status = $statuses[array_rand($statuses)];
            $author = $users->random();
            $project = $projects->random();

            $lesson = Lesson::create([
                'project_id' => $project->id,
                'department_id' => $project->department_id,
                'author_id' => $author->id,
                'category_id' => $categories->random()->id,
                'title' => $problem,
                'problem' => $problem . '. Discovered during routine checks on ' . $project->name . '.',
                'impact' => fake()->sentence(12),
                'root_cause' => fake()->sentence(10),
                'solution' => fake()->sentence(14),
                'recommendation' => fake()->sentence(10),
                'severity' => fake()->randomElement(['low', 'medium', 'high']),
                'project_phase' => fake()->randomElement(['Planning', 'Fabrication', 'Integration', 'Testing', 'Commissioning']),
                'status' => $status,
                'visibility' => 'internal',
                'views_count' => $status === 'published' ? rand(3, 120) : 0,
                'published_at' => $status === 'published' ? now()->subDays(rand(1, 60)) : null,
            ]);

            $lesson->tags()->attach($tags->random(rand(1, 3))->pluck('id'));

            // Some comments on published lessons
            if ($status === 'published' && rand(0, 1)) {
                $lesson->comments()->create([
                    'user_id' => $users->random()->id,
                    'body' => fake()->sentence(rand(6, 15)),
                ]);
            }

            // Some bookmarks on published lessons
            if ($status === 'published' && rand(0, 1)) {
                $bookmarker = $users->random();
                $bookmarker->bookmarks()->syncWithoutDetaching([$lesson->id]);
            }
        }
    }
}