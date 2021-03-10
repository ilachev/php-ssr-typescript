<?php

declare(strict_types=1);

namespace App\Controller\Market;

use App\Service\Uploader\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/market/uploads', name: 'market.uploads')]
class UploadsController extends AbstractController
{
    #[Route('/', name: '.upload')]
    public function upload(Request $request, FileUploader $uploader): Response
    {
        $uploaded = $uploader->upload($request->files->get('upload'));

        return $this->json([
            'url' => $uploader->generateUrl(sprintf('%s/%s', $uploaded->getPath(), $uploaded->getName())),
            'fileName' => $uploaded->getName(),
            'uploaded' => true,
        ]);
    }
}
