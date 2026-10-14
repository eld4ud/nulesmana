<?php

use App\Support\Phone;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel users sudah punya role, nia, dan status, dan nomor HP anggota
 * sudah ada di tabel members. Jadi migrasi ini hanya:
 *  1. menambah kolom username di users (untuk login pakai username)
 *  2. menyeragamkan nomor HP di members ke format 08xxxxxxxxxx
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('username', 30)->nullable()->unique()->after('name');
            });
        }

        if (Schema::hasTable('members') && Schema::hasColumn('members', 'phone')) {
            DB::table('members')->whereNotNull('phone')->get()->each(function ($member) {
                $normalized = Phone::normalize($member->phone);

                if ($normalized !== $member->phone) {
                    DB::table('members')->where('id', $member->id)->update(['phone' => $normalized]);
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique(['username']);
                $table->dropColumn('username');
            });
        }
    }
};
