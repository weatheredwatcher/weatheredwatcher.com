<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Blog;
use App\Form\BlogType;
use App\Repository\BlogRepository;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController', 'page' => 'admin_main'
        ]);
    }

     /**
     * @Route("/admin/users", name="admin_users")
     */
    public function showUsers()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findAll();

        return $this->render('admin/users.html.twig', [
            'controller_name' => 'AdminController', 'page' => 'admin_main', 'users' => $users
        ]);
    }

     /**
     * @Route("/admin/posts", name="posts")
     */
    public function showPosts()
    {
        $repository = $this->getDoctrine()->getRepository(Blog::class);
        $posts = $repository->findAll();

        return $this->render('admin/posts.html.twig', [
            'controller_name' => 'AdminController', 'page' => 'admin_main', 'posts' => $posts
        ]);
    }
}
