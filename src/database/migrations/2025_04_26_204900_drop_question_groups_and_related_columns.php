<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('survey_question', function (Blueprint $table) {
            $table->dropColumn('group');
            $table->dropForeign(['question_group_id']);
            $table->dropColumn('question_group_id');
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['question_group_id']);
            $table->dropColumn('question_group_id');
        });

        Schema::dropIfExists('question_groups');
    }

    public function down(): void
    {
        Schema::create('question_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->foreignId('question_group_id')->nullable()->constrained()->nullOnDelete();
        });

        Schema::table('survey_question', function (Blueprint $table) {
            $table->string('group')->nullable();
            $table->foreignId('question_group_id')->nullable()->constrained()->nullOnDelete();
        });
    }
};
