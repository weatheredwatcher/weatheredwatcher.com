<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Blog;
use App\Repository\BlogRepository;


class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Blog::class);
        $entries = $repository->findAll();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController', 'page' => 'blog', 'entries' => $entries
        ]);
    }
}
