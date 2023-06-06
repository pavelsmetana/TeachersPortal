<?php

namespace App\Controller;

use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'user_name' => 'Denis',
            'books' => [
                'Book1',
                'Book2',
                'Book3'
            ]
        ]);
    }

    #[Route('/students', name: 'app_students')]
    public function listStudents(): Response
    {
        $studentRepository = $this->entityManager->getRepository(Student::class);
        $students = $studentRepository->findAll();

        return $this->render('test/students.html.twig', [
            'students' => $students
        ]);
    }

    #[Route('/add-student', name: 'app_add_student')]
    public function addStudent(): Response
    {
        return $this->render('test/addStudent.html.twig');
    }

    #[Route('/save-student', name: 'app_save_student')]
    public function saveStudent(Request $request): Response
    {
        $this->entityManager->persist(new Student($request->get('name')));
        $this->entityManager->flush();

        return new Response();
    }
}
