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
        $session = new Session();

        if ($user_id) {

            $query = $clientrepository->getOneClientById($user_id);
            $ArrayForSession = $query[0];
            $session->set('client_info', $ArrayForSession);

        }

        // GET GEOLOCATION
        $ip = $_SERVER['REMOTE_ADDR'];

        $ch = curl_init('http://free.ipwhois.io/json/?objects=country_code,currency_code,currency');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response
        $ipwhois_result = json_decode($json, true);
        $session->set('geolocation', $ipwhois_result);


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
