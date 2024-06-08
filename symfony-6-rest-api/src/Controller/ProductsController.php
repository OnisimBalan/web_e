<?php
 
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Products;
 
#[Route('/products')]
class ProductsController extends AbstractController
{
    #[Route('', methods:['get'] )]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $users = $doctrine
            ->getRepository(Products::class)
            ->findAll();
   
        $data = [];
   
        foreach ($users as $user) {
           $data[] = [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'price' => $user->getPrice(),
            'desription' => $user->getDesription(),
            'available_quantity' => $user->getAvailableQuantity(),
            'category_id' => $user->getCategoryId(),

           ];
        }
   
        return $this->json($data);
    }
 
 
    #[Route('', methods:['POST'] )]
    public function create(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $entityManager = $doctrine->getManager();
   
        $user = new Products();
        $user->setName($request->request->get('name'));
        $user->setPrice($request->request->get('price'));
        $user->setDesription($request->request->get('desription'));
        $user->setCategoryId($request->request->get('category_id'));
        $user->setAvailableQuantity($request->request->get('available_quantity'));
   
        $entityManager->persist($user);
        $entityManager->flush();
   
        $data =  [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'price' => $user->getPrice(),
            'desription' => $user->getDesription(),
            'available_quantity' => $user->getAvailableQuantity(),
            'category_id' => $user->getCategoryId(),
        ];
           
        return $this->json($data);
    }
 
 
    #[Route('/{id}', methods:['get'] )]
    public function show(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $user = $doctrine->getRepository(Products::class)->find($id);
   
        if (!$user) {
   
            return $this->json('No user found for id ' . $id, 404);
        }
   
        $data =  [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'price' => $user->getPrice(),
            'desription' => $user->getDesription(),
            'available_quantity' => $user->getAvailableQuantity(),
            'category_id' => $user->getCategoryId(),
        ];
           
        return $this->json($data);
    }
 
    #[Route('/{id}', methods:['put', 'patch'] )]
    public function update(ManagerRegistry $doctrine, Request $request, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(Products::class)->find($id);
   
        if (!$user) {
            return $this->json('No user found for id' . $id, 404);
        }
   
        $user->setName($request->request->get('name'));
        $user->setPrice($request->request->get('price'));
        $user->setDesription($request->request->get('desription'));
        $user->setCategoryId($request->request->get('category_id'));
        $user->setAvailableQuantity($request->request->get('available_quantity'));
        $entityManager->flush();
   
        $data =  [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'price' => $user->getPrice(),
            'desription' => $user->getDesription(),
            'available_quantity' => $user->getAvailableQuantity(),
            'category_id' => $user->getCategoryId(),
        ];
           
        return $this->json($data);
    }
 
    #[Route('/{id}', methods:['delete'] )]
    public function delete(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(Products::class)->find($id);
   
        if (!$user) {
            return $this->json('No user found for id' . $id, 404);
        }
   
        $entityManager->remove($user);
        $entityManager->flush();
   
        return $this->json('Deleted a user successfully with id ' . $id);
    }
}