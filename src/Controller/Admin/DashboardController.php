<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Client;
use App\Entity\Command;
use App\Entity\Country;
use App\Entity\DeliverMode;
use App\Entity\RelayPoint;
use App\Entity\SousCategory;
use App\Entity\Status;
use App\Entity\PaymentMode;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;


class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/app/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(ProductCrudController::class)->generateUrl());
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('MARCHÉ');
        yield MenuItem::linkToCrud('Categories', 'fa fa-list-alt', Category::class);
        yield MenuItem::linkToCrud('Produits', 'fa fa-wine-bottle', Product::class);
        yield menuItem::linkToCrud('Sous-categorie', 'fa fa-list', SousCategory::class);
        yield MenuItem::section('PROFIL');
        yield MenuItem::linkToCrud('Clients', 'fa fa-user', Client::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class);
        yield MenuItem::section('COMMAND');
        yield MenuItem::linkToCrud('Commandes', 'fa fa-shopping-cart', Command::class);
        yield MenuItem::section('AUTRES');
        yield MenuItem::linkToCrud('Pays', 'fa fa-flag', Country::class);
        yield MenuItem::linkToCrud('Point de relais', 'fa fa-map-marker-alt', RelayPoint::class);
        yield MenuItem::linkToCrud('Statut', 'fa fa-user', Status::class);
        yield MenuItem::linkToCrud('Mode de livraison', 'fa fa-shipping-fast', DeliverMode::class);
        yield MenuItem::linkToCrud('Mode de paiement', 'fa fa-credit-card', PaymentMode::class);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Gnol');

    }

    /*public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linktoDashboard('Dashboard', 'fa fa-home'),
            MenuItem::linkToCrud('Categorie', 'fa fa-tags', Category::class),
            MenuItem::linkToCrud('Produit', 'fa fa-product', Product::class),
            MenuItem::linkToCrud('Utilisateur', 'fa fa-user', User::class)
        ];
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }*/
}
