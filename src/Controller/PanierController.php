<?php
// src/Controller/PanierController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{

    /**
     *@Route("/panier")
     *
     */
    public function panier(): Response
    {

        return $this->render('panier.html.twig');
    }
}
