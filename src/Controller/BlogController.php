<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Blog;
use App\Form\BlogType;
use App\Repository\BlogRepository;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Doctrine\Migrations\Configuration\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Carbon\Carbon;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/blog")
 *
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/", name="blog", methods={"GET"})
     * @param int $page
     * @return Response
     */
    public function index($page=1)
    {
        if (isset($_GET['page'])) {$currentPage = $_GET['page'];} else $currentPage = 1;
        $repository = $this->getDoctrine()->getRepository(Blog::class);
        $entries = $repository->getAllPosts($currentPage);

        // You can also call the count methods (check PHPDoc for `paginate()`)
        # Total fetched (ie: `5` posts)
        $totalPostsReturned = $entries->getIterator()->count();

    # Count of ALL posts (ie: `20` posts)
    $totalPosts = $entries->count();

    # ArrayIterator
    $iterator = $entries->getIterator();

        $limit = 5;
        $maxPages = ceil($totalPosts / $limit);
        $thisPage = $page;
        // Pass through the 3 above variables to calculate pages in twig
       // return $this->render('view.twig.html', compact('categories', 'maxPages', 'thisPage'));

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController', 'page' => 'blog', 'entries' => $entries, 'maxPages' => $maxPages, 'thisPage' => $thisPage
        ]);
    }

    /**
     * @Route("/new", name="blog_new", methods={"GET", "POST"})
     * @param Request $request
     * @return Response
     * @IsGranted("ROLE_ADMIN");
     */
    public function new(Request $request) : Response
    {
        $blog = new Blog();
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $created = new Carbon("now");
            $blog->setCreatedAt($created);
            $blog->setUpdatedAt($created);
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($blog);
            $entityManager->flush();

            return $this->redirectToRoute('blog');
        }

        return $this->render('blog/new.html.twig', [
            'blog' => $blog,
            'form' => $form->createView(),
            'page' => 'blog'
        ]);


    }

    /**
     * @Route("/{id}", name="blog_show", methods={"GET"})
     * @param Blog $blog
     * @return Response
     */
    public function show(Blog $blog)
    {
        return $this->render('blog/post.html.twig', ['blog'=> $blog,'page' => 'blog']);
    }

    /**
     * @Route("/edit/{id}", name="blog=edit", methods={"GET", "POST"})
     * @param Blog $blog
     * @param Request $request
     * @return Response
     * @IsGranted("ROLE_ADMIN");
     */
    public function edit(Request $request, Blog $blog)
    {
        $form = $this->createForm(BlogType::class, $blog, ['require_tags' => false, 'require_is_draft' => false]);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
            $created = new Carbon("now");
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($blog);
            $entityManager->flush();

            return $this->redirectToRoute('blog');
        }
    
        return $this->render('blog/edit.html.twig', ['form' => $form->createView(), 'blog' => $blog, 'page' => 'blog']);
    
}

}
