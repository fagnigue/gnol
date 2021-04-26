<?php
// src/Controller/CommandController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandController extends AbstractController
{

    /**
     *@Route("/command")
     *
     */
    public function home(): Response
    {

        return $this->render('command.html.twig');
    }
}
