<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/default', name: 'app_default')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController1111111',
        ]);
    }

    #[Route('/default2', name: 'app_default2')]
    public function index2(): Response
    {
        $tab = ["Ali","Saleh","Sabrine","Moez"];
        $reponse = $this->render('index2.html.twig', [
            'nom' => 'lotfi',"liste" => $tab
        ]);
        return $reponse;
    }

    #[Route('/somme/{a?}/{b?}', name: 'app_somme')]
    public function test($a,$b): Response
    {
        $s = $a + $b;
      /*  $rep = new Response('abc');
        return $rep;*/
      
          return $this->render('somme.html.twig', [
            'a' => $a,'b'=> $b,'som'=>$s
        ]);
    }
}
