<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE `seo_analyze` MODIFY `status` ENUM('mulai analisa','daftar kompetitor telah dibuat','mulai analisa ke 2','generate to pdf','pdf generated') DEFAULT 'mulai analisa'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE `seo_analyze` MODIFY `status` ENUM('mulai analisa','daftar kompetitor telah dibuat','mulai analisa ke 2','generate to pdf') DEFAULT 'mulai analisa'");
    }
};

