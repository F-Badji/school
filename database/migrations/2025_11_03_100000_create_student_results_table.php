<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('student_results', function (Blueprint $table) {
            $table->id();
            $table->string('matricule')->index();
            $table->string('nom');
            $table->string('prenom');
            $table->date('annee_naissance')->nullable();
            $table->string('classe')->nullable();
            $table->decimal('devoir', 5, 2)->nullable();
            $table->decimal('examen', 5, 2)->nullable();
            $table->decimal('quiz', 5, 2)->nullable();
            $table->decimal('moyenne', 5, 2)->nullable();
            $table->boolean('redoubler')->default(false);
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_results');
    }
};





