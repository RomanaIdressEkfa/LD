<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('debate_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('debate_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('side', ['pro', 'con']); // Which side did they join?
            $table->timestamps();
            
            // A user can only join a specific debate once
            $table->unique(['debate_id', 'user_id']); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('debate_participants');
    }
};
