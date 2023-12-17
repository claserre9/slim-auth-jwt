<?php

namespace App\helpers;

use App\utils\encoders\TokenEncoder;
use DateTimeImmutable;

/**
 * Class JWTHelpers
 *
 * A class that provides helper methods for encoding and decoding JWT (JSON Web Tokens).
 */
class JWTHelpers
{
    private TokenEncoder $encoder;

    public function __construct(TokenEncoder $encoder)
    {
        $this->encoder = $encoder;
    }

    public function encodeToken(string $key, string $username, int $expireMinutes = 60): string
    {
        $issuedAt = new DateTimeImmutable();
        $data = [
            'iat' => $issuedAt->getTimestamp(),
            'nbf' => $issuedAt->getTimestamp(),
            'exp' => $issuedAt->modify("+$expireMinutes minutes")->getTimestamp(),
            'username' => $username,
        ];
        return $this->encoder->encode($data, $key);
    }

    public function decodeToken(string $jwt, string $key): array
    {
        return $this->encoder->decode($jwt, $key);
    }
}
