<?php
namespace App\Config;

class Validator {
    private static array $errors = [];

    public static function reset(): void { 
        self::$errors = []; 
    }

    public static function isEmpty(string $val, string $field, string $msg): void {
        if (empty(trim($val))) {
            self::$errors[$field] = $msg;
        }
    }

    public static function isPositive(string $val, string $field, string $msg): void {
        if (!empty($val) && (float)$val <= 0) {
            self::$errors[$field] = $msg;
        }
    }

    
    public static function isTelephone(string $val, string $field, string $msg): void {
        if (empty(trim($val))) {
            return; 
        }

        $clean = trim($val);

        if (!ctype_digit($clean)) {
            self::$errors[$field] = $msg;
            return;
        }

        $length = strlen($clean);
        if ($length < 7 || $length > 15) {
            self::$errors[$field] = $msg;
        }
    }

    public static function validate(): bool {
        return count(self::$errors) === 0;
    }

    public static function getErrors(): array {
        return self::$errors;
    }
}