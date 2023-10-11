<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/article', name: 'article')]
class DefaultController extends AbstractController
{
    #[Route('/default', name: 'app_default')]
    public function index(): Response
    {
        return $this->render('default/default.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
    #[Route('/default2/{a}', name: 'app_default2')]
    public function default($a): Response
    {
        return $this->render('default/default2.html.twig', [
            'a' => $a,
        ]);
    }
    #[Route('/somme/{a}/{b}', name: 'app_somme')]
    public function somme($a,$b): Response
    {
        $som = $a + $b;
        return $this->render('default/somme.html.twig', [
            'a' => $a,'b'=> $b,'som' => $som
        ]);
    }
}
