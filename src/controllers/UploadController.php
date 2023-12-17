<?php

namespace App\controllers;

use App\entities\User;
use App\helpers\UploaderHelpers;
use App\utils\uploaders\LocalUploader;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpUnauthorizedException;

/**
 * Class UploadController
 *
 * This class handles the upload functionality for files.
 */
class UploadController extends AbstractController
{
    public function upload(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $location = "uploads";
        $serverRoot = $request->getServerParams()["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "public/{$location}";
        $file = $request->getUploadedFiles()['file'];
        $uploaderHelpers = new UploaderHelpers(new LocalUploader());

        $url = $uploaderHelpers->upload($serverRoot, $file);
        // fetch the user
        $user = $this->getEntityManager()->getRepository(User::class)->findOneBy(['email' => $request->getAttribute('username')]);

        if (!$user) {
            throw new HttpUnauthorizedException($request, 'Not authorized');
        }
        $user->setProfilePic($url);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
        return $this->JSONResponse($response, json_encode(["url" => $url]));
    }

}