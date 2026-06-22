<?php
namespace App\Config;
use DateTime;

final class DateUtils {
    private function __construct() {
        throw new \Exception('Not implemented');
    }

    public static function toDateTime(string $dateString): DateTime {
        return new DateTime($dateString);
    }

    public static function toString(DateTime $date, string $format = 'd/m/Y H:i'): string {
        return $date->format($format);
    }

    public static function difference(DateTime $old, DateTime $new): int {
        return $new->diff($old)->days;
    }

    public static function formatDateString(string $dateString, string $format = 'd/m/Y H:i'): string {
        return self::toString(self::toDateTime($dateString), $format);
    }
}
