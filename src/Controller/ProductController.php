<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(ProductRepository $repos): Response
    {
        $products = $repos->findAll() ;
        return $this->render('product/index.html.twig', [
            'produits' => $products,
        ]);
    }

    #[Route('/product/{id}', name: 'app_product_show',requirements: ['id' => '\d+'])]
    public function show(ProductRepository $repos,$id): Response
    {
        $product = $repos->find($id) ;
       /* if (!$product) {
            throw $this->createNotFoundException(
                'ID produit introuvable'.$id
            );
        }*/
        return $this->render('product/show.html.twig', [
            'produit' => $product,
        ]);
    }
    #[Route('/product/add/{name}/{price}/{idcateg}', name: 'app_product_add')]
    public function add(CategorieRepository $repos,EntityManagerInterface $entityManager,$name,$price,$idcateg): Response
    {
        $produit = new Product();
        $produit->setName($name);
        $produit->setPrice($price);
        $produit->setDescription("Bon produit");
        $categorie = $repos->find($idcateg);
        $produit->setCategorie($categorie);
        
        $entityManager->persist($produit);
        $entityManager->flush();
        
        $this->addFlash(
            'notice',
            'Produit ajoute avec succes...'
        );
        return $this->redirectToRoute('app_product');
      /*  return $this->render('product/add.html.twig', [
            'produit' => $produit,
        ]);*/
    }
    #[Route('/product/add2', name: 'app_product_add2')]
    public function add2(CategorieRepository $repos,EntityManagerInterface $entityManager): Response
    {
        $produit = new Product();
        $form = $this->createForm(ProductType::class,$produit);
      
        /* $produit = new Product();
        $produit->setName($name);
        $produit->setPrice($price);
        $produit->setDescription("Bon produit");
        $categorie = $repos->find($idcateg);
        $produit->setCategorie($categorie);
        
        $entityManager->persist($produit);
        $entityManager->flush();
        
        $this->addFlash(
            'notice',
            'Produit ajoute avec succes...'
        );*/
        return $this->render('product/add2.html.twig',['monform'=>$form]);
      /*  return $this->render('product/add.html.twig', [
            'produit' => $produit,
        ]);*/
    }

    #[Route('/product/delete/{id}', name: 'app_product_delete')]
    public function delete(EntityManagerInterface $entityManager,ProductRepository $repos,$id): Response
    {
        $product = $repos->find($id) ;
        $entityManager->remove($product);
        $entityManager->flush();
       /* if (!$product) {
            throw $this->createNotFoundException(
                'ID produit introuvable'.$id
            );
        }*/
        return $this->redirectToRoute('app_product');
    }
    #[Route('/product/update/{id}/{nouvprice}', name: 'app_product_update')]
    public function update(EntityManagerInterface $entityManager,ProductRepository $repos,$id,$nouvprice): Response
    {
        $product = $repos->find($id) ;
        $product->setPrice($nouvprice);
        $entityManager->persist($product);
        $entityManager->flush();
        $this->addFlash(
            'notice',
            'Produit modifie avec succes...'
        );
        
        
        
        return $this->redirectToRoute('app_product');
    }
    
    #[Route('/byprice/{pmin}/{pmax}', name: 'app_product_byprice')]
    public function byPrice(ProductRepository $repos,$pmin,$pmax): Response
    {
        $products = $repos->findByPrice2($pmin,$pmax) ;
        return $this->render('product/byprice.html.twig', [
            'produits' => $products,'pmin'=>$pmin,'pmax'=>$pmax
        ]);
    }
    

}
