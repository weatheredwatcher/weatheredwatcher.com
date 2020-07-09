<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/", name="welcome")
     */
    public function index()
    {
        return $this->render('welcome/index.html.twig', [
            'controller_name' => 'WelcomeController', 'page' => 'index',
        ]);
    }

     /**
     * @Route("/about", name="about")
     */
    public function about()
    {
        return $this->render('welcome/about.html.twig', [
            'controller_name' => 'WelcomeController', 'page' => 'about',
        ]);
    }

    /**
     * @Route("/projects", name="projects")
     */
    public function projects()
    {
        return $this->render('welcome/about.html.twig', [
            'controller_name' => 'WelcomeController', 'page' => 'projects',
        ]);
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function blog()
    {
        return $this->render('welcome/about.html.twig', [
            'controller_name' => 'WelcomeController', 'page' => 'blog',
        ]);
    }
}
