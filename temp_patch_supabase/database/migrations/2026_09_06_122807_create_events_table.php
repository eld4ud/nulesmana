<?php

use Illuminate\Database\Migrations\Migration;

/**
 * Migrasi lama keliru membuat / menghapus tabel `news`.
 * `news` sudah ditangani oleh create_news_table.php.
 *
 * Sengaja tidak membuat tabel `events` karena struktur tabel tersebut
 * belum dapat dipastikan dari migrasi asli. Jika fitur events diperlukan,
 * buat migrasi BARU berdasarkan kebutuhan model dan controller.
 */
return new class extends Migration
{
    public function up(): void
    {
        // No-op: jangan mengubah tabel news.
    }

    public function down(): void
    {
        // No-op: jangan menghapus tabel news milik migrasi lain.
    }
};
