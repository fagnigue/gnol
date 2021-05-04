<?php
// src/Controller/SigninController.php
namespace App\Controller;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SigninController extends AbstractController
{

    /**
     * @Route("/signin"), methods={"POST"}
     * 
     */
    public function signin(Request $request): Response
    {
        $nom = null;
        $prenom = null;
        $telephone = null;
        $email = null;
        $password = null;
        $conf_password = null;
        $alert = null;
        $error = null;


        if (isset($_POST['submit'])) {
            $nom = $request->request->get('nom');
            $prenom = $request->request->get('prenom');
            $telephone = $request->request->get('telephone');
            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $conf_password = $request->request->get('conf_password');
            $accept = $request->request->has('accept');
        }

        if ($password == $conf_password && $nom!=null && $prenom!=null && $telephone!=null && $email!=null && $password!=null && $conf_password!=null) {

            $entityManager = $this->getDoctrine()->getManager();

            $client = new Client();
            $client->setFirstname(strval($prenom));
            $client->setLastname(strval($nom));
            $client->setTelephone(strval($telephone));
            $client->setEmail(strval($email));
            $client->setPassword(strval($password));

            $entityManager->persist($client);

            $entityManager->flush();

            if ($client->getId()) {
                /*return $this->render('loginpage.html.twig');*/
                return new RedirectResponse($this->urlGenerator->generate('login_page'));
            } else {
                $alert = "enregitrement échoué";
            }

        } else {
            $error = "les mots de passe ne correspondent pas";
        }
        

    return $this->render('signinpage.html.twig', ['alert'=>$alert, 'error'=>$error]);
    }
}
