<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SalarieController extends AbstractController
{
    /**
     * @Route("/salarie", name="salarie")
     */
    public function index()
    {
        return $this->render('salarie/index.html.twig', [
            'controller_name' => 'SalarieController',
        ]);
    }
}
