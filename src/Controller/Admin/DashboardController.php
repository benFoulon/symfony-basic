<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Project;
use App\Entity\SchoolYear;
use App\Controller\Admin\SchoolYearCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        // return parent::index();
        // redirect to some CRUD controller
        // $routeBuilder = $this->get(AdminUrlGenerator::class);
        // return $this->redirect($routeBuilder->setController(SchoolYearCrudController::class)->generateUrl());

        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Symfony Basic');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Users');
        yield MenuItem::linkToCrud('Users', 'fa fa-user', User::class);

        yield MenuItem::section('Project');
        yield MenuItem::linkToCrud('Project', 'fas fa-list-ul', Project::class);

        yield MenuItem::section('School Year');
        yield MenuItem::linkToCrud('School Year', 'fas fa-graduation-cap', SchoolYear::class);
    }
}
