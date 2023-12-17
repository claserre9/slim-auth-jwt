<?php

namespace App\utils\encoders;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTTokenEncoder implements TokenEncoder
{
    public function encode(array $data, string $key): string
    {
        return JWT::encode($data, $key, 'HS256');
    }


    public function decode(string $jwt, string $key): array
    {
        return (array)JWT::decode($jwt, new Key($key, 'HS256'));
    }
}