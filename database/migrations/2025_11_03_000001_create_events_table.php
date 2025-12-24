<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->enum('type', ['Examen', 'Devoir', 'Session']);
            $table->dateTime('scheduled_at');
            $table->unsignedBigInteger('classe_id')->nullable();
            $table->unsignedBigInteger('cours_id')->nullable();
            $table->integer('rappel_minutes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};





