<?php
// src/Controller/ProductController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/products", name="the_products")
 */
class ProductController extends AbstractController
{

    /**
     *@Route("/vin")
     *
     */
    public function vin(): Response
    {

        return $this->render('products/vin.html.twig');
    }

    /**
     *@Route("/champagne")
     *
     */
    public function champagne(): Response
    {

        return $this->render('products/champagne.html.twig');
    }

    /**
     *@Route("/spiritueux")
     *
     */
    public function spiritueux(): Response
    {

        return $this->render('products/spiritueux.html.twig');
    }

    /**
     *@Route("/accessoires")
     *
     */
    public function accessoires(): Response
    {

        return $this->render('products/accessoires.html.twig');
    }

    /**
     * @Route("/vin/{categorie}/description/{nom}")
     * 
     */
    public function vin_desc(string $nom)
    {
        return $this->render('products/description.html.twig', [
            'nom' => $nom,
        ]);
    }

    /**
     * @Route("/spiritueux/{categorie}/description/{nom}")
     * 
     */
    public function spiritueux_desc(string $nom)
    {
        return $this->render('products/description.html.twig', [
            'nom' => $nom,
        ]);
    }

    /**
     * @Route("/champagne/{categorie}/description/{nom}")
     * 
     */
    public function champagne_desc(string $nom)
    {
        return $this->render('products/description.html.twig', [
            'nom' => $nom,
        ]);
    }

    /**
     * @Route("/accessoires/{categorie}/description/{nom}")
     * 
     */
    public function accessoires_desc(string $nom)
    {
        return $this->render('products/description.html.twig', [
            'nom' => $nom,
        ]);
    }

 


}
