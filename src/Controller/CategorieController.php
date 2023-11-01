<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[Route('/categorie', name: 'categorie_')]
class CategorieController extends AbstractController
{
    #[Route('/', name: 'list')]
    //public function list(EntityManagerInterface $entityManager): Response
    public function list(CategorieRepository $repos): Response
    {
       // $repos = $entityManager->getRepository(Categorie::class);
        
        $categories = $repos->findAll();
        
        
        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
        ]);
    }
    #[Route('/{id}', name: 'show')]
    //public function list(EntityManagerInterface $entityManager): Response
    public function show(CategorieRepository $repos,$id): Response
    {
       // $repos = $entityManager->getRepository(Categorie::class);
        
        $categorie = $repos->find($id);
       // dd($categorie);
      /*  if (!$categorie) {
            throw $this->createNotFoundException(
                'Id incorrect :'.$id
            );
            
        }*/
        
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
        ]);
    }
    #[Route('/new/{name}', name: 'new')]
    //public function list(EntityManagerInterface $entityManager): Response
    public function add($name,EntityManagerInterface $entityManager): Response
    {
       $categorie = new Categorie();
       $categorie->setName($name);
       $categorie->setCreatedAt(new \DateTimeImmutable);
       $categorie->setUpdateAt(new \DateTimeImmutable);
       
       $entityManager->persist($categorie);
       $entityManager->flush();

        // $repos = $entityManager->getRepository(Categorie::class);
        
       
        
        
        return $this->render('categorie/add.html.twig', [
            
        ]);
    }
    #[Route('/delete/{id}', name: 'delete')]
    //public function list(EntityManagerInterface $entityManager): Response
    public function delete(CategorieRepository $repos,$id,EntityManagerInterface $entityManager): Response
    {
       // $repos = $entityManager->getRepository(Categorie::class);
        
        $categorie = $repos->find($id);
       // dd($categorie);
      /*  if (!$categorie) {
            throw $this->createNotFoundException(
                'Id incorrect :'.$id
            );
            
        }*/
        $entityManager->remove($categorie);
        $entityManager->flush();
        return $this->redirectToRoute("categorie_list");
        
      /*  return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
        ]);*/
    }
    
}
