<?php
// src/Controller/ProductController.php
namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


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
    public function vin_desc(ProductRepository $productRepository, int $id, string $categorie, Request $request)
    {
        
        $query = $productRepository->getOneProduct($id);
        $category =  $categorie;
        $cart = null;

        if ($query) {
            $product = $query[0];
        }

       

        return $this->render('products/description.html.twig', [
            'product' => $product,
            'category' => $category
        ]);
    }
 


}
