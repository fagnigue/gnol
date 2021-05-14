<?php
// src/Controller/LoginController.php
namespace App\Controller;

use DateTime;
use DateInterval;
use App\Entity\Client;
use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LoginController extends AbstractController
{

    /**
     *@Route("/login", name="login_page"), methods={"POST"}
     *
     */
    public function login(Request $request, ClientRepository $clientrepository):Response
    {

        $email = null;
        $password = null;
        $remember = null;
        $errormail = null;
        $errormdp = null;
        $clientId = null;
        $clientid = null;
        
        if (isset($_POST['submit'])) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $remember = $request->request->has('remember');
        }

        if ($email!=null && $password!=null) {

            $entityManager = $this->getDoctrine()->getManager()->getRepository(Client::class);
            $client = $entityManager->findOneBy(['email' => strval($email)]);

            $query = $clientrepository->getOneClient($email);
            $clientId = strval($query[0]['id']);
            
            if (!$client) {
               
                $errormail = 'pas de client avec cet email ';

            } else {

                $getpassword = $client->getPassword();

                if ($getpassword!=strval($password)) {
                    $errormdp = 'mot de passe incorrect';
                } else {

                    $query = $clientrepository->getOneClientById($clientId);
                    $ArrayForSession = $query[0];
                    $session = new Session();
                    $session->set('client_info', $ArrayForSession);

                    if ($remember == 1) {

                        $response = new Response();
                        $expires = time() + 36000; //7884000 (3 mois)
                        $cookie = Cookie::create('gnol_user_id', $clientId, $expires);
                        $response->headers->setCookie($cookie);
                        $response->send();

                    }
                    return $this->redirectToRoute('home_page');
                }
            }
        }

        return $this->render('loginpage.html.twig', [
            'errormail'=>$errormail, 
            'errormdp'=>$errormdp, 
            'email'=>$email,
            'id'=>$clientid
            ]);
    }

    /**
     * @Route("/logout")
     */
    public function logout()
    {
        $response = new Response();
        $response->headers->clearCookie('gnol_user_id');
        $response->send();

        $session = new Session();
        $session->clear();
        return $this->redirectToRoute('home_page');
    }

    /**
     * @Route("/change_password")
     * 
     */
    public function change_password(): Response
    {
        return $this->render('forgot_password.html.twig');
    }

    /**
     * @Route("/code_send")
     * 
     */
    public function code_send(): Response
    {
        return $this->render('code_send.html.twig');
    }


    /**
     * @Route("/valid_code")
     * 
     */
    public function valid_code(): Response
    {
        return $this->render('valid_code.html.twig');
    }

    /**
     * @Route("/reset_password")
     * 
     */
    public function reset_password(): Response
    {
        return $this->render('reset_password.html.twig');
    }


}
