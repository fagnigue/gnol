<?php
// src/Controller/ProductController.php
namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

        if (isset($_POST['add'])) {
            $session = new Session();

            if ($session->get('shopping_cart') && $session->get('total_cart')) {
                $cart = $session->get('shopping_cart');
                $total_cart = floatval($session->get('total_cart'));
            } else {
                $cart = [];
                $total_cart = 0;
            }

            $product_id = $request->request->get('product_id');

            $query = $productRepository->getOneProduct(intval($product_id));

            $elt = $query[0];

            $elt['quantity_wanted']=1;
            $elt['sous_total']= floatval(intval($elt['price'])*intval($elt['quantity_wanted']));

            $total_cart = $elt['sous_total'];
            
            $cart[] = $elt;
            $cart = array_unique($cart, SORT_REGULAR);

            $session->set('shopping_cart', $cart);
            
            $total_cart = 0;
            foreach ($cart as $product) {
                $total_cart += $product['sous_total'];
            }
            $session->set('total_cart', $total_cart);
        
        }

        return $this->render('products/description.html.twig', [
            'product' => $product,
            'cart' => $cart,
            'category' => $category
        ]);
    }


 


}
