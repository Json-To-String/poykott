<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alternatives', function (Blueprint $table): void {
            $table->json('details')->nullable()->after('notes');
            $table->integer('total_score')->nullable()->after('details');
        });
    }

    public function down(): void
    {
        Schema::table('alternatives', function (Blueprint $table): void {
            $table->dropColumn(['details', 'total_score']);
        });
    }
};
