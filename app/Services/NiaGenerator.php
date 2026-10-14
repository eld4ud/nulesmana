<?php

namespace App\Services;

use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\DB;

/**
 * Format NIA: LSM-26-0001
 *  - LSM  : kode Ranting Lesmana
 *  - 26   : dua digit tahun daftar
 *  - 0001 : urutan 4 digit, mulai dari 0001 setiap tahun
 *
 * Panggil di dalam proses pendaftaran. Kolom users.nia punya unique index,
 * jadi kalau dua pendaftar masuk bersamaan, salah satunya gagal dan bisa diulang.
 */
class NiaGenerator
{
    public const CODE = 'LSM';

    public static function next(?CarbonInterface $date = null): string
    {
        $year   = ($date ?? now())->format('y');
        $prefix = self::CODE.'-'.$year.'-';

        return DB::transaction(function () use ($prefix) {
            $last = User::query()
                ->where('nia', 'like', $prefix.'%')
                ->lockForUpdate()
                ->orderByDesc('nia')
                ->value('nia');

            $number = $last ? ((int) substr($last, -4)) + 1 : 1;

            return $prefix.str_pad((string) $number, 4, '0', STR_PAD_LEFT);
        });
    }

    public static function isValid(string $value): bool
    {
        return (bool) preg_match('/^'.self::CODE.'-\d{2}-\d{4}$/', $value);
    }
}
