<?php

namespace App\Controller\Admin;

use App\Entity\Kitty;
use App\Form\S3PreSignedUploadField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use Symfony\Component\Routing\RouterInterface;

class KittyCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly RouterInterface $router
    )
    {
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->onlyOnIndex();
        yield S3PreSignedUploadField::new('avatarUrl')
            ->setSignedUrlEndpoint($this->router->generate('admin_generate_upload_url'));
        yield Field::new('name');
        yield Field::new('intro');
        yield Field::new('countMatches')->setLabel('Matches');
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->addFormTheme('form/custom_types.html.twig');
    }

    public static function getEntityFqcn(): string
    {
        return Kitty::class;
    }
}