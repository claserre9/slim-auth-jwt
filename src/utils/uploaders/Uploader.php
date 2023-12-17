<?php

namespace App\utils;



use Slim\Psr7\UploadedFile;

interface Uploader
{
    public function upload(string $location, UploadedFile $file): string;
}