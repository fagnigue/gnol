<?php
// src/Controller/LoginController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{

    /**
     *@Route("/login")
     *
     */
    public function login(): Response
    {

        return $this->render('loginpage.html.twig');
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
