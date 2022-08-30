<?php

namespace App\Form;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

class S3PreSignedUploadField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)

            // this template is used in 'index' and 'detail' pages
            ->setTemplatePath('admin/field/s3-upload.html.twig')

            // use a custom form type which will do the S3 pre-signed stuff for us
            ->setFormType(S3PreSignedUrlType::class);
    }

    public function setSignedUrlEndpoint(string $url): self
    {
        $this->setFormTypeOption('attr.signedUrlEndpoint', $url);

        return $this;
    }
}