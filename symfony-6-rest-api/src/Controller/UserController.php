<?php
 
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
 
#[Route('/users')]
class UserController extends AbstractController
{
    #[Route('', methods:['get'] )]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $users = $doctrine
            ->getRepository(User::class)
            ->findAll();
   
        $data = [];
   
        foreach ($users as $user) {
           $data[] = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'username' => $user->getUsername(),
            'password' => $user->getPassword(),
            'role' => $user->getRole()
           ];
        }
   
        return $this->json($data);
    }
 
 
    #[Route('', methods:['POST'] )]
    public function create(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $entityManager = $doctrine->getManager();
   
        $user = new User();
        $user->setUsername($request->request->get('username'));
        $user->setEmail($request->request->get('email'));
        $user->setUsername($request->request->get('username'));
        $user->setPassword($request->request->get('password'));
        $user->setRole($request->request->get('role'));
   
        $entityManager->persist($user);
        $entityManager->flush();
   
        $data =  [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'username' => $user->getUsername(),
            'password' => $user->getPassword(),
            'role' => $user->getRole()
        ];
           
        return $this->json($data);
    }
 
 
    #[Route('/{id}', methods:['get'] )]
    public function show(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $user = $doctrine->getRepository(User::class)->find($id);
   
        if (!$user) {
   
            return $this->json('No user found for id ' . $id, 404);
        }
   
        $data =  [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'username' => $user->getUsername(),
            'password' => $user->getPassword(),
            'role' => $user->getRole()
        ];
           
        return $this->json($data);
    }
 
    #[Route('/{id}', methods:['put', 'patch'] )]
    public function update(ManagerRegistry $doctrine, Request $request, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);
   
        if (!$user) {
            return $this->json('No user found for id' . $id, 404);
        }
   
        $user->setUsername($request->request->get('username'));
        $user->setEmail($request->request->get('email'));
        $user->setUsername($request->request->get('username'));
        $user->setPassword($request->request->get('password'));
        $user->setRole($request->request->get('role'));
        $entityManager->flush();
   
        $data =  [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'username' => $user->getUsername(),
            'password' => $user->getPassword(),
            'role' => $user->getRole()
        ];
           
        return $this->json($data);
    }
 
    #[Route('/{id}', methods:['delete'] )]
    public function delete(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);
   
        if (!$user) {
            return $this->json('No user found for id' . $id, 404);
        }
   
        $entityManager->remove($user);
        $entityManager->flush();
   
        return $this->json('Deleted a user successfully with id ' . $id);
    }
}