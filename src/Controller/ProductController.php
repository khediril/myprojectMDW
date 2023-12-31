<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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


    #[Route('/new', name: 'new_product')]
    //public function list(EntityManagerInterface $entityManager): Response
    public function newProduct(EntityManagerInterface $entityManager,Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class,$product);
        //traitement du formulaire
     //   dd($form);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $product = $form->getData();
           // dd($product);
            $entityManager->persist($product);
            $entityManager->flush();
            $this->addFlash("info","Le produit ".$product->getName()." a ete ajoiute avec succes");
            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('product_list');
        }
             return $this->render('product/newproduct.html.twig', [
            'form' => $form,
        ]);
    }



    #[Route('/byprice/{pmin}/{pmax}', name: 'byprice')]
    //public function list(EntityManagerInterface $entityManager): Response
    public function listByPrice(ProductRepository $repos,$pmin,$pmax): Response
    {
       // $repos = $entityManager->getRepository(Product::class);
        
        $products = $repos->findByPrice2($pmin,$pmax);
        //dd($products);
        
        return $this->render('product/byprice.html.twig', [
            'products' => $products,'min' => $pmin,'max' => $pmax
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
        $this->addFlash("info","Le produit ".$product->getName()." a ete supprime avec succes");
        return $this->redirectToRoute("product_list");
        
      /*  return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);*/
    }
    
    
}
