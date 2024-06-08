<?php
 
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Categories;
 
#[Route('/categories')]
class CategoriesController extends AbstractController
{
    #[Route('', methods:['get'] )]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $categories = $doctrine
            ->getRepository(Categories::class)
            ->findAll();
   
        $data = [];
   
        foreach ($categories as $category) {
           $data[] = [
            'id' => $category->getId(),
            'description' => $category->getDescription(),

           ];
        }
   
        return $this->json($data);
    }
 
 
    #[Route('', methods:['POST'] )]
    public function create(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $entityManager = $doctrine->getManager();
   
        $category = new Categories();
        $category->setDescription($request->request->get('description'));

   
        $entityManager->persist($category);
        $entityManager->flush();
   
        $data =  [
            'id' => $category->getId(),
            'description' => $category->getDescription(),

        ];
           
        return $this->json($data);
    }
 
 
    #[Route('/{id}', methods:['get'] )]
    public function show(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $category = $doctrine->getRepository(Categories::class)->find($id);
   
        if (!$category) {
   
            return $this->json('No user found for id ' . $id, 404);
        }
   
        $data =  [
            'id' => $category->getId(),
            'description' => $category->getDescription(),
        ];
           
        return $this->json($data);
    }
 
    #[Route('/{id}', methods:['put', 'patch'] )]
    public function update(ManagerRegistry $doctrine, Request $request, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $category = $entityManager->getRepository(Categories::class)->find($id);
   
        if (!$category) {
            return $this->json('No user found for id' . $id, 404);
        }
   
        $category->setDescription($request->request->get('description'));

        $entityManager->flush();
   
        $data =  [
            'id' => $category->getId(),
            'description' => $category->getDescription(),
        ];
           
        return $this->json($data);
    }
 
    #[Route('/{id}', methods:['delete'] )]
    public function delete(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $category = $entityManager->getRepository(Categories::class)->find($id);
   
        if (!$category) {
            return $this->json('No user found for id' . $id, 404);
        }
   
        $entityManager->remove($category);
        $entityManager->flush();
   
        return $this->json('Deleted a user successfully with id ' . $id);
    }
}