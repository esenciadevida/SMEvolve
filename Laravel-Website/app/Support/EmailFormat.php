<?php

namespace App\Support;

use Carbon\Carbon;
use DateTimeInterface;

/**
 * Formats values for branded transactional emails. Raw database timestamps
 * are converted to the configured display timezone and labelled with its
 * abbreviation (WAT). Non-date values are returned unchanged.
 */
class EmailFormat
{
    public static function format(mixed $value): string
    {
        if ($value instanceof DateTimeInterface) {
            return self::datetime($value);
        }

        if (! is_string($value)) {
            return (string) $value;
        }

        $value = trim($value);

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/D', $value) === 1) {
            return self::date($value);
        }

        if (preg_match('/^\d{4}-\d{2}-\d{2}[T\s]\d{1,2}:\d{2}(:\d{2})?(\.\d+)?$/', $value) === 1) {
            return self::datetime($value);
        }

        if (preg_match('/^\d{1,2}:\d{2}(:\d{2})?$/', $value) === 1) {
            return self::time($value);
        }

        return $value;
    }

    private static function displayTimezone(): string
    {
        return (string) config('mail.display_timezone', 'Africa/Lagos');
    }

    private static function label(): string
    {
        return (string) config('mail.display_timezone_label', 'WAT');
    }

    private static function parse(mixed $value): Carbon
    {
        return Carbon::parse($value, (string) config('app.timezone', 'UTC'))
            ->setTimezone(self::displayTimezone());
    }

    private static function date(string $value): string
    {
        return self::parse($value)->isoFormat('D MMMM YYYY');
    }

    private static function time(string $value): string
    {
        return self::parse($value)->format('H:i').' '.self::label();
    }

    private static function datetime(mixed $value): string
    {
        return self::parse($value)->format('j M Y, H:i').' '.self::label();
    }
}
