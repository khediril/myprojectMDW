<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    //public function list(EntityManagerInterface $entityManager): Response
    public function list(ProductRepository $repos): Response
    {
       // $repos = $entityManager->getRepository(Product::class);
        
        $products = $repos->findAll();
        
        
        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }
}
