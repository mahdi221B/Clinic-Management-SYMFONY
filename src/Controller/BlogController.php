<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Post;
use App\Form\CommentaireType;
use App\Form\PostType;
use App\Repository\CommentaireRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
use App\Repository\PostRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'blog')]
    public function index(PostRepository $repo): Response
    {
        $posts = $repo->findAll();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'posts' => $posts
        ]);

    }
    #[Route('/', name: 'home')]
        public function home()
    {
        return $this->render('blog/home.html.twig');
    }

    #[Route('/blog/new', name: 'blog_create')]
    #[Route('/blog/{id}/edit', name: 'blog_edit')]
    public function create(Post $post=null,Request $request,ManagerRegistry $managerRegistry, PostRepository $postRepository)
    {
        if (!$post){
        $post = new Post();
        }

        $form= $this->createForm(PostType::class,$post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            if(!$post->getId()){
            $post->setDatePost(date("d-m-Y- h-i-s  ", strtotime("now ")));
            }
            $em->persist($post);
            $em->flush();

        return $this->redirectToRoute('blog_show',['id'=>$post->getId()]);
        }

        return $this->render('blog/create.html.twig',[

            'formPost'=>$form->createView(),
            'editMode' => $post->getId() !==null
        ]);
    }

    #[Route('/blog/{id}', name: 'blog_show')]
    public function show(Post $posts,Request $request,ManagerRegistry $managerRegistry)
    {

        $commentaire = new Commentaire();
        $form = $this->createForm( CommentaireType::class,$commentaire);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
             $commentaire->setDate(date("d-m-Y- h-i-s  ", strtotime("now ")));
             $commentaire->setPost($posts);
            $em->persist($commentaire);
            $em->flush();

            return $this->redirectToRoute('blog_show',['id'=>$posts->getId()]);
        }


        return $this->render('blog/show.html.twig',[
            'posts' => $posts,
            'CommentaireForm' =>$form->createView()
        ]);
    }


}
