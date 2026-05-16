<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('challenges', function (Blueprint $table) {
            if (! Schema::hasColumn('challenges', 'min_points')) {
                $table->integer('min_points')->default(100)->after('points');
            }

            if (! Schema::hasColumn('challenges', 'decay_per_solve')) {
                $table->integer('decay_per_solve')->default(20)->after('min_points');
            }
        });
    }

    public function down(): void
    {
        Schema::table('challenges', function (Blueprint $table) {
            if (Schema::hasColumn('challenges', 'decay_per_solve')) {
                $table->dropColumn('decay_per_solve');
            }

            if (Schema::hasColumn('challenges', 'min_points')) {
                $table->dropColumn('min_points');
            }
        });
    }
};