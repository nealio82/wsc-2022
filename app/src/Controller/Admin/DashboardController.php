<?php

namespace App\Controller\Admin;

use App\Entity\Kitty;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin_dashboard')]
    public function index(): Response
    {
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

         return $this->redirect($adminUrlGenerator->setController(KittyCrudController::class)->generateUrl());
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::section('Kitties'),
            MenuItem::linkToCrud('Kitties', 'fa fa-tags', Kitty::class),
        ];
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Scratch');
    }
}
