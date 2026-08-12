<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('lesson_categories')->cascadeOnDelete();

            $table->string('title');
            $table->text('problem');
            $table->text('impact')->nullable();
            $table->text('root_cause')->nullable();
            $table->text('solution')->nullable();
            $table->text('recommendation')->nullable();

            $table->string('severity')->nullable();       // low/medium/high — enum later if needed
            $table->string('project_phase')->nullable();
            $table->string('status')->default('draft');   // draft/submitted/under_review/approved/published/returned
            $table->string('visibility')->default('internal'); // public/internal/confidential/restricted

            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
