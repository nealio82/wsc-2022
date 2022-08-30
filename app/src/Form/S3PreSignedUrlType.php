<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class S3PreSignedUrlType extends AbstractType
{
    public function getBlockPrefix(): string
    {
        return 'pre_signed_url';
    }

    public function getParent(): string
    {
        return HiddenType::class;
    }
}
