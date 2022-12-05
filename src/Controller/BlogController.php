<?php

namespace App\Controller;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use App\Entity\Commentaire;
use App\Entity\Post;
use App\Form\CommentaireType;
use App\Form\PostType;
use App\Repository\CommentaireRepository;
use App\Repository\PostRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class BlogController extends AbstractController


{
    #[Route('/blog', name: 'blog')]
    public function index(Request $request,PostRepository $repo,PaginatorInterface $paginator): Response
    {
        $posts = $repo->findAll();
        $posts = $paginator->paginate(
            $posts, /* query NOT result */
            $request->query->getInt('page', 1),
            3
        );
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
            $post->setDatePost(date("d-m-Y  / h-i-s  ", strtotime("now ")));
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
    public function show(CommentaireRepository $commentaireRepository,Post $posts,Request $request,ManagerRegistry $managerRegistry)
    {
        $topfan= $commentaireRepository->topfan();
        $inactive= $commentaireRepository->inactive();
        $commentaire = new Commentaire();
        $form = $this->createForm( CommentaireType::class,$commentaire);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
             $commentaire->setDate(date("d-m-Y-  h-i-s       ", strtotime("now ")));
             $commentaire->setPost($posts);
            $em->persist($commentaire);
            $em->flush();

            return $this->redirectToRoute('blog_show',['id'=>$posts->getId()]);
        }


        return $this->render('blog/show.html.twig',[
            'posts' => $posts,
            'topfan' => $topfan,
            'inactive' => $inactive,
            'CommentaireForm' =>$form->createView()
        ]);
    }

    #[Route('/test', name: 'app_test')]
    public function indexx(ChartBuilderInterface $chartBuilder, CommentaireRepository $commentaireRepository): Response
    {

        $comments= $commentaireRepository->findAll();
        $label =[];
        $data=[];
        foreach ($comments as $comment)
        {

            $label[]=$comment->getAutheur();
            $data[]=$comment->getId();
        }
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => $label,
            'datasets' => [
                [
                    'label' => '',
                    'backgroundColor' => 'rgb(255,99,132',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [1,2,3,4,5,6,7,8,9,10],

                ],

            ],
        ]);


        return $this->render('test.html.twig', [
            'chart' => $chart,
        ]);

    }

}
