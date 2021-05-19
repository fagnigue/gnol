<?php
// src/Controller/PanierController.php
namespace App\Controller;

use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{

    /**
     *@Route("/panier", name="cart_page")
     *
     */
    public function panier(Request $request, ClientRepository $clientrepository, int $index=null): Response
    {
        $session = new Session();
        $shopping_cart = $session->get('shopping_cart');


        if (isset($_POST['clear'])) {
            $session->remove('shopping_cart');
            $session->remove('total_cart');
        }


        return $this->render('panier.html.twig');
    }

    /**
     * @Route("/panier/drop/{index}")
     */
    public function dropProductFromCart(int $index)
    {
        $session = new Session();
        $shopping_cart = $session->get('shopping_cart');

        unset($shopping_cart[$index]);
        $session->set('shopping_cart', $shopping_cart);
            

        return $this->redirectToRoute('cart_page');
    }

    /**
     * @Route("/panier/product_quantity/{type}/{index}")
     */
    public function changeQuantiy(int $index, string $type, Request $request)
    {
        $session = new Session();
        $shopping_cart = $session->get('shopping_cart');
        $product = $shopping_cart[intval($index)];
        $quantity = intval($product['quantity']);
        $quantity_wanted = intval($product['quantity_wanted']);

        if ($type == 'plus') {
            
            if ($quantity > $quantity_wanted) {
                $product['quantity_wanted'] ++;
            }
        }

        if ($type == 'moins') {

            if ($quantity_wanted > 1) {
                $product['quantity_wanted'] -= 1;
            }
        }

        $product['sous_total'] = $product['price'] * $product['quantity_wanted']; 
        $shopping_cart[intval($index)] = $product;

        $total_cart = 0;
        foreach ($shopping_cart as $product) {
            $total_cart += $product['sous_total'];
        }
        $session->set('total_cart', $total_cart);

        $session->set('shopping_cart', $shopping_cart);

        //return $this->redirectToRoute('cart_page');
        return $this->render('panier.html.twig');
    }


}
