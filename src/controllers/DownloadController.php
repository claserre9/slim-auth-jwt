<?php

namespace App\controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SplFileObject;

class DownloadController extends AbstractController
{
    public function downloadCSV(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = [
            ['Column 1', 'Column 2', 'Column 3'],
            ['Row 1 Col 1', 'Row 1 Col 2', 'Row 1 Col 3'],
            ['Row 1 Col 1', 'Row 1 Col 2', 'Row 1 Col 3'],
            ['Row 1 Col 1', 'Row 1 Col 2', 'Row 1 Col 3'],
            // ... more rows ...
        ];

        // Create a SplFileObject for a temporary file
        $file = new SplFileObject('php://temp', 'w+');

        // Write CSV content to the temporary file
        foreach ($data as $row) {
            $file->fputcsv($row);
        }

        // Calculate the size of the stream content and rewind the file pointer
        $file->fseek(0, SEEK_END);
        $size = $file->ftell();
        $file->rewind();

        // Set response headers
        $response = $response->withHeader('Content-Type', 'text/csv');
        $response = $response->withHeader('Content-Disposition', 'attachment; filename="download.csv"');
        $response = $response->withHeader('Content-Length', $size);

        // Write the file content to the response body
        while (!$file->eof()) {
            $response->getBody()->write($file->fgets());
        }

        return $response;

    }
}