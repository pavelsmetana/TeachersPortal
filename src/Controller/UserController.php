<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class UserController extends AbstractController
{
    #[Route('/users', name: 'app_users')]
    public function listUsers(UserRepository $userRepository): Response
    {

        return $this->render('user/list.html.twig', [
            'users' => $userRepository->getByType(User::TYPE_STUDENT, 2, 2)
        ]);
    }

    #[Route('/users-paged', name: 'app_users_paged')]
    public function listUsersPaged(Request $request, UserRepository $userRepository): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $userRepository->getUserPaginator(User::TYPE_STUDENT, $offset);

        return $this->render('user/paged.html.twig', [
            'users' => $paginator,
            'previous' => $offset - UserRepository::PAGINATOR_PER_PAGE,
            'next' => $offset + UserRepository::PAGINATOR_PER_PAGE,
        ]);
    }
}
