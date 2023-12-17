<?php

namespace App\utils;

class PasswordService
{
    public static function hashPassword(string $plaintextPassword): string
    {
        return password_hash($plaintextPassword, PASSWORD_ARGON2I);
    }

    public static function verifyPassword(string $plaintextPassword, string $hashPassword): bool
    {
        return password_verify($plaintextPassword, $hashPassword);
    }

}