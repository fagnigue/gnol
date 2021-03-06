<?php
// src/Controller/SigninController.php
namespace App\Controller;

use App\Entity\Client;
use App\Entity\Country;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SigninController extends AbstractController
{

    /**
     * @Route("/signin"), methods={"POST"}
     * 
     */
    public function signin(Request $request, MailerInterface $mailer): Response
    {
        $nom = null;
        $prenom = null;
        $telephone = null;
        $pays = null;
        $email = null;
        $password = null;
        $conf_password = null;
        $alert = null;
        $errormdp = null;
        $error = null;


        if (isset($_POST['submit'])) {
            $nom = $request->request->get('nom');
            $prenom = $request->request->get('prenom');
            $pays = $request->request->get('pays');
            $telephone = $request->request->get('telephone');
            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $conf_password = $request->request->get('conf_password');
            $accept = $request->request->has('accept');
        }

        if ($password!=null && $conf_password!=null && $nom!=null && $prenom!=null && $telephone!=null && $email!=null && $password!=null && $conf_password!=null && $pays!=null) {

            if (strval($password)!= strval($conf_password)) {
                $errormdp = "les mots de passe ne correspondent pas";
            } else {


                $entityManager = $this->getDoctrine()->getManager();
                $client = $entityManager->getRepository(Client::class)->findOneBy(['email' => strval($email)]);
                $pays = $entityManager->getRepository(Country::class)->find(intval($pays));

                if (!$client) {
                    
                    $client = new Client();
                    $client->setFirstname(strval($prenom));
                    $client->setLastname(strval($nom));
                    $client->setTelephone(strval($telephone));
                    $client->setCountry($pays);
                    $client->setEmail(strval($email));
                    $client->setPassword(strval($password));

                    $entityManager->persist($client);

                    $entityManager->flush();

                    if ($client->getId()) {
                        

                        $email_ = (new TemplatedEmail())
                            ->from('fabien@example.com')
                            ->to(new Address(strval($email)))
                            ->subject('Inscription Gnol')

                            // path of the Twig template to render
                            ->htmlTemplate('emails/signin.html.twig')

                            ->context([
                                'nom' => $nom,
                                'prenom' => $prenom,
                            ]);

                        $mailer->send($email_);


                        //return new RedirectResponse($this->urlGenerator->generate('login_page'));
                        return $this->redirectToRoute('login_page');
                    } else {
                        $alert = "enregitrement ??chou??";
                    }

                } else {
                    $error = "un utilisateur existe d??j?? avec cet email !";
                }


            }

        } else {
            $errormdp = "les mots de passe ne correspondent pas";
        }
        

    return $this->render('signinpage.html.twig', [
        'alert'=>$alert,
        'errormdp'=>$errormdp, 
        'error'=>$error
        ]);
    }
}
