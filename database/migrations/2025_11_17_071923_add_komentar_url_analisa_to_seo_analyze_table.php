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
        Schema::table('seo_analyze', function (Blueprint $table) {
            $table->text('komentar_url_analisa')->nullable()->after('url_analisa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seo_analyze', function (Blueprint $table) {
            $table->dropColumn('komentar_url_analisa');
        });
    }
};
