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
         Schema::create('arguments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('debate_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->enum('side', ['pro', 'con']);
        $table->text('body');
        $table->foreignId('parent_id')->nullable()->constrained('arguments')->onDelete('cascade');
        $table->enum('reply_type', ['agree', 'disagree', 'neutral'])->default('neutral');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arguments');
    }
};
