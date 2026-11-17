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
        Schema::create('coffee_questions', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->text('question');
            $table->string('input_type', 50)->default('radio');
            $table->json('options');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('coffee_rules', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('target_menu_id')
                ->constrained('menus')
                ->restrictOnDelete();
            $table->text('recommended_reason')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('priority')->default(0);
            $table->timestamps();
        });

        Schema::create('coffee_rule_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rule_id')
                ->constrained('coffee_rules')
                ->cascadeOnDelete();
            $table->string('question_code', 50)->index();
            $table->string('operator', 20)->default('=');
            $table->string('expected_value');
            $table->string('condition_group', 20)->default('AND');
            $table->timestamps();
        });

        Schema::create('coffee_consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('session_id', 100)->nullable()->index();
            $table->json('answers');
            $table->json('result_summary')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coffee_consultations');
        Schema::dropIfExists('coffee_rule_conditions');
        Schema::dropIfExists('coffee_rules');
        Schema::dropIfExists('coffee_questions');
    }
};
