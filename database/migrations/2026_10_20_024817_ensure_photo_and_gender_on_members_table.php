<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('members', 'photo')) {
            Schema::table('members', function (Blueprint $table) {
                $table->string('photo')->nullable();
            });
        }

        if (! Schema::hasColumn('members', 'gender')) {
            Schema::table('members', function (Blueprint $table) {
                $table->string('gender', 20)->nullable();
            });
        }
    }

    public function down(): void
    {
        // Kolom tidak otomatis dihapus saat rollback,
        // agar foto dan identitas anggota lama tetap aman.
    }
};
