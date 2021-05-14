<?php
// src/Controller/HomeController.php
namespace App\Controller;

use App\Entity\Product;
use Doctrine\DBAL\Connection;
use App\Repository\ClientRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{

    /**
     *@Route("/", name="home_page")
     *
     */
    public function home(ProductRepository $productRepository, ClientRepository $clientrepository, Request $request): Response
    {
        $user_id = $request->cookies->get('gnol_user_id');

        if ($user_id) {
            $query = $clientrepository->getOneClientById($user_id);
            $ArrayForSession = $query[0];
                    $session = new Session();
                    $session->set('client_info', $ArrayForSession);
        }


        $vin = $productRepository->getProductByCategory('Vin');
        $champagne = $productRepository->getProductByCategory('Champagne');
        $spiritueux = $productRepository->getProductByCategory('Spiritueux');
        

        return $this->render('homepage.html.twig', [
            "vin"=>$vin,
            "champagne"=>$champagne,
            "spiritueux"=>$spiritueux
            ]);
        
    }

    
}
