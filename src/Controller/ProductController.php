<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[Route('/product', name: 'product_')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'list')]
    //public function list(EntityManagerInterface $entityManager): Response
    public function list(ProductRepository $repos): Response
    {
       // $repos = $entityManager->getRepository(Product::class);
        
        $products = $repos->findAll();
        
        
        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }
    #[Route('/{id}', name: 'show')]
    //public function list(EntityManagerInterface $entityManager): Response
    public function show(ProductRepository $repos,$id): Response
    {
       // $repos = $entityManager->getRepository(Product::class);
        
        $product = $repos->find($id);
       // dd($product);
      /*  if (!$product) {
            throw $this->createNotFoundException(
                'Id incorrect :'.$id
            );
            
        }*/
        
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }
    #[Route('/new/{name}/{price}', name: 'new')]
    //public function list(EntityManagerInterface $entityManager): Response
    public function add($name,$price,EntityManagerInterface $entityManager): Response
    {
       $product = new Product();
       $product->setName($name);
       $product->setPrice($price);
       $product->setDescription("c'est une promo...");
       $entityManager->persist($product);
       $entityManager->flush();

        // $repos = $entityManager->getRepository(Product::class);
        
       
        
        
        return $this->render('product/add.html.twig', [
            
        ]);
    }
    #[Route('/delete/{id}', name: 'delete')]
    //public function list(EntityManagerInterface $entityManager): Response
    public function delete(ProductRepository $repos,$id,EntityManagerInterface $entityManager): Response
    {
       // $repos = $entityManager->getRepository(Product::class);
        
        $product = $repos->find($id);
       // dd($product);
      /*  if (!$product) {
            throw $this->createNotFoundException(
                'Id incorrect :'.$id
            );
            
        }*/
        $entityManager->remove($product);
        $entityManager->flush();
        return $this->redirectToRoute("app_product");
        
      /*  return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);*/
    }
    
    
}
