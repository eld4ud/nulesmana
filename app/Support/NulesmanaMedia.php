<?php

namespace App\Support;

use App\Models\Member;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Centralise storage choices. Local mode keeps Laragon behaviour unchanged.
 * Supabase mode uses public news-images for news + organisation, and the
 * private member-photos bucket for member portraits.
 */
final class NulesmanaMedia
{
    public static function remote(): bool
    {
        return config('filesystems.nulesmana_mode', 'local') === 'supabase';
    }

    public static function newsDisk(): string
    {
        return self::remote() ? 'supabase_news' : 'public';
    }

    public static function memberDisk(): string
    {
        return self::remote() ? 'supabase_members' : 'public';
    }

    public static function organizationDisk(): string
    {
        // Organisation portraits are already public on the NU site.
        return self::newsDisk();
    }

    public static function newsUrl(?string $path): ?string
    {
        if (!filled($path)) {
            return null;
        }
        $path = trim((string) $path);
        if (Str::startsWith($path, ['https://', 'http://', '/'])) {
            return $path;
        }
        if (Str::startsWith($path, 'storage/')) {
            return asset($path);
        }

        return Storage::disk(self::newsDisk())->url($path);
    }

    public static function preferredNewsUrl(?string $path): ?string
    {
        if (!filled($path)) {
            return null;
        }
        $path = trim((string) $path);
        if (!Str::startsWith($path, ['/', 'http://', 'https://', 'storage/']) && preg_match('/\.png$/i', $path)) {
            $webp = preg_replace('/\.png$/i', '.webp', $path);
            if ($webp && Storage::disk(self::newsDisk())->exists($webp)) {
                $path = $webp;
            }
        }
        return self::newsUrl($path);
    }

    /** Do not expose the S3 URL of a private member portrait. */
    public static function memberUrl(?Member $member): ?string
    {
        if (!$member || !filled($member->photo)) {
            return null;
        }
        return route('nulesmana.member-photo', ['member' => $member->id]);
    }
}
