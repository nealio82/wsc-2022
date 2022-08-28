<?php

namespace App\Controller\Admin;

use Symfony\Component\Asset\Context\RequestStackContext;
use Symfony\Component\Asset\PackageInterface;
use Symfony\Component\Asset\UrlPackage;
use Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy;
use Symfony\Component\HttpFoundation\RequestStack;

class CDNAssetsPackage implements PackageInterface
{
    private PackageInterface $package;

    public function __construct(RequestStack $requestStack, string|array $cdnBaseUrls)
    {
        $this->package = new UrlPackage(
            $cdnBaseUrls,
            new JsonManifestVersionStrategy(__DIR__ . '/../../../vendor/easycorp/easyadmin-bundle/src/Resources/public/manifest.json'),
            new RequestStackContext($requestStack)
        );
    }

    public function getUrl(string $assetPath): string
    {
        return $this->package->getUrl($assetPath);
    }

    public function getVersion(string $assetPath): string
    {
        return $this->package->getVersion($assetPath);
    }
}