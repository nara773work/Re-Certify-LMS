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
        Schema::create('question_threads', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('user_id')->constrained('users')
                    ->OnDeleteSetNull()->nullable();
            $table->foreignUlid('certification_id')->constrained('certifications')
                    ->deleteOn('cascade');
            $table->string('title');
            $table->text('body',2000);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_threads');
    }
};
