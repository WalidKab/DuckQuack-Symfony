<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Entity\Duck;
use App\Entity\Quack;
use App\Entity\Tag;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        // redirect to some CRUD controller
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(QuackCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('QuackNet');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Quacks','fa fa-file-text', Quack::class)
            ->setController(QuackCrudController::class);
        yield MenuItem::linkToCrud('Utilisateurs','fa fa-user', Duck::class)
        ->setController(DuckCrudController::class);
        yield MenuItem::linkToCrud('Commentaires','fa fa-comments', Comment::class)
            ->setController(CommentCrudController::class);
        yield MenuItem::linkToCrud('Tags','fa fa-tags', Tag::class)
            ->setController(TagCrudController::class);
        MenuItem::linkToCrud('Add Category', 'fa fa-tags', Comment::class)
            ->setAction('new');
    }
}
