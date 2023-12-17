<?php

namespace App\utils\uploaders;



use Slim\Psr7\UploadedFile;

/**
 * Interface for uploading files.
 */
interface Uploader
{
    public function upload(string $location, UploadedFile $file): string;
}