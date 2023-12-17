<?php

namespace App\utils;

interface TokenEncoder
{
    public function encode(array $data, string $key): string;
    public function decode(string $jwt, string $key): array;
}
