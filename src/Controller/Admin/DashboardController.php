<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\Commande;
use App\Entity\Plat;
use App\Entity\Transporteur;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;


#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {

        // when using legacy admin URLs, use the URL generator to build the needed URL
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);


        // Option 2. Make your dashboard redirect to different pages depending on the user
        if (in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
        }

        if (in_array('ROLE_CHEF', $this->getUser()->getRoles())) {
            return $this->redirect($adminUrlGenerator->setController(PlatCrudController::class)->generateUrl());
        }

        return $this->redirectToRoute('app_home');

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('The District');
    }

    public function configureMenuItems(): iterable
    {
            yield MenuItem::linkToRoute('Page d accueil', 'fa fa-home', 'app_home');


            yield MenuItem::section('chef');
            yield MenuItem::linkToCrud('Catégories', 'fas fa-list', Categorie::class);
            yield MenuItem::linkToCrud('Plats', 'fas fa-list', Plat::class);

            yield MenuItem::section('admin')->setPermission('ROLE_ADMIN');
            yield MenuItem::linkToDashboard('Utilisateurs', 'fas fa-list')->setPermission('ROLE_ADMIN');
            yield MenuItem::linkToCrud('Transporteurs', 'fas fa-list', Transporteur::class)->setPermission('ROLE_ADMIN');
            yield MenuItem::linkToCrud('Commandes', 'fas fa-list', Commande::class)->setPermission('ROLE_ADMIN');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            // this defines the pagination size for all CRUD controllers
            // (each CRUD controller can override this value if needed)
            ->setPaginatorPageSize(15)
        ;
    }






    // https://symfony.com/bundles/EasyAdminBundle/current/dashboards.html#customizing-the-dashboard-contents



}
