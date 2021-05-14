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
     * @Route("/{category}/{souscategory}")
     *
     */
    public function product(ProductRepository $productRepository, string $category, string $souscategory = 'all')
    {
        $sous_category = $productRepository->getsouscategorie($category);
        if ($souscategory == 'all') {
            $product = $productRepository->getProductByCategory($category);
        } else {
            $product = $productRepository->getProductBySouscategory($souscategory);
        }

        if ($category == 'Vin') {

            $template = 'products/vin.html.twig';

        } elseif ($category == 'Champagne') {
            
            $template = 'products/champagne.html.twig';

        } elseif ($category == 'Spiritueux') {

            $template = 'products/spiritueux.html.twig';

        } elseif ($category == 'Accessoire') {
            $template = 'products/accessoires.html.twig';
        }


        return $this->render($template, [
            "category"=>$category,
            "products"=>$product,
            "sous_category"=>$sous_category
        ]);


    }

    

    /**
     * @Route("/{categorie}/description/{id}")
     * 
     */
    public function vin_desc(ProductRepository $productRepository, int $id, string $categorie)
    {
        
        $query = $productRepository->getOneProduct($id);
        $category =  $categorie;

        if ($query) {
            $product = $query[0];
        }

        return $this->render('products/description.html.twig', [
            'product' => $product,
            'category' => $category
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
