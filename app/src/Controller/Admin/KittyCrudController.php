<?php

namespace App\Controller\Admin;

use App\Entity\Kitty;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class KittyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Kitty::class;
    }
}