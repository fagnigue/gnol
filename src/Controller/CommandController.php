<?php
// src/Controller/CommandController.php
namespace App\Controller;

use App\Entity\Client;
use App\Entity\Status;
use App\Entity\Command;
use App\Entity\Product;
use App\Entity\RelayPoint;
use App\Entity\DeliverMode;
use App\Entity\PaymentMode;
use App\Entity\CommandProduct;
use Symfony\Component\Mime\Address;
use App\Repository\RelayPointRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandController extends AbstractController
{

    /**
     *@Route("/command"), methods={"POST"}
     *
     */
    public function home(RelayPointRepository $relaypoint, Request $request, MailerInterface $mailer): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $session = new Session();
        $client = $session->get('client_info');
        $relay_point = null;
        $relaypoint__ = null;
        $pays = null;

        if ($client) {
            $pays = $client['country_id'];
            $relay_point = $relaypoint->GetRelayPointByCountry(intval($pays));
        }

        // SEND COMMAND
        $delivermode = null;
        
        if (isset($_POST['command'])) {

            // get deliver mode and payment mode
            $delivermode = strval($request->request->get('delivermode'));
            $paymentmode = strval($request->request->get('paymentmode'));

            if (!empty($delivermode) && !empty($paymentmode)) {
                

                // get others sessions
                $cart = $session->get('shopping_cart');
                $total_cart = $session->get('total_cart');
                $frais_livraison = $session->get('deliver_price');
                $total_command = $total_cart + $frais_livraison;

                // get client id in session
                $id_client = $client['id'];
                $client_ = $entityManager->getRepository(Client::class)->find(intval($id_client));
                $delivermode_ = $entityManager->getRepository(DeliverMode::class)->findOneBy(['label'=>$delivermode]);
                $paymentmode_ = $entityManager->getRepository(PaymentMode::class)->findOneBy(['label'=>$paymentmode]);
                $status = $entityManager->getRepository(Status::class)->findOneBy(['label'=>'en cours']);

                // set Commands
                $command = new Command();
                $command->setMontant(floatval($total_command));
                $command->setClient($client_);
                $command->setDeliverMode($delivermode_);
                $command->setPaymentMode($paymentmode_);
                $command->setStatus($status);

                if ($delivermode == 'point de relais') {
                    $id_relaypoint = intval($request->request->get('relaypoint'));
                    $relaypoint_ = $entityManager->getRepository(Relaypoint::class)->find($id_relaypoint);
                    $relaypoint__ = $relaypoint_->getLabel();
                    $command->setRelaypoint($relaypoint_);
                }

                $entityManager->persist($command);
                $entityManager->flush();

                // SET COMMAND_PRODUCT 

                if ($command) {

                    foreach ($cart as $value) {
                        //get product id
                        $id_product = intval($value['id']);
                        $new_quantity = intval($value['quantity']) - intval($value['quantity_wanted']); // calculate new quantity in product
                        $product_ = $entityManager->getRepository(Product::class)->find($id_product);

                        $product_->setQuantity($new_quantity);
                        $entityManager->flush();
                        
                        if ($product_) {
                            $command_product = new CommandProduct();
                            $command_product->setCommand($command);
                            $command_product->setProduct($product_);
                            $command_product->setQuantityWanted(intval($value['quantity_wanted']));
                            $entityManager->persist($command_product);
                            $entityManager->flush();

                            
                        }
                        
                    }

                    // SEND MAIL
                    if ($command_product) {
                                

                        $email_ = (new TemplatedEmail())
                            ->from('fabien@example.com')
                            ->to(new Address(strval($client['email'])))
                            ->subject('Inscription Gnol')

                            // path of the Twig template to render
                            ->htmlTemplate('emails/command_validate.html.twig')

                            ->context([
                                'cart' => $cart,
                                'total_cart' => $total_cart,
                                'frais_livraison' => $frais_livraison,
                                'total_command' => $total_command,
                                'delivermode' => $delivermode,
                                'paymentmode' => $paymentmode,
                                'relaypoint' => $relaypoint__
                            ]);

                        $mailer->send($email_);


                    }

                }

                $session->remove('shopping_cart');
                $session->remove('total_cart');
                $session->remove('deliver_price');
                $session->remove('total_command');

                return $this->redirectToRoute('home_page');


            } else {
                // code... error
            }


        }

        

        return $this->render('command.html.twig', [
            'relaypoints'=>$relay_point,
            'pays'=>$pays
        ]);
    }


     /**
     *@Route("/command/delivermode/"), methods={"GET"}
     *
     */
    public function deliver_mode(Request $request)
    {
        $dm = $_GET['delivermode'];
        $entityManager = $this->getDoctrine()->getManager();
        $mode = $entityManager->getRepository(DeliverMode::class)->findOneBy(['label'=>strval($dm)]);
        $deliverprice = $mode->getPrix();

        //return new Response($deliverprice);

        $session = new Session();
        $session->set('deliver_price', $deliverprice);
        $total_cart = $session->get('total_cart');

        $total_cart = intval($deliverprice) + $total_cart;

        return new JsonResponse([
            'deliver_price'=>$deliverprice,
            'total_cart'=>$total_cart
            ]);
    }

}
