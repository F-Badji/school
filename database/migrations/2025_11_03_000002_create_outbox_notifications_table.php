<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('outbox_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->enum('audience', ['tous','apprenants','formateurs','utilisateur']);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('status')->default('enregistré');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('outbox_notifications');
    }
};





