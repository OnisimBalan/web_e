<?php
 
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Orders;
 
#[Route('/orders')]
class OrdersController extends AbstractController
{
    #[Route('', methods:['get'] )]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $orders = $doctrine
            ->getRepository(Orders::class)
            ->findAll();
   
        $data = [];
   
        foreach ($orders as $order) {
           $data[] = [
            'id' => $order->getId(),
            'product_id' => $order ->getProductId(),
            'quantity' => $order ->getQuantity(),
            'price' => $order ->getPrice(),

           ];
        }
   
        return $this->json($data);
    }
 
 
    #[Route('', methods:['POST'] )]
    public function create(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $entityManager = $doctrine->getManager();
   
        $order = new Orders();
        $order->setPrice($request->request->get('price'));
        $order->setProductId($request->request->get('product_id'));
        $order->setQuantity($request->request->get('quantity'));


   
        $entityManager->persist($order);
        $entityManager->flush();
   
        $data =  [
            'id' => $order->getId(),
            'product_id' => $order ->getProductId(),
            'quantity' => $order ->getQuantity(),
            'price' => $order ->getPrice(),

        ];
           
        return $this->json($data);
    }
 
 
    #[Route('/{id}', methods:['get'] )]
    public function show(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $order = $doctrine->getRepository(Orders::class)->find($id);
   
        if (!$order) {
   
            return $this->json('No user found for id ' . $id, 404);
        }
   
        $data =  [
            'id' => $order->getId(),
            'product_id' => $order ->getProductId(),
            'quantity' => $order ->getQuantity(),
            'price' => $order ->getPrice(),
        ];
           
        return $this->json($data);
    }
 
    #[Route('/{id}', methods:['put', 'patch'] )]
    public function update(ManagerRegistry $doctrine, Request $request, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $order = $entityManager->getRepository(Orders::class)->find($id);
   
        if (!$order) {
            return $this->json('No user found for id' . $id, 404);
        }
   
        $order->setPrice($request->request->get('price'));
        $order->setProductId($request->request->get('product_id'));
        $order->setQuantity($request->request->get('quantity'));

        $entityManager->flush();
   
        $data =  [
            'id' => $order->getId(),
            'product_id' => $order ->getProductId(),
            'quantity' => $order ->getQuantity(),
            'price' => $order ->getPrice(),
        ];
           
        return $this->json($data);
    }
 
    #[Route('/{id}', methods:['delete'] )]
    public function delete(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $order = $entityManager->getRepository(Orders::class)->find($id);
   
        if (!$order) {
            return $this->json('No user found for id' . $id, 404);
        }
   
        $entityManager->remove($order);
        $entityManager->flush();
   
        return $this->json('Deleted a user successfully with id ' . $id);
    }
}