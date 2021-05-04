<?php
// src/Controller/ProductController.php
namespace App\Controller;

use App\Repository\ProductRepository;
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
    public function vin(ProductRepository $productRepository): Response
    {
        $vin = $productRepository->getWineProduct();

        return $this->render('products/vin.html.twig', [
            "vin"=>$vin
        ]);
    }

    /**
     *@Route("/champagne")
     *
     */
    public function champagne(ProductRepository $productRepository): Response
    {
        $champagne = $productRepository->getChampagneProduct();

        return $this->render('products/champagne.html.twig', [
            "champagne"=>$champagne
        ]);
    }

    /**
     *@Route("/spiritueux")
     *
     */
    public function spiritueux(ProductRepository $productRepository): Response
    {
        $spiritueux = $productRepository->getSpiritueuxProduct();

        return $this->render('products/spiritueux.html.twig', [
            "spiritueux"=>$spiritueux
        ]);
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
