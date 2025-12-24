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
        Schema::table('forum_groups', function (Blueprint $table) {
            if (!Schema::hasColumn('forum_groups', 'restrict_messages')) {
                $table->boolean('restrict_messages')->default(0)->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forum_groups', function (Blueprint $table) {
            if (Schema::hasColumn('forum_groups', 'restrict_messages')) {
                $table->dropColumn('restrict_messages');
            }
        });
    }
};
