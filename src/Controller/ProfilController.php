<?php
// src/Controller/ProfilController.php
namespace App\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{

    /**
     *@Route("/profil", name="profil_page"), methods={"POST"}
     *
     */
    public function profil(Request $request, ClientRepository $clientrepository): Response
    {
        $user_id = $request->cookies->get('gnol_user_id');

        if ($user_id) {
            $query = $clientrepository->getOneClientById($user_id);
            $ArrayForSession = $query[0];
                    $session = new Session();
                    $session->set('client_info', $ArrayForSession);
        }

        $entityManager = $this->getDoctrine()->getManager();

        $lastname = "rien";
        if (isset($_POST['submit'])) {
            $id = $request->request->get('id');
            $genre = $request->request->get('selector');
            $lastname = $request->request->get('lastname');
            $firstname = $request->request->get('firstname');
            $email = $request->request->get('email');
            $telephone = $request->request->get('telephone');
            $password = $request->request->get('password');
            $adresse = $request->request->get('adresse');
            $info_sup = $request->request->get('info_sup');

            $client = $entityManager->getRepository(Client::class)->find($id);

            if (!$client) {
                throw $this->createNotFoundException(
                    'No client found for'
                );
            }
    
            $client->setFirstname(strval($firstname));
            $client->setLastname(strval($lastname));
            $client->setEmail(strval($email));
            $client->setTelephone(strval($telephone));
            $client->setPassword(strval($password));
            $client->setAdresse(strval($adresse));
            $client->setInfoSup(strval($info_sup));
            $client->setGenre(strval($genre));
            $entityManager->flush();

            return $this->redirectToRoute($request->get('_route'), $request->query->all());

        }

        

        return $this->render('profil.html.twig');
    }
}
