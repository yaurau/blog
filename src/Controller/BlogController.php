<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\PostRepository;

class BlogController extends AbstractController
{
    public function indexAction()
    {

        $em = $this->getDoctrine()
                    ->getManager();

        $posts = $em->getRepository(Post::class)
                    ->getLatestBlogs();

        return $this->render('Blog/index.html.twig', array(
            'posts' => $posts
        ));
    }
    public function aboutAction()
    {
        return $this->render('Blog/about.html.twig');
    }
    public function sidebarAction()
    {
        $em = $this->getDoctrine()
            ->getManager();

        $tags = $em->getRepository(Post::class)
            ->getTags();

        $tagWeights = $em->getRepository(Post::class)
            ->getTagWeights($tags);


        $commentLimit   = $this->getParameter('blogger_blog.comments.latest_comment_limit');
        $latestComments = $em->getRepository(Comment::class)
            ->getLatestComments($commentLimit);

        return $this->render('Blog/sidebar.html.twig', array(
            'latestComments'    => $latestComments,
            'tags'              => $tagWeights
        ));
    }
}
