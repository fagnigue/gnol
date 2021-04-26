<?php
// src/Controller/SigninController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SigninController extends AbstractController
{

    /**
     * @Route("/signin")
     * 
     */
    public function signin(): Response
    {
        return $this->render('signinpage.html.twig');
    }
}
