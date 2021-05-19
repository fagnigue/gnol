<?php
// src/Controller/LoginController.php
namespace App\Controller;

use DateTime;
use DateInterval;
use App\Entity\Client;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use App\Repository\ClientRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
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
    public function change_password(Request $request, MailerInterface $mailer): Response
    {
        $traitement = 'forgot_password';
        $otp = rand(10000, 99999);
        $error = null;

        $session = new Session();
        $session->set('otp', $otp);

        

        if (isset($_POST['send'])) {

            $email = strval($request->request->get('email'));
            $session->set('email', $email);

            $entityManager = $this->getDoctrine()->getManager()->getRepository(Client::class);
            $client = $entityManager->findOneBy(['email' => strval($email)]);
            
            if ($client) {
                

                $email_ = (new TemplatedEmail())
                    ->from('devfullcoul@gmail.com')
                    ->to(new Address(strval($email)))
                    ->subject('Gnol Mot de passe oublié')

                    // path of the Twig template to render
                    ->htmlTemplate('emails/traitements.html.twig')

                    ->context([
                        'code' => $otp
                    ]);

                $mailer->send($email_);

                return $this->redirectToRoute('code_send');

            } else {
                $error = "l'utilisateur n'existe pas inscrivez vous";
            }

            
        }

        return $this->render('forgot_password.html.twig', ['error'=>$error]);

    }

    /**
     * @Route("/code_send", name="code_send")
     * 
     */
    public function code_send(Request $request): Response
    {
        $error = null;

        if (isset($_POST['confirm'])) {
            $session = new Session();
            $otp = $session->get('otp');
            $code = $request->request->get('code');
            $error = null;

            if ($otp == intval($code)) {
                $session->remove('otp');
                return $this->redirectToRoute('reset_password');
            } else {
                $error = "code incorrect !";
            }
        }

        return $this->render('code_send.html.twig', ['error'=>$error]);
    }


    /**
     * @Route("/reset_password", name="reset_password")
     * 
     */
    public function reset_password(Request $request, ClientRepository $clientrepository): Response
    {
        $error = null;

        if (isset($_POST['reset_password'])) {

            $password = strval($request->request->get('password'));
            $verif = strval($request->request->get('verif'));
            
            if ($password == $verif) {
                
                $session = new Session();
                $email = strval($session->get('email'));

                $entityManager = $this->getDoctrine()->getManager();
                $client = $entityManager->getRepository(Client::class)->findOneBy(['email' => strval($email)]);

                $client->setPassword($password);

                $entityManager->flush();

                $session->remove('email');

                return $this->redirectToRoute('login_page');

            } else {
                $error = "les mots de passe ne correspondent pas !";
            }
            


        }
        return $this->render('reset_password.html.twig', ['error'=>$error]);
    }


}
