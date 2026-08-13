<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Lesson;
use App\Models\Project;
use App\Models\Department;
use App\Models\LessonCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LessonAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function makeLesson(User $author, string $status = 'draft'): Lesson
    {
        $department = Department::create(['name' => 'Test Dept', 'code' => 'TD']);
        $project = Project::create(['name' => 'Test Project', 'code' => 'TP', 'department_id' => $department->id]);
        $category = LessonCategory::create(['name' => 'Test Category']);

        return Lesson::create([
            'project_id' => $project->id,
            'department_id' => $department->id,
            'author_id' => $author->id,
            'category_id' => $category->id,
            'title' => 'Test Lesson',
            'problem' => 'Test problem',
            'status' => $status,
            'visibility' => 'internal',
        ]);
    }

    public function test_employee_cannot_edit_another_users_lesson(): void
    {
        $author = User::factory()->create(['role' => 'employee']);
        $otherUser = User::factory()->create(['role' => 'employee']);
        $lesson = $this->makeLesson($author, 'draft');

        $this->assertFalse($otherUser->can('update', $lesson));
    }

    public function test_employee_cannot_approve_a_lesson(): void
    {
        $employee = User::factory()->create(['role' => 'employee']);
        $author = User::factory()->create(['role' => 'employee']);
        $lesson = $this->makeLesson($author, 'submitted');

        $this->assertFalse($employee->can('approve', $lesson));
    }

    public function test_reviewer_cannot_approve_a_draft_lesson(): void
    {
        $reviewer = User::factory()->create(['role' => 'reviewer']);
        $author = User::factory()->create(['role' => 'employee']);
        $lesson = $this->makeLesson($author, 'draft');

        $this->assertFalse($reviewer->can('approve', $lesson));
    }

    public function test_author_cannot_edit_own_lesson_after_it_is_submitted(): void
    {
        $author = User::factory()->create(['role' => 'employee']);
        $lesson = $this->makeLesson($author, 'submitted');

        $this->assertFalse($author->can('update', $lesson));
    }

    public function test_unauthenticated_user_cannot_access_lessons_index(): void
    {
        $response = $this->get('/lessons');

        $response->assertRedirect('/login');
    }

    public function test_unauthenticated_user_cannot_access_a_lesson(): void
    {
        $author = User::factory()->create();
        $lesson = $this->makeLesson($author, 'published');

        $response = $this->get("/lessons/{$lesson->id}");

        $response->assertRedirect('/login');
    }

    public function test_reviewer_can_approve_a_submitted_lesson(): void
    {
        $reviewer = User::factory()->create(['role' => 'reviewer']);
        $author = User::factory()->create(['role' => 'employee']);
        $lesson = $this->makeLesson($author, 'submitted');

        $this->assertTrue($reviewer->can('approve', $lesson));
    }

    public function test_author_can_edit_own_draft_lesson(): void
    {
        $author = User::factory()->create(['role' => 'employee']);
        $lesson = $this->makeLesson($author, 'draft');

        $this->assertTrue($author->can('update', $lesson));
    }
}