<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Post;
use App\Form\CategorieType;
use App\Form\PostType;
use App\Repository\CategorieRepository;
use App\Repository\PostRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BackOfficeController extends AbstractController
{
    #[Route('/blogs2', name: 'app_categorie_index2')]
    public function index(CategorieRepository $categorieRepository)
    {
        $categories= $categorieRepository->findAll();
        return $this->render('back-office/listecategorie.html.twig', array(
            'categories' => $categories
        ));
    }

    #[Route('/categorie2', name: 'app_categorie_new2')]
    public function new(Request $request,ManagerRegistry $managerRegistry, CategorieRepository $categorieRepository)
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute('app_categorie_index2');
        }
        return $this->renderForm('back-office/add.html.twig',array(
            'categorie' => $categorie,
            'form' => $form
        ));
    }
    #[Route('categorie2/{id}', name: 'app_categorie2_delete')]
    public function deletecategorie ($id,CategorieRepository $repository,ManagerRegistry $managerRegistry)
    {
        $categorie = $repository->find($id);
        $repository->remove($categorie);
        $em = $managerRegistry->getManager();
        $em->flush();
        return $this->redirectToRoute("app_categorie_index2");
    }


    #[Route('/updateCategorie2/{id}', name: 'update_categorie2')]
    public function updatecategorie($id,Request $request,  CategorieRepository $repository,ManagerRegistry $managerRegistry)
    {
        $categorie = $repository->find($id);
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->flush();
            return $this->redirectToRoute('app_categorie_index2');
        }
        return $this->renderForm('back-office/update.html.twig',array(
            'categorie' => $categorie,
            'form' => $form
        ));
    }













    #[Route('/blog2', name: 'blog2')]
    public function index2(Request $request,PostRepository $repo,PaginatorInterface $paginator): Response
    {
        $posts = $repo->findAll();
        $posts = $paginator->paginate(
            $posts, /* query NOT result */
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('back-office/listepostes.html.twig', [
            'controller_name' => 'BlogController',
            'posts' => $posts
        ]);

    }





    #[Route('/blog2/new', name: 'blog_create2')]
    #[Route('/blog2/{id}/edit', name: 'blog_edit2')]

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
                $post->setDatePost(date("d-m-Y  / h-i-s  ", strtotime("now ")));
            }
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('blog2',['id'=>$post->getId()]);
        }

        return $this->render('back-office/addpost.html.twig',[

            'formPost'=>$form->createView(),
            'editMode' => $post->getId() !==null
        ]);
    }








    #[Route('/blog2/new', name: 'blog_create2')]
    #[Route('/blog2/{id}/edit', name: 'blog_edit25')]

    public function create1(Post $post=null,Request $request,ManagerRegistry $managerRegistry, PostRepository $postRepository)
    {
        if (!$post){
            $post = new Post();
        }

        $form= $this->createForm(PostType::class,$post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();


            if(!$post->getId()){
                $post->setDatePost(date("d-m-Y  / h-i-s  ", strtotime("now ")));
            }
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('blog2',['id'=>$post->getId()]);
        }

        return $this->render('back-office/addpost.html.twig',[

            'formPost'=>$form->createView(),
            'editMode' => $post->getId() !==null
        ]);
    }


    #[Route('post2/{id}', name: 'app_posts_delete')]
    public function deletepost ($id,PostRepository $repository,ManagerRegistry $managerRegistry)
    {
        $post = $repository->find($id);
        $repository->remove($post);
        $em = $managerRegistry->getManager();
        $em->flush();
        return $this->redirectToRoute("blog2");
    }

}
