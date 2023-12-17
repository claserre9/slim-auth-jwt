<?php

namespace App\utils\encoders;

interface TokenEncoder
{
    public function encode(array $data, string $key): string;
    public function decode(string $jwt, string $key): array;
}
