<?php
// src/Controller/LoginController.php
namespace App\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;
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
    public function login(Request $request): Response
    {

        $email = null;
        $password = null;
        $remember = null;
        $errormail = null;
        $errormdp = null;
        
        if (isset($_POST['submit'])) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $remember = $request->request->has('remember');
        }

        if ($email!=null && $password!=null) {

            $entityManager = $this->getDoctrine()->getManager()->getRepository(Client::class);
            $client = $entityManager->findOneBy(['email' => strval($email)]);
                
            
            if (!$client) {
               
                $errormail = 'pas de client avec cet email ';

            } else {

                $getpassword = $client->getPassword();

                if ($getpassword!=strval($password)) {
                    $errormdp = 'mot de passe incorrect';
                } else {
                    return $this->render('homepage.html.twig');
                    /*return new RedirectResponse($this->urlGenerator->generate('home_page'));*/
                }
            }
        }

        return $this->render('loginpage.html.twig', ['errormail'=>$errormail, 'errormdp'=>$errormdp, 'email'=>$email]);
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
