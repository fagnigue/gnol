<?php
// src/Controller/HomeController.php
namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\DBAL\Connection;


class HomeController extends AbstractController
{

    /**
     *@Route("/", name="home_page")
     *
     */
    public function home(ProductRepository $productRepository): Response
    {

        $vin = $productRepository->getWineProduct();
        $champagne = $productRepository->getChampagneProduct();
        $spiritueux = $productRepository->getSpiritueuxProduct();
        

        return $this->render('homepage.html.twig', [
            "vin"=>$vin,
            "champagne"=>$champagne,
            "spiritueux"=>$spiritueux
            ]);
        
    }

    
}
