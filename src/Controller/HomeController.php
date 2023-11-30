<?php

namespace App\Controller;

use App\Repository\SquirrelRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SquirrelRepository $squirrelrepository): Response
    {
        $squirrels = $squirrelrepository->findAll();
        return $this->render('home/index.html.twig',
         [
            'squirrels' => $squirrels,
        ]);
    }
}
