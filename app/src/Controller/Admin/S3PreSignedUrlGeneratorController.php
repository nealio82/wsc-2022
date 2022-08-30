<?php

namespace App\Controller\Admin;

use Aws\S3\S3Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class S3PreSignedUrlGeneratorController extends AbstractController
{
    public function __construct(
        private readonly S3Client $s3Client,
        private readonly string $uploadsBucket
    )
    {
    }

    #[Route('/admin/generate-upload-url', name: 'admin_generate_upload_url', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $data = \json_decode($request->getContent(), true);

        $cmd = $this->s3Client->getCommand('PutObject', [
            'Bucket' => $this->uploadsBucket,
            'Key' => 'uploads/avatars/' . $data['filename'],
            'ACL' => 'bucket-owner-full-control'
        ]);

        $request = $this->s3Client->createPresignedRequest($cmd, '+20 minutes');

        return new JsonResponse(['url' => (string)$request->getUri()]);
    }
}