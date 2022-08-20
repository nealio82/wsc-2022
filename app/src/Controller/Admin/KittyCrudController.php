<?php

namespace App\Controller\Admin;

use App\Entity\Kitty;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class KittyCrudController extends AbstractCrudController
{
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->onlyOnIndex();
        yield ImageField::new('avatarUrl')
            ->setBasePath('uploads/avatars')
            ->setUploadDir('public/uploads/avatars');
        yield Field::new('name');
        yield Field::new('intro');
        yield Field::new('countMatches')->setLabel('Matches');
    }

    public static function getEntityFqcn(): string
    {
        return Kitty::class;
    }
}