<?php

namespace App\utils;
use Exception;
use Slim\Psr7\UploadedFile;

class LocalUploader implements Uploader
{


    /**
     * @throws Exception
     */
    public function upload(string $location, UploadedFile $file): string
    {
        if (!file_exists($location)) {
            mkdir($location, 0755, true);
        }


        // Verify that the upload was successful
        if ($file->getError()!== UPLOAD_ERR_OK) {
            throw new Exception("File upload error: " . $file['error']);
        }


        $extension = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8));

        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $baseDir =pathinfo($location, PATHINFO_BASENAME);

        $file->moveTo($location . DIRECTORY_SEPARATOR . $filename);

        return $baseDir . DIRECTORY_SEPARATOR . $filename;
    }
}