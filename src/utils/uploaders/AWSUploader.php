<?php

namespace App\utils;

use Aws\S3\S3Client;
use Slim\Psr7\UploadedFile;

class AWSUploader implements Uploader
{
    private S3Client $s3Client;

    public function __construct(S3Client $s3Client)
    {
        $this->s3Client = $s3Client;
    }

    public function upload(string $location, UploadedFile $file): string
    {
        $result = $this->s3Client->putObject(array(
            'Bucket' => 'your-bucket-name',
            'Key'    => $location,
            'Body'   => fopen($file['tmp_name'], 'rb'),
            'ACL'    => 'public-read',
        ));

        return $result['ObjectURL'];
    }
}