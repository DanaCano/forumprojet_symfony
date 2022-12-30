<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
     //readonly
        private  AdminUrlGenerator $adminUrlGenerator
    )
    {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator->setController(ArticleCrudController::class)
        ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Administration générale');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Mon journal du 5e', 'fa fa-undo', 'app_home');

        yield MenuItem::subMenu('Articles', 'fas fa-newspaper')->setSubItems([
            MenuItem::linkToCrud( 'Tous les articles', 'fas fa-book-reader',  Article::class),
            MenuItem::linkToCrud( 'Ajouter', 'fas fa-plus',  Article::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud( 'Catégories', 'fas fa-list-alt',  Category::class)


        ]);

        yield MenuItem::linkToCrud('Commentaires', 'fas fa-comment', Comment::class);
    }

}






// Option 1. You can make your dashboard redirect to some common page of your backend
//
// $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
// return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

// Option 2. You can make your dashboard redirect to different pages depending on the user
//
// if ('jane' === $this->getUser()->getUsername()) {
//     return $this->redirect('...');
// }

// Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
// (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
//
// return $this->render('some/path/my-dashboard.html.twig');