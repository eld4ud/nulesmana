<?php

namespace App\Support;

use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Str;
use RuntimeException;

final class NiaGenerator
{
    /**
     * Generate a candidate NIA. Uniqueness must also be enforced by database
     * constraints before using this for production enrollment.
     */
    public static function next(): string
    {
        for ($attempt = 0; $attempt < 20; $attempt++) {
            $nia = 'LSM-' . now()->format('y') . '-' . Str::upper(Str::random(12));

            if (! User::where('nia', $nia)->exists()
                && ! Member::where('nia', $nia)->exists()) {
                return $nia;
            }
        }

        throw new RuntimeException('Gagal menghasilkan NIA unik. Coba lagi.');
    }
}
