<?php

namespace App\helpers;

use App\utils\uploaders\Uploader;
use Slim\Psr7\UploadedFile;

/**
 * Class UploaderHelpers
 *
 * The UploaderHelpers class provides a helper method for uploading files using the Uploader class.
 */
class UploaderHelpers
{
    protected Uploader $uploader;

    public function __construct(Uploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function upload(string $location, UploadedFile $file): string
    {
        return $this->uploader->upload($location, $file);
    }
}